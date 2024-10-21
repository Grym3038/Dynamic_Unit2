<?php
switch ($action)
{
    case 'listArtistsSongs':
        $artistsSongs = artistsSongs\getArtistsSongs();
        include('views/artistsSongs/artistsSongs.php');
        exit();

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
            include('views/artistsSongs/artistsSongsForm.php');
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
        exit();
}
?>
