<?php
namespace albums;

function getAlbum(int $albumId)
{
    global $db;
    $query = 'SELECT id, name, artistId
              FROM albums
              WHERE id = :albumId';
    $statement = $db->prepare($query);
    $statement->bindValue(':albumId', $albumId);
    $statement->execute();
    $album = $statement->fetch();
    $statement->closeCursor();
    return $album;
}

function getAlbums()
{
    global $db;
    $query = 'SELECT id, name, artistId
              FROM albums
              ORDER BY LOWER(name)';
    $statement = $db->prepare($query);
    $statement->execute();
    $albums = $statement->fetchAll();
    $statement->closeCursor();
    return $albums;
}

function getAlbumsByArtistId(int $artistId)
{
    global $db;
    $query = 'SELECT id, name
              FROM albums
              WHERE artistId = :artistId';
    $statement = $db->prepare($query);
    $statement->bindValue(':artistId', $artistId);
    $statement->execute();
    $albums = $statement->fetchAll();
    $statement->closeCursor();
    return $albums;
}

function addAlbum(string $name, int $artistId)
{
    global $db;
    $query = 'INSERT INTO albums (name, artistId)
              VALUES (:name, :artistId)';
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':artistId', $artistId);
    $statement->execute();
    $albumId = $db->lastInsertId();
    $statement->closeCursor();
    return $albumId;
}

function updateAlbum(int $albumId, string $name, int $artistId)
{
    global $db;
    $query = 'UPDATE albums
              SET name = :name, artistId = :artistId
              WHERE id = :albumId';
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':artistId', $artistId);
    $statement->bindValue(':albumId', $albumId);
    $statement->execute();
    $statement->closeCursor();
}

function deleteAlbum(int $albumId) : bool
{
    global $db;
    $query = 'DELETE FROM albums
              WHERE id = :albumId';
    $statement = $db->prepare($query);
    $statement->bindValue(':albumId', $albumId);
    $statement->execute();
    $statement->closeCursor();
}
?>
