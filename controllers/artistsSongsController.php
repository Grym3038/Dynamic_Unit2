<?php
/**
 * Title: Artists-Songs Controller
 * Purpose: To view, add, update, and delete artist-song relationships
 */

switch ($action)
{
    /**
     * List all artist-song relationships
     */
    case 'listArtistsSongs':
        $artistsSongs = artistsSongs\getArtistsSongs();
        include('views/artistsSongs/artistsSongs.php');
        exit();

    /**
     * Render the form for adding or updating an artist-song relationship
     */
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
        include('views/artistsSongs/artistsSongsForm.php');
        exit();

    /**
     * Accept form data to add or update an artist-song relationship
     */
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

        // Validate the artist-song relationship
        $errors = artistsSongs\validateArtistSong($artistSong);
        if (count($errors) > 0)
        {
            $artists = artists\getArtists();
            $songs = songs\getSongs();
            include('views/artistsSongs/artistsSongsForm.php');
            exit();
        }

        // Add/update the artist-song relationship
        if ($artistSong['id'] == 0)
        {
            artistsSongs\addArtistSong($artistSong);
        }
        else
        {
            artistsSongs\updateArtistSong($artistSong);
        }

        header('Location: .?action=listArtistsSongs');
        exit();
}
?>
