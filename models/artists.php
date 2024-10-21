<?php
namespace artists;

function validateArtist(array $artist) : array
{
    $errors = array();

    if (!is_string($artist['name']) || $artist['name'] == '')
    {
        $errors[] = 'Name is required.';
    }

    if (!is_integer($artist['monthlyListeners']) ||
        $artist['monthlyListeners'] < 0)
    {
        $errors[] = 'Monthly listeners must be a positive number.';
    }

    return $errors;
}

function getArtists() : array
{
    global $db;
    $query = 'SELECT id, name, monthlyListeners
              FROM artists
              ORDER BY LOWER(name)';
    $statement = $db->prepare($query);
    $statement->execute();
    $artists = $statement->fetchAll();
    $statement->closeCursor();
    return $artists;
}

function getArtist(int $artistId) : array | bool
{
    global $db;
    $query = 'SELECT id, name, monthlyListeners
              FROM artists
              WHERE id = :artistId';
    $statement = $db->prepare($query);
    $statement->bindValue(':artistId', $artistId);
    $statement->execute();
    $artist = $statement->fetch();
    $statement->closeCursor();
    return $artist;
}

function getArtistsOfSong(int $songId) : array
{
    global $db;
    $query = 'SELECT artists.id, artists.name, artists.monthlyListeners
              FROM artists
                  JOIN artistsSongs ON artists.id = artistsSongs.artistId
                  JOIN songs ON artistsSongs.songId = songs.Id
              WHERE songs.id = :songId
              ORDER BY LOWER(artists.name)';
    $statement = $db->prepare($query);
    $statement->bindValue(':songId', $songId);
    $statement->execute();
    $artists = $statement->fetchAll();
    $statement->closeCursor();
    return $artists;
}

function addArtist(array $artist) : int
{
    global $db;
    $query = 'INSERT INTO artists (name, monthlyListeners)
              VALUES (:name, :monthlyListeners);';
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $artist['name']);
    $statement->bindValue(':monthlyListeners', $artist['monthlyListeners']);
    $statement->execute();
    $artistId = $db->lastInsertId();
    $statement->closeCursor();
    return $artistId;
}

function updateArtist(array $artist) : void
{
    global $db;
    $query = 'UPDATE artists
              SET name = :name, monthlyListeners = :monthlyListeners
              WHERE id = :artistId;';
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $artist['name']);
    $statement->bindValue(':monthlyListeners', $artist['monthlyListeners']);
    $statement->bindValue(':artistId', $artist['id']);
    $statement->execute();
    $statement->closeCursor();
}

function deleteArtist(array $artist) : void
{
    global $db;
    $query = 'DELETE FROM artists
              WHERE id = :artistId;';
    $statement = $db->prepare($query);
    $statement->bindValue(':artistId', $artist['id']);
    $statement->execute();
    $statement->closeCursor();
}
?>
