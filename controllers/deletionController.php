<?php
if ($action == 'deleteEntity')
{
    $entityType = filter_input(INPUT_POST, 'entityType');
    $entityId = filter_input(INPUT_POST, 'entityId', FILTER_VALIDATE_INT);

    $validTypes = array('artist', 'album', 'song', 'artistSong');

    $isValidType = in_array($entityType, $validTypes);
    $isValidId = is_integer($entityId) && $entityId > 0;

    if (!$isValidType || !$isValidId)
    {
        header('Location: .');
        exit();
    }

    switch ($entityType)
    {
        case 'artist':
            $entity = artists\getArtist($entityId);
            break;
        case 'album':
            $entity = albums\getAlbum($entityId);
            break;
        case 'song':
            $entity = songs\getSong($entityId);
            break;
        case 'artistSong':
            $entity = artistsSongs\getArtistSong($entityId);
            break;
    }

    if ($entity === FALSE) return404();

    switch ($entityType)
    {
        case 'artist':
            artists\deleteArtist($entity);
            header('Location: .?action=listArtists');
            break;
        case 'album':
            albums\deleteAlbum($entity);
            header('Location: .?action=listAlbums');
            break;
        case 'song':
            songs\deleteSong($entity);
            header('Location: .?action=listSongs');
            break;
        case 'artistSong':
            artistsSongs\deleteArtistSong($entity);
            header('Location: .?action=listArtistsSongs');
            break;
    }
    exit();
}
?>
