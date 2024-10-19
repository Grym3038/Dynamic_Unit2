<?php
namespace artistsSongs;

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

    return $errors;
}

function isArtistSongUnique(array $artistSong) : bool
{
    global $db;
    $query = 'SELECT COUNT(*) count
              FROM artistsSongs
              WHERE artistId = :artistId AND songId = :songId';
    $statement = $db->prepare($query);
    $statement->bindValue(':artistId', $artistSong['artistId']);
    $statement->bindValue(':songId', $artistSong['songId']);
    $statement->execute();
    $count = $statement->fetch()['count'];
    $statement->closeCursor();

    return ($count === 0);
}

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
