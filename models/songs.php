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
?>
