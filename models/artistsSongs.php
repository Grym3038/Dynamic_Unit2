<?php
namespace artistsSongs;

function getSongIdsByArtistId(int $artistId)
{
    global $db;
    $query = 'SELECT songId
              FROM artistsSongs
              WHERE artistId = :artistId';
    $statement = $db->prepare($query);
    $statement->bindValue(':artistId', $artistId);
    $statement->execute();
    $songIds = array_values($statement->fetchAll());
    $statement->closeCursor();
    return $songIds;
}

function getArtistIdsBySongId(int $songId)
{
    global $db;
    $query = 'SELECT artistId
              FROM artistsSongs
              WHERE songId = :songId';
    $statement = $db->prepare($query);
    $statement->bindValue(':songId', $songId);
    $statement->execute();
    $artistIds = array_values($statement->fetchAll());
    $statement->closeCursor();
    return $artistIds;
}

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
