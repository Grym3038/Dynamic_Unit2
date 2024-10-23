<?php
/**
 * Title: Songs Controller
 * Purpose: To view, add, update, and delete songs
 */

switch ($action)
{
    /**
     * List all songs
     */
    case 'listSongs':
        $songs = songs\getSongsWithAlbumName();
        include('views/songs/songs.php');
        exit();

    /**
     * View the details about a specific song
     */
    case 'viewSong':
        $songId = filter_input(INPUT_GET, 'songId', FILTER_VALIDATE_INT);

        if (!is_integer($songId) || $songId < 1) return404();

        $song = songs\getSong($songId);

        if ($song === FALSE) return404();

        $album = albums\getAlbum($song['albumId']);
        $artists = artists\getArtistsOfSong($songId);
        include('views/songs/songInfo.php');
        exit();

    /**
     * Render the form for adding or editing a song
     */
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
        include('views/songs/songForm.php');
        exit();

    /**
     * Accept form data to add or update a song
     */
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

        // Validate the song
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

        if ($song['length'] == 0)
        {
            $errors[] = 'Song length must be greater than 0.';
        }

        // Validate the artist ids
        $artistIds = array_keys($artistIdRows);
        $errors = array_merge($errors, artists\validateArtistIds($artistIds));

        if (count($errors) > 0)
        {
            $artists = artists\getArtists();
            $albums = albums\getAlbumsWithArtistNames();
            include('views/songs/songForm.php');
            exit();
        }

        // Add/update the song
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
        exit();

    /**
     * Render the form to confirm the deletion of a song
     */
    case 'deleteSong':
        $songId = filter_input(INPUT_GET, 'songId', FILTER_VALIDATE_INT);

        if (!is_integer($songId) || $songId < 1) return404();

        $entity = songs\getSong($songId);

        if ($entity == FALSE) return404();

        $entity['type'] = 'song';

        include('views/deleteForm.php');
        exit();
}
?>
