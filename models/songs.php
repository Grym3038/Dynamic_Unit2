<?php
namespace songs;

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

function addSong(string $name, int $length, int $albumId) : int
{
    global $db;
    $query = 'INSERT INTO songs (name, length, albumId)
              VALUES (:name, :length, :albumId)';
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':length', $length);
    $statement->bindValue(':albumId', $albumId);
    $statement->execute();
    $songId = $db->lastInsertId();
    $statement->closeCursor();
    return $songId;
}

function updateSong(int $songId, string $name, int $length, int $albumId) : void
{
    global $db;
    $query = 'UPDATE songs
              SET name = :name, length = :length, albumId = :albumId
              WHERE id = :songId';
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':length', $length);
    $statement->bindValue(':albumId', $albumId);
    $statement->bindValue(':songId', $songId);
    $statement->execute();
    $statement->closeCursor();
}

function deleteSong(int $songId) : void
{
    global $db;
    $query = 'DELETE FROM songs
              WHERE id = :songId';
    $statement = $db->prepare($query);
    $statement->bindValue(':songId', $songId);
    $statement->execute();
    $statement->closeCursor();
}
?>
