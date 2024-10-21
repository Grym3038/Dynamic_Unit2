<?php
switch($action)
{
    case 'listArtists':
        $artists = artists\getArtists();
        include('views/artists/artists.php');
        exit();

    case 'viewArtist':
        $artistId = filter_input(INPUT_GET, 'artistId', FILTER_VALIDATE_INT);

        if (!is_integer($artistId) || $artistId < 1) return404();

        $artist = artists\getArtist($artistId);

        if ($artist === FALSE) return404();

        $albums = albums\getAlbumsByArtistId($artistId);
        $songs = songs\getSongsByArtistId($artistId);
        include('views/artists/artistInfo.php');
        exit();

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
            include('views/artists/artistForm.php');
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
        exit();

    case 'deleteArtist':
        $artistId = filter_input(INPUT_GET, 'artistId', FILTER_VALIDATE_INT);

        $entity = artists\getArtist($artistId);

        if ($entity === FALSE)
        {
            return404();
        }

        $entity['type'] = 'artist';

        include('views/deleteForm.php');
        exit();
}
