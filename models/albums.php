<?php
namespace albums;

function validateAlbum(array $album) : array
{
    $errors = array();
    
    if (!is_string($album['name']) || $album['name'] == '')
    {
        $errors[] = 'Name is required';
    }

    if (!is_integer($album['artistId']) || $album['artistId'] < 0)
    {
        $errors[] = 'Invalid artist Id.';
    }

    return $errors;
}

function getAlbum(int $albumId) 
{
    global $db;
    $query = 'SELECT id, name, artistId, iPath
              FROM albums
              WHERE id = :albumId';
    $statement = $db->prepare($query);
    $statement->bindValue(':albumId', $albumId);
    $statement->execute();
    $album = $statement->fetch();
    $statement->closeCursor();
    return $album;
}

function getAlbums() : array
{
    global $db;
    $query = 'SELECT id, name, artistId, iPath
              FROM albums
              ORDER BY LOWER(name)';
    $statement = $db->prepare($query);
    $statement->execute();
    $albums = $statement->fetchAll();
    $statement->closeCursor();
    return $albums;
}

function getAlbumsWithArtistNames() : array
{
    global $db;
    $query = 'SELECT albums.id id, albums.name name, albums.artistId artistId, albums.iPath iPath
                     artists.name artistName
              FROM albums
                  JOIN artists ON albums.artistId = artists.id
              ORDER BY LOWER(albums.name)';
    $statement = $db->prepare($query);
    $statement->execute();
    $albums = $statement->fetchAll();
    $statement->closeCursor();
    return $albums;
}

function getAlbumsByArtistId(int $artistId) : array
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

function addAlbum(array $album) : int
{
    global $db;
    $query = 'INSERT INTO albums (name, artistId, iPath)
              VALUES (:name, :artistId, :iPath)';
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $album['name']);
    $statement->bindValue(':artistId', $album['artistId']);
    $statement->bindValue(':iPath', $album['iPath']);
    $statement->execute();
    $albumId = $db->lastInsertId();
    $statement->closeCursor();
    return $albumId;
}

function updateAlbum(array $album) : void
{
    global $db;
    $query = 'UPDATE albums
              SET name = :name, artistId = :artistId, iPath = :iPath
              WHERE id = :albumId';
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $album['name']);
    $statement->bindValue(':artistId', $album['artistId']);
    $statement->bindValue(':albumId', $album['id']);
    $statement->bindValue(':iPath', $album['iPath']);
    $statement->execute();
    $statement->closeCursor();
}

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
