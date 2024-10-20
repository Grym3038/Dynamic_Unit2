<?php
/**
 * Functions for manipulating songs in the database.
 */

namespace songs;

/**
 * Validate the properties of a song.
 */
function validateSong(array $song) : array
{
    $errors = array();

    if (!is_string($song['name']) || $song['name'] == '')
    {
        $errors[] = 'Name is required';
    }

    if (!is_integer($song['length']) || $song['length'] < 0)
    {
        $errors[] = 'Length must be a positive number.';
    }

    if (!is_integer($song['albumId']) || $song['albumId'] < 0)
    {
        $errors[] = 'Invalid album id.';
    }

    return $errors;
}

/**
 * Get all songs.
 */
function getSongs() : array
{
    global $db;
    $query = 'SELECT id, name, length, albumId
              FROM songs
              ORDER BY LOWER(name)';
    $statement = $db->prepare($query);
    $statement->execute();
    $songs = $statement->fetchAll();
    $statement->closeCursor();
    return $songs;
}

/**
 * Get all songs, including their album names.
 */
function getSongsWithAlbumName() : array
{
    global $db;
    $query = 'SELECT songs.id id, songs.name name, songs.length length,
                     songs.albumId albumId, albums.name albumName
              FROM songs
                  JOIN albums ON songs.albumId = albums.id
              ORDER BY LOWER(songs.name)';
    $statement = $db->prepare($query);
    $statement->execute();
    $songs = $statement->fetchAll();
    $statement->closeCursor();
    return $songs;
}

/**
 * Get a song based on its id.
 */
function getSong(int $songId) : array | bool
{
    global $db;
    $query = 'SELECT id, name, length, albumId
              FROM songs
              WHERE id = :songId';
    $statement = $db->prepare($query);
    $statement->bindValue(':songId', $songId);
    $statement->execute();
    $song = $statement->fetch();
    $statement->closeCursor();

    return $song;
}

/**
 * Get all songs with ids in the given list of ids.
 */
function getSongsBySongIds(array $songIds) : array
{
    if (count($songIds) == 0) return array();

    global $db;

    $idList = implode(',', $songIds); // SQL injection possible?

    $query = "SELECT id, name, length, albumId
              FROM songs
              WHERE id IN ($idList)";

    $statement = $db->prepare($query);
    $statement->execute();
    $songs = $statement->fetchAll();
    $statement->closeCursor();
    return $songs;
}

/**
 * Get all songs with the given album id.
 */
function getSongsByAlbumId(int $albumId) : array
{
    global $db;
    $query = 'SELECT id, name, length, albumId
              FROM songs
              WHERE albumId = :albumId
              ORDER BY LOWER(name)';
    $statement = $db->prepare($query);
    $statement->bindValue(':albumId', $albumId);
    $statement->execute();
    $songs = $statement->fetchAll();
    $statement->closeCursor();
    return $songs;
}

/**
 * Get all songs with the given artist id.
 */
function getSongsByArtistId(int $artistId) : array
{
    global $db;
    $query = 'SELECT songs.id, songs.name, songs.length, songs.albumId
              FROM songs
                  JOIN artistssongs ON songs.id = artistssongs.songId
                  JOIN artists ON artistssongs.artistId = artists.id
              WHERE artists.id = :artistId';
    $statement = $db->prepare($query);
    $statement->bindValue(':artistId', $artistId);
    $statement->execute();
    $songs = $statement->fetchAll();
    $statement->closeCursor();
    return $songs;
}

/**
 * Calculate the duration of an album in seconds given the album id.
 */
function getAlbumLength(int $albumId) : int
{
    global $db;
    $query = 'SELECT COALESCE(SUM(length), 0) length
              FROM songs
              WHERE albumId = :albumId';
    $statement = $db->prepare($query);
    $statement->bindValue(':albumId', $albumId);
    $statement->execute();
    $row = $statement->fetch();
    $statement->closeCursor();
    return $row['length'];
}

/**
 * Add a song.
 * 
 * @return int The id of the new song
 */
function addSong(array $song) : int
{
    global $db;
    $query = 'INSERT INTO songs (name, length, albumId)
              VALUES (:name, :length, :albumId)';
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $song['name']);
    $statement->bindValue(':length', $song['length']);
    $statement->bindValue(':albumId', $song['albumId']);
    $statement->execute();
    $songId = $db->lastInsertId();
    $statement->closeCursor();
    return $songId;
}

/**
 * Update a song.
 */
function updateSong(array $song) : void
{
    global $db;
    $query = 'UPDATE songs
              SET name = :name, length = :length, albumId = :albumId
              WHERE id = :songId';
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $song['name']);
    $statement->bindValue(':length', $song['length']);
    $statement->bindValue(':albumId', $song['albumId']);
    $statement->bindValue(':songId', $song['songId']);
    $statement->execute();
    $statement->closeCursor();
}

/**
 * Delete a song.
 */
function deleteSong(array $song) : void
{
    global $db;
    $query = 'DELETE FROM songs
              WHERE id = :songId';
    $statement = $db->prepare($query);
    $statement->bindValue(':songId', $song['songId']);
    $statement->execute();
    $statement->closeCursor();
}
?>
