<?php
/**
 * Title: Artists Controller
 * Purpose: To view, add, update, and delete artists
 */

switch($action)
{
    /**
     * List all artists
     */
    case 'listArtists':
        $artists = artists\getArtists();
        include('views/artists/artists.php');
        exit();

    /**
     * View the details about a specific artist
     */
    case 'viewArtist':
        $artistId = filter_input(INPUT_GET, 'artistId', FILTER_VALIDATE_INT);

        if (!is_integer($artistId) || $artistId < 1) return404();

        $artist = artists\getArtist($artistId);

        if ($artist === FALSE) return404();

        $albums = albums\getAlbumsByArtistId($artistId);
        $songs = songs\getSongsByArtistId($artistId);
        include('views/artists/artistInfo.php');
        exit();

    /**
     * Render the form for adding or editing an artist
     */
    case 'artistForm':
        $artistId = filter_input(INPUT_GET, 'artistId', FILTER_VALIDATE_INT);
        
        $newArtist = array(
            'id' => 0,
            'name' => '',
            'monthlyListeners' => '',
            'iPath' => ''
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

        include('views/artists/artistForm.php');
        exit();

    /**
     * Accept form data to add or update an artist
     */
    case 'editArtist':
        $artistId = filter_input(INPUT_POST, 'artistId', FILTER_VALIDATE_INT);
        $name = filter_input(INPUT_POST, 'name');
        $iPath = filter_input(INPUT_POST, 'iPath');
        $monthlyListeners = filter_input(INPUT_POST, 'monthlyListeners',
            FILTER_VALIDATE_INT);

        $artist = array(
            'id' => $artistId,
            'name' => $name,
            'monthlyListeners' => $monthlyListeners,
            'iPath' => $iPath
        );

        // Validate the artist
        $errors = artists\validateArtist($artist);
        if (count($errors) > 0)
        {
            include('views/artists/artistForm.php');
            exit();
        }

        // Add/update the artist
        if ($artist['id'] == 0)
        {
            $artist['id'] = artists\addArtist($artist);
        }
        else
        {
            artists\updateArtist($artist);
        }

        header('Location: .?action=viewArtist&artistId=' . $artist['id']);
        exit();

    /**
     * Render the form to confirm the deletion of an artist
     */
    case 'deleteArtist':
        $artistId = filter_input(INPUT_GET, 'artistId', FILTER_VALIDATE_INT);

        if (!is_integer($artistId) || $artistId < 1)
        {
            return404();
        }

        $entity = artists\getArtist($artistId);

        if ($entity === FALSE)
        {
            return404();
        }

        $entity['type'] = 'artist';

        include('views/deleteForm.php');
        exit();
}
