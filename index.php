<?php
/*
    Title: Controller
*/

require_once('models/database.php');
require_once('models/artists.php');
require_once('models/albums.php');
require_once('models/songs.php');
require_once('models/artistsSongs.php');

function return404()
{
    $title = '404 Not Found';
    $body = 'That page does not exist';
    include('views/error.php');
    exit();
}

// Start the session
$lifetime = 60 * 60 * 24 * 365; // 1 year in seconds
session_set_cookie_params($lifetime, '/');
session_start();
if (empty($_SESSION['likedSongIds']))
{
    $_SESSION['likedSongIds'] = array();
}

// Get the action
$action = filter_input(INPUT_POST, 'action');
if ($action == NULL)
{
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL)
    {
        $action = 'listArtists';
    }
}

switch ($action)
{
    case 'listArtists':
        $artists = artists\getArtists();
        include('views/artists.php');
        break;

    case 'viewArtist':
        $artistId = filter_input(INPUT_GET, 'artistId', FILTER_VALIDATE_INT);

        if (!is_integer($artistId) || $artistId < 1) return404();

        $artist = artists\getArtist($artistId);

        if ($artist === FALSE) return404();

        $albums = albums\getAlbumsByArtistId($artistId);
        $songs = songs\getSongsByArtistId($artistId);
        include('views/artistInfo.php');
        break;

    case 'artistForm':
        $artistId = filter_input(INPUT_GET, 'artistId', FILTER_VALIDATE_INT);

        $newArtist = array(
            'id' => 0,
            'name' => '',
            'monthlyListeners' => ''
        );

        if (!is_integer($artistId) || $artistId < 0)
        {
            $artist = $newArtist;
        }
        else
        {
            $artist = artists\getArtist($artistId);
            if ($artist === FALSE)
            {
                $artist = $newArtist;
            }
        }

        include('views/artistForm.php');
        break;

    case 'editArtist':
        $artistId = filter_input(INPUT_POST, 'artistId', FILTER_VALIDATE_INT);
        $name = filter_input(INPUT_POST, 'name');
        $monthlyListeners = filter_input(INPUT_POST, 'monthlyListeners',
            FILTER_VALIDATE_INT);

        $artist = array(
            'id' => $artistId,
            'name' => $name,
            'monthlyListeners' => $monthlyListeners
        );

        $errors = artists\validateArtist($artist);
        if (count($errors) > 0)
        {
            include('views/artistForm.php');
            exit();
        }

        if ($artist['id'] == 0)
        {
            $artist['id'] = artists\addArtist($artist);
        }
        else
        {
            artists\updateArtist($artist);
        }

        header('Location: .?action=viewArtist&artistId=' . $artist['id']);
        break;

    case 'deleteArtist':
        $artistId = filter_input(INPUT_GET, 'artistId', FILTER_VALIDATE_INT);

        $entity = artists\getArtist($artistId);

        if ($entity === FALSE)
        {
            include('views/404.php');
            exit();
        }

        $entity['type'] = 'artist';

        include('views/deleteForm.php');
        break;

    case 'listAlbums':
        $albums = albums\getAlbumsWithArtistNames();
        include('views/albums.php');
        break;

    case 'viewAlbum':
        $albumId = filter_input(INPUT_GET, 'albumId', FILTER_VALIDATE_INT);

        if (!is_integer($albumId) || $albumId < 1) return404();

        $album = albums\getAlbum($albumId);

        if ($album === FALSE) return404();

        $album['length'] = songs\getAlbumLength($album['id']);
        $artist = artists\getArtist($album['artistId']);
        $songs = songs\getSongsByAlbumId($album['id']);
        include('views/albumInfo.php');
        break;

    case 'albumForm':
        $albumId = filter_input(INPUT_GET, 'albumId', FILTER_VALIDATE_INT);

        $newAlbum = array(
            'id' => 0,
            'name' => '',
            'artistId' => ''
        );

        if (!is_integer($albumId) || $albumId < 0)
        {
            $album = $newAlbum;
        }
        else
        {
            $album = albums\getAlbum($albumId);
            if ($album === FALSE)
            {
                $album = $newAlbum;
            }
        }

        $artists = artists\getArtists();
        include('views/albumForm.php');
        break;

    case 'editAlbum':
        $albumId = filter_input(INPUT_POST, 'albumId', FILTER_VALIDATE_INT);
        $name = filter_input(INPUT_POST, 'name');
        $artistId = filter_input(INPUT_POST, 'artistId', FILTER_VALIDATE_INT);

        $album = array(
            'id' => $albumId,
            'name' => $name,
            'artistId' => $artistId
        );

        $errors = albums\validateAlbum($album);
        if (count($errors) > 0)
        {
            $artists = artists\getArtists();
            include('views/albumForm.php');
            exit();
        }

        if ($album['id'] == 0)
        {
            $album['id'] = albums\addAlbum($album);
        }
        else
        {
            albums\updateAlbum($album);
        }

        header('Location: .?action=viewAlbum&albumId=' . $album['id']);
        break;

    case 'deleteAlbum':
        $albumId = filter_input(INPUT_GET, 'albumId', FILTER_VALIDATE_INT);

        if (!is_integer($albumId) || $albumId < 0) return404();

        $entity = albums\getAlbum($albumId);

        if ($entity === FALSE) return404();

        $entity['type'] = 'album';

        include('views/deleteForm.php');
        break;

    case 'viewSong':
        $songId = filter_input(INPUT_GET, 'songId', FILTER_VALIDATE_INT);

        if (!is_integer($songId) || $songId < 1) return404();

        $song = songs\getSong($songId);

        if ($song === FALSE) return404();

        $album = albums\getAlbum($song['albumId']);
        $artists = artists\getArtistsOfSong($songId);
        include('views/songInfo.php');
        break;
    
    case 'listSongs':
        $songs = songs\getSongsWithAlbumName();
        include('views/songs.php');
        break;

    case 'songForm':
        $songId = filter_input(INPUT_GET, 'songId', FILTER_VALIDATE_INT);
        
        $newSong = array(
            'id' => 0,
            'name' => '',
            'length' => 0,
            'albumId' => ''
        );

        if (!is_integer($songId) || $songId < 0)
        {
            $song = $newSong;
            $artistIds = array();
        }
        else
        {
            $song = songs\getSong($songId);
            if ($song === FALSE)
            {
                $song = $newSong;
                $artistIds = array();
            }
            else
            {
                $artistIds = artistsSongs\getArtistIdsBySongId($songId);
            }
        }

        $albums = albums\getAlbumsWithArtistNames();
        $artists = artists\getArtists();
        include('views/songForm.php');
        break;

    case 'editSong':
        $songId = filter_input(INPUT_POST, 'songId', FILTER_VALIDATE_INT);
        $name = filter_input(INPUT_POST, 'name');
        $albumId = filter_input(INPUT_POST, 'albumId', FILTER_VALIDATE_INT);
        $minutes = filter_input(INPUT_POST, 'minutes', FILTER_VALIDATE_INT);
        $seconds = filter_input(INPUT_POST, 'seconds', FILTER_VALIDATE_INT);
        $artistIdRows = filter_input(INPUT_POST, 'artistIds', FILTER_DEFAULT,
            FILTER_REQUIRE_ARRAY);

        $song = array(
            'id' => $songId,
            'name' => $name,
            'length' => 0,
            'albumId' => $albumId
        );

        $errors = songs\validateSong($song);

        if (!is_integer($minutes) || $minutes < 0)
        {
            $errors[] = 'Minutes must a positive number.';
            $minutes = 0;
        }

        if (!is_integer($seconds) || $seconds < 0)
        {
            $errors[] = 'Seconds must be a positive number.';
            $seconds = 0;
        }

        if (!is_array($artistIdRows) || count($artistIdRows) == 0)
        {
            $errors[] = 'Please select at least one contributing artist.';
            $artistIdRows = array();
        }

        $song['length'] = $minutes * 60 + $seconds;
        $artistIds = array_keys($artistIdRows);

        if (count($errors) > 0)
        {
            $artists = artists\getArtists();
            $albums = albums\getAlbumsWithArtistNames();
            include('views/songForm.php');
            exit();
        }

        // Add/edit the song
        if ($song['id'] == 0)
        {
            $song['id'] = songs\addSong($song);
        }
        else
        {
            songs\updateSong($song);
        }

        // Set the song's authorship
        artistsSongs\updateArtistsSongs($song['id'], $artistIds);

        header('Location: .?action=viewSong&songId=' . $song['id']);
        break;

    case 'deleteSong':
        $songId = filter_input(INPUT_GET, 'songId', FILTER_VALIDATE_INT);

        if (!is_integer($songId) || $songId < 1) return404();

        $entity = songs\getSong($songId);

        if ($entity == FALSE) return404();

        $entity['type'] = 'song';

        include('views/deleteForm.php');
        break;

    case 'listArtistsSongs':
        $artistsSongs = artistsSongs\getArtistsSongs();
        include('views/artistsSongs.php');
        break;

    case 'artistsSongsForm':
        $artistSongId = filter_input(INPUT_GET, 'artistSongId',
            FILTER_VALIDATE_INT);
        
        $newArtistSong = array(
            'id' => 0,
            'songId' => 0,
            'artistId' => 0
        );

        if (!is_integer($artistSongId) || $artistSongId < 0)
        {
            $artistSong = $newArtistSong;
        }
        else
        {
            $artistSong = artistsSongs\getArtistSong($artistSongId);
            if ($artistSong === FALSE)
            {
                $artistSong = $newArtistSong;
            }
        }

        $artists = artists\getArtists();
        $songs = songs\getSongs();
        include('views/artistsSongsForm.php');
        break;

    case 'editArtistSong':
        $artistSongId = filter_input(INPUT_POST, 'artistSongId',
            FILTER_VALIDATE_INT);
        $artistId = filter_input(INPUT_POST, 'artistId', FILTER_VALIDATE_INT);
        $songId = filter_input(INPUT_POST, 'songId', FILTER_VALIDATE_INT);

        $artistSong = array(
            'id' => $artistSongId,
            'artistId' => $artistId,
            'songId' => $songId
        );

        $errors = artistsSongs\validateArtistSong($artistSong);

        if (count($errors) > 0)
        {
            $artists = artists\getArtists();
            $songs = songs\getSongs();
            include('views/artistsSongsForm.php');
            exit();
        }

        if ($artistSong['id'] == 0)
        {
            artistsSongs\addArtistSong($artistSong);
        }
        else
        {
            artistsSongs\updateArtistSong($artistSong);
        }

        header('Location: .?action=listArtistsSongs');
        break;

    case 'deleteEntity':
        $entityType = filter_input(INPUT_POST, 'entityType');
        $entityId = filter_input(INPUT_POST, 'entityId', FILTER_VALIDATE_INT);

        $validTypes = array('artist', 'album', 'song', 'artistSong');

        $isValidType = in_array($entityType, $validTypes);
        $isValidId = is_integer($entityId) && $entityId > 0;

        if (!$isValidType || !$isValidId)
        {
            header('Location: .');
            exit();
        }

        switch ($entityType)
        {
            case 'artist':
                $entity = artists\getArtist($entityId);
                break;
            case 'album':
                $entity = albums\getAlbum($entityId);
                break;
            case 'song':
                $entity = songs\getSong($entityId);
                break;
            case 'artistSong':
                $entity = artistsSongs\getArtistSong($entityId);
                break;
        }

        if ($entity === FALSE) return404();

        switch ($entityType)
        {
            case 'artist':
                artists\deleteArtist($entity);
                header('Location: .?action=listArtists');
                break;
            case 'album':
                albums\deleteAlbum($entity);
                header('Location: .?action=listAlbums');
                break;
            case 'song':
                songs\deleteSong($entity);
                header('Location: .?action=listSongs');
                break;
            case 'artistSong':
                artistsSongs\deleteArtistSong($entity);
                header('Location: .?action=listArtistsSongs');
                break;
        }
        break;

    case 'listLikedSongs':
        $songs = songs\getSongsBySongIds($_SESSION['likedSongIds']);
        include('views/likedSongs.php');
        break;
    
    case 'toggleFavorite':
        $songId = filter_input(INPUT_POST, 'songId', FILTER_VALIDATE_INT);

        if ($songId === NULL ||
            $songId === FALSE ||
            songs\getSong($songId) === NULL)
        {
            header('Location: .?action=listSongs');
            exit();
        }

        if (in_array($songId, $_SESSION['likedSongIds']))
        {
            $_SESSION['likedSongIds'] = array_diff($_SESSION['likedSongIds'],
                [$songId]);
        }
        else
        {
            $_SESSION['likedSongIds'][] = $songId;
        }

        header('Location: .?action=listLikedSongs');
        break;
    
    case 'clearLikedSongs':
        $_SESSION['likedSongIds'] = array();
        header('Location: .?action=listLikedSongs');
        break;
    
    default:
        $title = '404 Not Found';
        $body = 'That page does not exist.';
        include('views/error.php');
        break;
}
?>
