<?php
/*
    Title: Controller
*/

require('models/database.php');
require('models/artists.php');
require('models/albums.php');
require('models/songs.php');
require('models/artistsSongs.php');

// Start the session

$lifetime = 60 * 60 * 24 * 365; // 1 year in seconds
session_set_cookie_params($lifetime, '/');
session_start();

if (empty($_SESSION['favoriteSongs']))
{
    $_SESSION['favoriteSongs'] = array();
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
        if ($artistId == NULL || $artistId == FALSE)
        {
            $title = '404 Not Found';
            $body = 'That pages does not exist.';
            include('views/error.php');
            exit();
        }
        $artist = artists\getArtist($artistId);
        $albums = albums\getAlbumsByArtistId($artistId);
        $songs = songs\getSongsByArtistId($artistId);
        include('views/artistInfo.php');
        break;

    case 'artistForm':
        $artistId = filter_input(INPUT_GET, 'artistId', FILTER_VALIDATE_INT);
        if ($artistId != NULL || $artistId != FALSE)
        {
            $artist = artists\getArtist($artistId);
        }
        include('views/artistForm.php');
        break;

    case 'editArtist':
        $artistId = filter_input(INPUT_POST, 'artistId', FILTER_VALIDATE_INT);
        $name = filter_input(INPUT_POST, 'name');
        $monthlyListeners = filter_input(INPUT_POST, 'monthlyListeners',
            FILTER_VALIDATE_INT);

        $errors = array();
        if ($name === NULL || $name === '')
            array_push($errors, 'Name is required.');
        if ($monthlyListeners === NULL || $monthlyListeners === FALSE)
            array_push($errors, 'Monthly listeners is required.');
        
        if (count($errors) > 0)
        {
            $artist = array(
                'id' => $artistId,
                'name' => $name,
                'monthlyListeners' => $monthlyListeners
            );
            include('views/artistForm.php');
            exit();
        }

        if ($artistId == 0)
        {
            $artistId = artists\addArtist($name, $monthlyListeners);
        }
        else
        {
            artists\updateArtist($artistId, $name, $monthlyListeners);
        }

        header('Location: .?action=viewArtist&artistId=' . $artistId);
        break;

    case 'listAlbums':
        $albums = albums\getAlbumsWithArtistNames();
        include('views/albums.php');
        break;

    case 'viewAlbum':
        $albumId = filter_input(INPUT_GET, 'albumId', FILTER_VALIDATE_INT);
        if ($albumId == NULL || $albumId == FALSE)
        {
            include('views/404.php');
            exit();
        }
        $album = albums\getAlbum($albumId);
        $artist = artists\getArtist($album['artistId']);
        $songs = songs\getSongsByAlbumId($albumId);
        include('views/albumInfo.php');
        break;

    case 'albumForm':
        $artists = artists\getArtists();
        include('views/albumForm.php');
        break;

    case 'editAlbum':
        $albumId = filter_input(INPUT_POST, 'albumId', FILTER_VALIDATE_INT);
        $name = filter_input(INPUT_POST, 'name');
        $artistId = filter_input(INPUT_POST, 'artistId', FILTER_VALIDATE_INT);

        $errors = array();
        if ($albumId === NULL || $albumId === FALSE)
            array_push($errors, 'Invalid album id.');
        if ($name === NULL || $name == '')
            array_push($errors, 'Album name is required.');
        if ($artistId === NULL || $artistId === FALSE ||
            artists\getArtist($artistId) === NULL)
            array_push($errors, 'Invalid artist.');
        
        if (count($errors) > 0)
        {
            $album = array(
                'id' => $albumId,
                'name' => $name,
                'artistId' => $artistId
            );
            $artists = artists\getArtists();
            include('views/albumForm.php');
            exit();
        }

        if ($albumId === 0)
        {
            $albumId = albums\addAlbum($name, $artistId);
        }
        else
        {
            albums\updateAlbum($albumId, $name, $albumId);
        }

        header('Location: .?action=viewAlbum&albumId=' . $albumId);

        break;

    case 'viewSong':
        $songId = filter_input(INPUT_GET, 'songId', FILTER_VALIDATE_INT);
        if ($songId == NULL || $songId == FALSE)
        {
            $title = '404 Not Found';
            $body = 'That page does not exist.';
            include('views/error.php');
            exit();
        }
        $song = songs\getSong($songId);
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
        
        if ($songId === NULL || $songId === FALSE) $songId = 0;

        $song = songs\getSong($songId);

        if (!$song)
        {
            $song = array(
                'id' => 0,
                'name' => '',
                'length' => 0,
                'albumId' => ''
            );
            $contributingArtistIds = array();
        }
        else
        {
            $contributingArtistIds = artistsSongs\getArtistIdsBySongId($songId);
        }

        $albums = albums\getAlbumsWithArtistNames();
        $artists = artists\getArtists();
        include('views/songForm.php');
        break;

    case 'editSong':
        $songId = filter_input(INPUT_POST, 'songId', FILTER_VALIDATE_INT);
        $name = filter_input(INPUT_POST, 'name');
        $albumId = filter_input(INPUT_POST, 'albumId');
        $minutes = filter_input(INPUT_POST, 'minutes', FILTER_VALIDATE_INT);
        $seconds = filter_input(INPUT_POST, 'seconds', FILTER_VALIDATE_INT);
        $contributingArtistIds = filter_input(INPUT_POST,
            'contributingArtistIds', FILTER_VALIDATE_BOOL,
            FILTER_REQUIRE_ARRAY);

        /* Validation */

        $errors = array();

        if ($songId === NULL || $songId === FALSE)
            array_push($errors, 'Song id is required.');

        if ($name === NULL || $name === '')
            array_push($errors, 'Song name is required.');

        if ($albumId === NULL || $albumId === FALSE)
            array_pust($errors, 'Album is required.');

        if ($minutes === NULL || $minutes === FALSE)
        {
            array_push($errors, 'Minutes must be a positive, whole number.');
            $minutes = 0;
        }

        if ($seconds === NULL || $seconds === FALSE)
        {
            array_push($errors, 'Seconds must be a positive, whole number.');
            $seconds = 0;
        }
        
        if ($minutes == 0 && $seconds == 0)
        {
            array_push($errors, 'Duration must be greater than zero.');
        }

        if ($contributingArtistIds === NULL || $contributingArtistIds === FALSE)
        {
            array_push($errors, 'Please select at least one contributing artist.');
            $contributingArtistIds = array();
        }

        $length = $minutes * 60 + $seconds;
        $contributingArtistIds = array_keys($contributingArtistIds);

        if (count($errors) > 0)
        {
            $song = array(
                'id' => $songId,
                'name' => $name,
                'length' => $length
            );
            $artists = artists\getArtists();
            $albums = albums\getAlbumsWithArtistNames();
            include('views/songForm.php');
            exit();
        }

        // Add/edit the song

        if ($songId == 0)
        {
            $songId = songs\addSong($name, $length, $albumId);
        }
        else
        {
            songs\updateSong($songId, $name, $length, $albumId);
        }

        // Set the song's authorship
        artistsSongs\updateArtistsSongs($songId, $contributingArtistIds);

        header('Location: .?action=viewSong&songId=' . $songId);
        break;

    case 'deleteForm':
        $entityType = filter_input(INPUT_GET, 'entityType');
        $entityId = filter_input(INPUT_GET, 'entityId', FILTER_VALIDATE_INT);

        if (!in_array($entityType, ['artist', 'album', 'song']) ||
            $entityId === NULL || $entityId == FALSE)
        {
            header('Location: .');
            exit();
        }

        include('views/deleteForm.php');
        break;

    case 'deleteEntity':
        $entityType = filter_input(INPUT_POST, 'entityType');
        $entityId = filter_input(INPUT_POST, 'entityId', FILTER_VALIDATE_INT);

        if (!in_array($entityType, ['artist', 'album', 'song']) ||
            $entityId === NULL || $entityId == FALSE)
        {
            header('Location: .');
            exit();
        }

        if ($entityType == 'artist')
        {
            $entity = artists\getArtist($entityId);
        }
        else if ($entityType == 'album')
        {
            $entity = albums\getAlbum($entityId);
        }
        else if ($entityType == 'song')
        {
            $entity = songs\getSong($entityId);
        }

        if ($entity === NULL)
        {
            $title = 'Error';
            $body = 'That ' . $entityType . ' does not exist.';
            include('views/error.php');
            exit();
        }

        switch ($entityType)
        {
            case 'artist':
                artists\deleteArtist($entityId);
                header('Location: .?action=listArtists');
                break;
            case 'album':
                albums\deleteAlbum($entityId);
                header('Location: .?action=listAlbums');
                break;
            case 'song':
                songs\deleteSong($entityId);
                header('Location: .?action=listSongs');
                break;
            default:
                $title = 'Error';
                $body = 'Invalid submission';
                include('views/errors.php');
                break;
        }
        break;

    case 'listFavorites':
        include('views/favorites.php');
        break;
    
    case 'addFavorite':
        $songId = filter_input(INPUT_POST, 'songId', FILTER_VALIDATE_INT);

        if ($songId === NULL || $songId === FALSE ||
            songs\getSong($songId) == NULL)
        {
            header('Location: .?action=listSongs');
        }
        else
        {
            array_push($_SESSION['favoriteSongs'], $songId);
            header('Location: .?action=viewSong&songId=' . $songId);
        }

        break;
    
    default:
        $title = '404 Not Found';
        $body = 'That page does not exist.';
        include('views/error.php');
        break;
}
?>
