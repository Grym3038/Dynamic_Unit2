<?php
/**
 * Title: Albums Controller
 * Purpose: To view, add, update, and delete albums
 */

switch ($action)
{
    /**
     * List all albums
     */
    case 'listAlbums':
        $albums = albums\getAlbumsWithArtistNames();
        include('views/albums/albums.php');
        exit();

    /**
     * View the details about a specific album
     */
    case 'viewAlbum':
        $albumId = filter_input(INPUT_GET, 'albumId', FILTER_VALIDATE_INT);

        if (!is_integer($albumId) || $albumId < 1) return404();

        $album = albums\getAlbum($albumId);

        if ($album === FALSE) return404();

        $album['length'] = songs\getAlbumLength($album['id']);
        $artist = artists\getArtist($album['artistId']);
        $songs = songs\getSongsByAlbumId($album['id']);
        include('views/albums/albumInfo.php');
        exit();

    /**
     * Render the form for adding or editing an album
     */
    case 'albumForm':
        $albumId = filter_input(INPUT_GET, 'albumId', FILTER_VALIDATE_INT);

        $newAlbum = array(
            'id' => 0,
            'name' => '',
            'artistId' => '',
            'iPath' => ''
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
        include('views/albums/albumForm.php');
        exit();

    /**
     * Accept form data to add or update an album
     */
    case 'editAlbum':
        $albumId = filter_input(INPUT_POST, 'albumId', FILTER_VALIDATE_INT);
        $name = filter_input(INPUT_POST, 'name');
        $artistId = filter_input(INPUT_POST, 'artistId', FILTER_VALIDATE_INT);
        $albumIpath = filter_input(INPUT_POST, 'iPath');

        $album = array(
            'id' => $albumId,
            'name' => $name,
            'artistId' => $artistId,
            'iPath' => $albumIpath
        );

        // Validate the album
        $errors = albums\validateAlbum($album);
        if (count($errors) > 0)
        {
            $artists = artists\getArtists();
            include('views/albums/albumForm.php');
            exit();
        }

        // Add/update the album
        if ($album['id'] == 0)
        {
            $album['id'] = albums\addAlbum($album);
        }
        else
        {
            albums\updateAlbum($album);
        }

        header('Location: .?action=viewAlbum&albumId=' . $album['id']);
        exit();

    /**
     * Render the form to confirm the deletion of an album
     */
    case 'deleteAlbum':
        $albumId = filter_input(INPUT_GET, 'albumId', FILTER_VALIDATE_INT);

        if (!is_integer($albumId) || $albumId < 0) return404();

        $entity = albums\getAlbum($albumId);

        if ($entity === FALSE) return404();

        $entity['type'] = 'album';

        include('views/deleteForm.php');
        exit();
}
