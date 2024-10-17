<?php
namespace artists;

function getArtists()
{
    global $db;
    $query = 'SELECT id, name, monthlyListeners
              FROM artists
              ORDER BY LOWER(name);';
    $statement = $db->prepare($query);
    $statement->execute();
    $artists = $statement->fetchAll();
    $statement->closeCursor();
    return $artists;
}

function getArtist(int $artistId)
{
    global $db;
    $query = 'SELECT id, name, monthlyListeners
              FROM artists
              WHERE id = :artistId;';
    $statement = $db->prepare($query);
    $statement->bindValue(':artistId', $artistId);
    $statement->execute();
    $artist = $statement->fetch();
    $statement->closeCursor();
    return $artist;
}

function getArtistsOfSong(int $songId)
{
    global $db;
    $query = 'SELECT artists.id, artists.name, artists.monthlyListeners
              FROM artists
                  JOIN artistsSongs ON artists.id = artistsSongs.artistId
                  JOIN songs ON artistsSongs.songId = songs.Id
              WHERE songs.id = :songId;';
    $statement = $db->prepare($query);
    $statement->bindValue(':songId', $songId);
    $statement->execute();
    $artists = $statement->fetchAll();
    $statement->closeCursor();
    return $artists;
}

function addArtist(string $name, int $monthlyListeners) : string
{
    global $db;
    $query = 'INSERT INTO artists (name, monthlyListeners)
              VALUES (:name, :monthlyListeners);';
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':monthlyListeners', $monthlyListeners);
    $statement->execute();
    $artistId = $db->lastInsertId();
    $statement->closeCursor();
    return $artistId;
}

function updateArtist(int $artistId, string $name, $monthlyListeners)
{
    global $db;
    $query = 'UPDATE artists
              SET name = :name, monthlyListeners = :monthlyListeners
              WHERE id = :artistId;';
        $statement = $db->prepare($query);
        $statement->bindValue(':name', $name);
        $statement->bindValue(':monthlyListeners', $monthlyListeners);
        $statement->bindValue(':artistId', $artistId);
        $statement->execute();
        $statement->closeCursor();
}

function deleteArtist(int $artistId)
{
    global $db;
    $query = 'DELETE FROM artists
              WHERE id = :artistId;';
    $statement = $db->prepare($query);
    $statement->bindValue(':artistId', $artistId);
    $statement->execute();
    $statement->closeCursor();
}
?>
