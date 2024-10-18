<?php
namespace songs;

function validateSong(array $song) : array
{
    $errors = array();

    if (!is_string($song['name']) || $song['name'] == '')
    {
        array_push($errors, 'Name is required');
    }

    if (!is_integer($song['length']) || $song['length'] < 0)
    {
        array_push($errors, 'Length must be a positive number.');
    }

    if (!is_integer($song['albumId']) || $song['albumId'] < 0)
    {
        array_push($errors, 'Invalid album id.');
    }

    return $errors;
}

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

function getSong(int $songId) : array
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

    if ($song == FALSE) $song = array();

    return $song;
}

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
