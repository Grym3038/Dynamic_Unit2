<?php
/**
 * Title: Liked Songs Controller
 * Purpsose: To like songs, unlike songs, and view liked songs
 */

switch ($action)
{
    /**
     * List all liked songs
     */
    case 'listLikedSongs':
        $songs = songs\getSongsBySongIds($_SESSION['likedSongIds']);
        include('views/likedSongs.php');
        exit();
    
    /**
     * Toggle whether a song is liked or unliked
     */
    case 'toggleFavorite':
        $songId = filter_input(INPUT_POST, 'songId', FILTER_VALIDATE_INT);
        $redirectTo = filter_input(INPUT_POST, 'redirectTo');

        if ($songId === NULL || $songId === FALSE ||
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

        header('Location: ' . $redirectTo);
        exit();
    
    /**
     * Clear the array of liked songs
     */
    case 'clearLikedSongs':
        $_SESSION['likedSongIds'] = array();
        header('Location: .?action=listLikedSongs');
        exit();
}
?>
