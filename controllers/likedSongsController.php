<?php
switch ($action)
{
    case 'listLikedSongs':
        $songs = songs\getSongsBySongIds($_SESSION['likedSongIds']);
        include('views/likedSongs.php');
        exit();
    
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
        exit();
    
    case 'clearLikedSongs':
        $_SESSION['likedSongIds'] = array();
        header('Location: .?action=listLikedSongs');
        exit();
}
?>
