<?php
/**
 * Title: Songs Model
 * Purpose: To provide database access for getting, adding, updating, and
 *          deleting songs
 */

namespace songs;

/**
 * Validate a song
 */
function validateSong(array $song)
{
    $errors = array();

    // Ensure a name was submitted
    if (!is_string($song['name']) || $song['name'] == '')
    {
        $errors[] = 'Name is required.';
    }

    // Validate the album id
    if (!is_integer($song['albumId']) || $song['albumId'] < 1)
    {
        $errors[] = 'Album is required.';
    }
    else
    {
        // Ensure the album exists
        global $db;
        $query = 'SELECT id
                  FROM albums
                  WHERE id = :albumId';
        $statement = $db->prepare($query);
        $statement->bindValue(':albumId', $song['albumId']);
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();

        if ($row == FALSE)
        {
            $errors[] = 'That album does not exist.';
        }
    }

    // Ensure the length is valid
    if (!is_integer($song['length']) || $song['length'] <= 0)
    {
        $errors[] = 'Length must be greater than zero.';
    }

    return $errors;
}

/**
 * Get a song based on its id (including contributing artists)
 */
function getSong(int $songId)
{
    global $db;

    // Get the song
    $query = 'SELECT songs.id id, songs.name name, songs.length length,
                     songs.albumId albumId, albums.name albumName,
                     albums.imagePath imagePath
              FROM songs
                  JOIN albums ON songs.albumId = albums.id
              WHERE songs.id = :songId';
    $statement = $db->prepare($query);
    $statement->bindValue(':songId', $songId);
    $statement->execute();
    $song = $statement->fetch();
    $statement->closeCursor();

    if ($song == FALSE) return FALSE;

    // Get the contributing artists based on the album and the artist-song
    // relationships
    $query = 'SELECT artists.id id, artists.name name,
                     artists.imagePath imagePath
              FROM songs
                  JOIN albums ON songs.albumId = albums.id
                  JOIN artists ON albums.artistId = artists.id
              WHERE songs.id = :songId
              UNION
              SELECT artists.id, artists.name, artists.imagePath
              FROM artistsSongs
                  JOIN artists ON artistsSongs.artistId = artists.id
              WHERE artistsSongs.songId = :songId';
    $statement = $db->prepare($query);
    $statement->bindValue(':songId', $songId);
    $statement->execute();
    $artists = $statement->fetchAll();
    $statement->closeCursor();

    $song['artists'] = $artists;

    return $song;
}

/**
 * Get songs based on an array of song ids
 */
function getSongs(array $songIds)
{
    $songs = array();
    foreach ($songIds as $songId)
    {
        $song = getSong($songId);
        if ($song !== FALSE) $songs[] = $song;
    }
    return $songs;
}

/**
 * Get all songs
 */
function getAllSongs()
{
    global $db;

    // Get all song ids
    $query = 'SELECT id
              FROM songs';
    $statement = $db->prepare($query);
    $statement->execute();
    $rows = $statement->fetchAll();
    $statement->closeCursor();

    $ids = array();
    foreach ($rows as $row) $ids[] = $row['id'];

    return getSongs($ids);
}

/**
 * Get all songs with the given album id
 */
function getAlbumSongs(int $albumId)
{
    global $db;

    // Get the song ids
    $query = 'SELECT id
              FROM songs
              WHERE albumId = :albumId';
    $statement = $db->prepare($query);
    $statement->bindValue(':albumId', $albumId);
    $statement->execute();
    $rows = $statement->fetchAll();
    $statement->closeCursor();

    $ids = array();
    foreach ($rows as $row) $ids[] = $row['id'];

    return getSongs($ids);
}

/**
 * Get all songs with the given artist id
 */
function getArtistSongs(int $artistId)
{
    global $db;

    // Get the song ids based on the albums and artist-song relationships
    $query = 'SELECT songs.id
              FROM songs
                  JOIN albums ON songs.albumId = albums.id
                  JOIN artists ON albums.artistId = artists.id
              WHERE artists.id = :artistId
              UNION
              SELECT songId
              FROM artistsSongs
              WHERE artistId = :artistId';
    $statement = $db->prepare($query);
    $statement->bindValue(':artistId', $artistId);
    $statement->execute();
    $rows = $statement->fetchAll();
    $statement->closeCursor();

    $ids = array();
    foreach ($rows as $row) $ids[] = $row['id'];

    return getSongs($ids);
}

/**
 * Calculate the duration of an album in seconds given the album id
 */
function getAlbumLength(int $albumId)
{
    global $db;
    $query = 'SELECT COALESCE(SUM(length), 0) length
              FROM songs
              WHERE albumId = :albumId';
    $statement = $db->prepare($query);
    $statement->bindValue(':albumId', $albumId);
    $statement->execute();
    $length = $statement->fetch()['length'];
    $statement->closeCursor();
    return $length;
}

/**
 * Add a song
 */
function addSong(array $song)
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
 * Update a song
 */
function updateSong(array $song)
{
    global $db;
    $query = 'UPDATE songs
              SET name = :name, length = :length, albumId = :albumId
              WHERE id = :id';
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $song['name']);
    $statement->bindValue(':length', $song['length']);
    $statement->bindValue(':albumId', $song['albumId']);
    $statement->bindValue(':id', $song['id']);
    $statement->execute();
    $statement->closeCursor();
}

/**
 * Delete a song
 */
function deleteSong(array $song)
{
    global $db;
    $query = 'DELETE FROM songs
              WHERE id = :songId';
    $statement = $db->prepare($query);
    $statement->bindValue(':songId', $song['id']);
    $statement->execute();
    $statement->closeCursor();
}
?>
