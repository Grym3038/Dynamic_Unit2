<?php
/**
 * Title: Artists-Songs Model
 * Purpose: To provide database access for getting, adding, updating, and
 *          deleting artist-song relationships
 */

namespace artistsSongs;

/**
 * Validate an artist-song relationship
 */
function validateArtistSong(array $artistSong) : array
{
    $errors = array();

    if (!is_integer($artistSong['id']) || $artistSong['id'] < 0)
    {
        $errors[] = 'Invalid artist-song id.';
    }

    if (!is_integer($artistSong['songId']) || $artistSong['songId'] < 1)
    {
        $errors[] = 'Song is required.';
    }

    if (!is_integer($artistSong['artistId']) || $artistSong['artistId'] < 1)
    {
        $errors[] = 'Artist is required.';
    }

    if (count($errors) === 0)
    {
        // Ensure that the artist-song relationship doesn't already exist
        global $db;
        $query = 'SELECT COUNT(*) count
                  FROM artistsSongs
                  WHERE artistId = :artistId
                      AND songId = :songId
                      AND id != :id';
        $statement = $db->prepare($query);
        $statement->bindValue(':artistId', $artistSong['artistId']);
        $statement->bindValue(':songId', $artistSong['songId']);
        $statement->bindValue(':id', $artistSong['id']);
        $statement->execute();
        $count = $statement->fetch()['count'];
        $statement->closeCursor();

        if ($count > 0)
        {
            $errors[] = 'That relationship already exists.';
        }
    }

    return $errors;
}

/**
 * Get all artist-song relationships
 */
function getArtistsSongs() : array
{
    global $db;
    $query = 'SELECT artistsSongs.id, artistId, artists.name artistName,
                     songId, songs.name songName
              FROM artistsSongs
              JOIN artists ON artistsSongs.artistId = artists.id
              JOIN songs ON artistsSongs.songId = songs.id
              ORDER BY LOWER(artists.name), LOWER(songs.name)';
    $statement = $db->prepare($query);
    $statement->execute();
    $artistsSongs = $statement->fetchAll();
    $statement->closeCursor();
    return $artistsSongs;
}

/**
 * Get an artist-song relationship based on its id
 */
function getArtistSong(int $artistSongId) : array | bool
{
    global $db;
    $query = 'SELECT artistsSongs.id, artistId, artists.name artistName,
                     songId, songs.name songName
              FROM artistsSongs
              JOIN artists ON artistsSongs.artistId = artists.id
              JOIN songs ON artistsSongs.songId = songs.id
              WHERE artistsSongs.id = :artistSongId';
    $statement = $db->prepare($query);
    $statement->bindValue(':artistSongId', $artistSongId);
    $statement->execute();
    $artistSong = $statement->fetch();
    $statement->closeCursor();
    return $artistSong;
}

/**
 * Get all songs ids associated with a given artist id
 */
function getSongIdsByArtistId(int $artistId)
{
    global $db;
    $query = 'SELECT songId
              FROM artistsSongs
              WHERE artistId = :artistId';
    $statement = $db->prepare($query);
    $statement->bindValue(':artistId', $artistId);
    $statement->execute();
    $rows = $statement->fetchAll();
    $statement->closeCursor();

    $songIds = array();
    foreach ($rows as $row)
    {
        $songIds[] = $row['songId'];
    }

    return $songIds;
}

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
    foreach ($rows as $row)
    {
        $artistIds[] = $row['artistId'];
    }

    return $artistIds;
}

/**
 * Add an artist-song relationship to the database
 */
function addArtistSong(array $artistSong): int
{
    global $db;
    $query = 'INSERT INTO artistsSongs (artistId, songId)
              VALUES (:artistId, :songId)';
    $statement = $db->prepare($query);
    $statement->bindValue(':artistId', $artistSong['artistId']);
    $statement->bindValue(':songId', $artistSong['songId']);
    $artistSongId = $db->lastInsertId();
    $statement->execute();
    return $artistSongId;
}

/**
 * Update an artist-song relationship in the database
 */
function updateArtistSong(array $artistSong) : void
{
    global $db;
    $query = 'UPDATE artistsSongs
              SET songId = :songId, artistId = :artistId
              WHERE id = :artistSongId';
    $statement = $db->prepare($query);
    $statement->bindValue(':songId', $artistSong['songId']);
    $statement->bindValue(':artistId', $artistSong['artistId']);
    $statement->bindValue(':artistSongId', $artistSong['id']);
    $statement->execute();
    $statement->closeCursor();
}

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

/**
 * Delete an artist-song relationship from the database
 */
function deleteArtistSong(array $artistSong) : void
{
    global $db;
    $query = 'DELETE FROM artistsSongs
              WHERE id = :artistSongId';
    $statement = $db->prepare($query);
    $statement->bindValue(':artistSongId', $artistSong['id']);
    $statement->execute();
    $statement->closeCursor();
}
?>
