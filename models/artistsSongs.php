<?php
/**
 * Title: Artists-Songs Model
 * Purpose: To provide database access for updating artist-song relationships
 */

namespace artistsSongs;

/**
 * Regenerate the artist-song relationships for a given song given the song id
 * and all artist ids the song should be associated with
 */
function updateArtistsSongs(int $songId, array $artistIds)
{
    global $db;
    $query = 'DELETE FROM artistsSongs
              WHERE songId = :songId';
    $statement = $db->prepare($query);
    $statement->bindValue(':songId', $songId);
    $statement->execute();
    
    foreach ($artistIds as $artistId)
    {
        $query = 'INSERT INTO artistsSongs (artistId, songId)
                  VALUES (:artistId, :songId)';
        $statement = $db->prepare($query);
        $statement->bindValue(':artistId', $artistId);
        $statement->bindValue(':songId', $songId);
        $statement->execute();
    }

    $statement->closeCursor();
}
?>
