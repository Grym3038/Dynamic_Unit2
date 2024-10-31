<?php
/**
 * Title: Artists-Songs Model
 * Purpose: To provide database access for getting and updating artist-song
 *          relationships
 */

namespace artistsSongs;

/**
 * Get all artist ids associated with a given song id
 */
function getArtistIdsBySongId(int $songId) : array
{
    global $db;
    $query = 'SELECT artistId
              FROM artistsSongs
              WHERE songId = :songId';
    $statement = $db->prepare($query);
    $statement->bindValue(':songId', $songId);
    $statement->execute();
    $rows = $statement->fetchAll();
    $statement->closeCursor();

    $artistIds = array();
    foreach ($rows as $row) $artistIds[] = $row['artistId'];

    return $artistIds;
}

/**
 * Regenerate the artist-song relationships for a song given the song id and all
 * artist ids the song should be associated with
 */
function updateArtistsSongs(int $songId, array $artistIds) : void
{
    global $db;

    // Delete the previous artist-song relationships
    $query = 'DELETE FROM artistsSongs
              WHERE songId = :songId';
    $statement = $db->prepare($query);
    $statement->bindValue(':songId', $songId);
    $statement->execute();
    
    // Add the new artist-song relationships
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
