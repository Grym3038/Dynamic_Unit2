<?php
/**
 * Title: Liked Songs Controller
 * Purpose: To like songs, unlike songs, and view liked songs
 */

switch ($action)
{
    /**
     * List all liked songs
     */
    case 'listLikedSongs':
        $songs = songs\getSongs($_SESSION['likedSongIds']);
        include('views/likedSongs.php');
        exit();
    
    /**
     * Toggle whether a song is liked or unliked
     */
    case 'toggleLiked':
        $songId = filter_input(INPUT_POST, 'songId', FILTER_VALIDATE_INT);
        $redirectTo = filter_input(INPUT_POST, 'redirectTo');

        // Validate the song id
        if (!is_integer($songId) || $songId < 1 ||
            songs\getSong($songId) === FALSE)
        {
            header('Location: .?action=listSongs');
            exit();
        }

        $isSongLiked = in_array($songId, $_SESSION['likedSongIds']);
        if ($isSongLiked)
        {
            // Unlike the song
            $newLikedSongs = array_diff($_SESSION['likedSongIds'], [$songId]);
            $_SESSION['likedSongIds'] = $newLikedSongs;
        }
        else
        {
            // Like the song
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
