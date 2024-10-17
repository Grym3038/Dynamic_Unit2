<?php
/*
    Title: Controller
*/

require('models/database.php');
require('models/artists.php');
require('models/albums.php');
require('models/songs.php');

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
    
    case 'songForm':
        $albums = albums\getAlbums();
        $artists = artists\getArtists();
        include('views/songForm.php');
        break;

    case 'editSong':
        $songId = filter_input(INPUT_POST, 'songId', FILTER_VALIDATE_INT);
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

        switch ($entityType)
        {
            case 'artist':
                $entityName = artists\getArtist($entityId)['name'];
                break;
            case 'album':
                $entityName = albums\getAlbum($entityId)['name'];
                break;
            case 'song':
                $entityName = albums\getSong($entityId)['name'];
                break;
        }

        include('views/deleteForm.php');
        break;
    case 'deleteEntity':
        $entityType = filter_input(INPUT_POST, 'entityType');
        $entityId = filter_input(INPUT_POST, 'entityId', FILTER_VALIDATE_INT);

        switch ($entityType)
        {
            case 'artist':
                artists\deleteArtist($entityId);
                header('Location: .');
                break;
            case 'album':
                albums\deleteAlbum($entityId);
                header('Location: .');
                break;
            case 'song':
                songs\deleteSong($entityId);
                break;
            default:
                $title = 'Error';
                $body = 'Invalid submission';
                include('views/errors.php');
        }

        break;
    default:
        $title = '404 Not Found';
        $body = 'That page does not exist.';
        include('views/error.php');
        break;
}
?>
