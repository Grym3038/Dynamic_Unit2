<?php
/**
 * Title: Deletion Confirmation Controller
 * Purpose: To accept form data to delete a database entity, including artists,
 *          albums, songs, and artist-song relationships
 */

if ($action == 'deleteEntity')
{
    $entityType = filter_input(INPUT_POST, 'entityType');
    $entityId = filter_input(INPUT_POST, 'entityId', FILTER_VALIDATE_INT);

    // Validate the form data
    $validTypes = array('artist', 'album', 'song');
    $isValidType = in_array($entityType, $validTypes);
    $isValidId = is_integer($entityId) && $entityId > 0;

    if (!$isValidType || !$isValidId)
    {
        header('Location: .');
        exit();
    }

    // Get the entity to delete based on the type
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
    }

    if ($entity == FALSE)
    {
        return404();
    }

    // Delete the entity based on the type
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
    }
    exit();
}
?>
