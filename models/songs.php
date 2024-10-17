<?php
namespace songs;

function getSong(int $songId)
{
    global $db;
    $query = 'SELECT id, name, length, albumId
              FROM songs
              WHERE id = :songId;';
    $statement = $db->prepare($query);
    $statement->bindValue(':songId', $songId);
    $statement->execute();
    $song = $statement->fetch();
    $statement->closeCursor();
    return $song;
}

function getSongsByAlbumId(int $albumId)
{
    global $db;
    $query = 'SELECT id, name, length, albumId
              FROM songs
              WHERE albumId = :albumId;';
    $statement = $db->prepare($query);
    $statement->bindValue(':albumId', $albumId);
    $statement->execute();
    $songs = $statement->fetchAll();
    $statement->closeCursor();
    return $songs;
}

function getSongsByArtistId(int $artistId)
{
    global $db;
    $query = 'SELECT songs.id, songs.name, songs.length, songs.albumId
              FROM songs
                  JOIN artistssongs ON songs.id = artistssongs.songId
                  JOIN artists ON artistssongs.artistId = artists.id
              WHERE artists.id = :artistId;';
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

function updateSong(int $songId, string $name, int $length, int $albumId)
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

function deleteSong(int $songId)
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
