<?php
/**
 * Title: Artists Model
 * Purpose: To provide database access for getting, adding, updating, and
 *          deleting artists
 */

namespace artists;

/**
 * Validate an artist
 */
function validateArtist(array $artist)
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

/**
 * Get all artists
 */
function getArtists() 
{
    global $db;
    $query = 'SELECT id, name, monthlyListeners, iPath
              FROM artists
              ORDER BY LOWER(name)';
    $statement = $db->prepare($query);
    $statement->execute();
    $artists = $statement->fetchAll();
    $statement->closeCursor();
    return $artists;
}

/**
 * Get an artist based on its id
 */
function getArtist(int $artistId)
{
    global $db;
    $query = 'SELECT id, name, monthlyListeners, iPath
              FROM artists
              WHERE id = :artistId';
    $statement = $db->prepare($query);
    $statement->bindValue(':artistId', $artistId);
    $statement->execute();
    $artist = $statement->fetch();
    $statement->closeCursor();
    return $artist;
}

/**
 * Get all artists associated with a given song
 */
function getArtistsOfSong(int $songId) : array
{
    global $db;
    $query = 'SELECT artists.id, artists.name, artists.monthlyListeners, artists.iPath
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

/**
 * Add an artist to the database
 */
function addArtist(array $artist) : int
{
    global $db;
    $query = 'INSERT INTO artists (name, monthlyListeners, iPath)
              VALUES (:name, :monthlyListeners, :iPath);';
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $artist['name']);
    $statement->bindValue(':monthlyListeners', $artist['monthlyListeners']);
    $statement->bindValue(':iPath', $artist['iPath']);
    $statement->execute();
    $artistId = $db->lastInsertId();
    $statement->closeCursor();
    return $artistId;
}

/**
 * Update an artist in the database
 */
function updateArtist(array $artist) : void
{
    global $db;
    $query = 'UPDATE artists
              SET name = :name, monthlyListeners = :monthlyListeners, iPath = :iPath
              WHERE id = :artistId;';
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $artist['name']);
    $statement->bindValue(':monthlyListeners', $artist['monthlyListeners']);
    $statement->bindValue(':artistId', $artist['id']);
    $statement->bindValue(':iPath', $artist['iPath']);

    $statement->execute();
    $statement->closeCursor();
}

/**
 * Delete an artist from the database
 */
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
