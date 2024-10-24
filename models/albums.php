<?php
/**
 * Title: Albums Model
 * Purpose: To provide database access for getting, adding, updating, and
 *          deleting albums
 */

namespace albums;

/**
 * Validate an album
 */
function validateAlbum(array $album) : array
{
    global $db;
    $errors = array();
    
    // Ensure a name was submitted
    if (!is_string($album['name']) || $album['name'] == '')
    {
        $errors[] = 'Name is required';
    }
    else
    {
        // Ensure the artist does not already have an album with the same name
        $query = 'SELECT COUNT(*) count
                  FROM albums
                  WHERE name = :name
                      AND artistId = :artistId
                      AND id != :id';
        $statement = $db->prepare($query);
        $statement->bindValue(':name', $album['name']);
        $statement->bindValue(':artistId', $album['artistId']);
        $statement->bindValue(':id', $album['id']);
        $statement->execute();
        $count = $statment->fetch()['count'];
        $statement->closeCursor();

        if ($count > 0)
        {
            $errors[] = 'The artist already has an album by that name.'
        }
    }

    // Ensure an artist id was submitted
    if (!is_integer($album['artistId']) || $album['artistId'] < 0)
    {
        $errors[] = 'Invalid artist Id.';
    }
    else
    {
        // Ensure the artist exists
        $query = 'SELECT id
                  FROM artists
                  WHERE id = :artistId';
        $statement = $db->prepare($query);
        $statement->bindValue(':artistId', $album['artistId']);
        $statement->execute();
        $artistId = $statement->fetch();

        if ($artistId == FALSE)
        {
            $errors[] = 'That artist does not exist.';
        }
    }

    return $errors;
}

/**
 * Get all albums, including their artist names
 */
function getAllAlbums() : array
{
    global $db;
    $query = 'SELECT albums.id id, albums.name name, albums.artistId artistId,
                     albums.imagePath imagePath, artists.name artistName
              FROM albums
                  JOIN artists ON albums.artistId = artists.id
              ORDER BY LOWER(albums.name)';
    $statement = $db->prepare($query);
    $statement->execute();
    $albums = $statement->fetchAll();
    $statement->closeCursor();
    return $albums;
}

/**
 * Get an album based on its id, including its artist name
 */
function getAlbum(int $albumId) : array 
{
    global $db;
    $query = 'SELECT albums.id id, albums.name name, albums.artistId artistId,
                     albums.imagePath imagePath, artists.name artistName
              FROM albums
                  JOIN artists ON albums.artistId = artists.id
              WHERE id = :albumId';
    $statement = $db->prepare($query);
    $statement->bindValue(':albumId', $albumId);
    $statement->execute();
    $album = $statement->fetch();
    $statement->closeCursor();
    return $album;
}

/**
 * Get all albums associated with a given artist
 */
function getArtistAlbums(int $artistId) : array
{
    global $db;
    $query = 'SELECT albums.id id, albums.name name, albums.artistId artistId,
                     albums.imagePath imagePath, artists.name artistName
              FROM albums
                  JOIN artists ON albums.artistId = artists.id
              WHERE artistId = :artistId';
    $statement = $db->prepare($query);
    $statement->bindValue(':artistId', $artistId);
    $statement->execute();
    $albums = $statement->fetchAll();
    $statement->closeCursor();
    return $albums;
}

/**
 * Add an album to the database
 */
function addAlbum(array $album) : int
{
    global $db;
    $query = 'INSERT INTO albums (name, artistId, imagePath)
              VALUES (:name, :artistId, :imagePath)';
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $album['name']);
    $statement->bindValue(':artistId', $album['artistId']);
    $statement->bindValue(':imagePath', $album['imagePath']);
    $statement->execute();
    $albumId = $db->lastInsertId();
    $statement->closeCursor();
    return $albumId;
}

/**
 * Update an album in the database
 */
function updateAlbum(array $album) : void
{
    global $db;
    $query = 'UPDATE albums
              SET name = :name, artistId = :artistId, imagePath = :imagePath
              WHERE id = :albumId';
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $album['name']);
    $statement->bindValue(':artistId', $album['artistId']);
    $statement->bindValue(':albumId', $album['id']);
    $statement->bindValue(':imagePath', $album['imagePath']);
    $statement->execute();
    $statement->closeCursor();
}

/**
 * Delete an album from the database
 */
function deleteAlbum(array $album) : void
{
    global $db;
    $query = 'DELETE FROM albums
              WHERE id = :albumId';
    $statement = $db->prepare($query);
    $statement->bindValue(':albumId', $album['id']);
    $statement->execute();
    $statement->closeCursor();
}
?>
