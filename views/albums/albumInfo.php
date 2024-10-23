<?php
/**
 * Title: Album Info
 * Purpose: To view all information about a given album, including edit and
 *          delete buttons, the artist, the songs, and the lengths of the album
 *          and the songs
 */
?>

<?php require('views/_helpers/formatTime.php'); ?>

<?php include('views/_partials/header.php'); ?>

<h1>
    <?php echo htmlspecialchars($album['name']); ?>
</h1>

<div>
    <div class="album-cover"
        style="background-image: url(<?php echo $album['iPath']; ?>);">
    </div>
</div>

<div class="mt-3">
    <a href=".?action=albumForm&albumId=<?php echo $album['id']; ?>"
        class="btn btn-warning">
        Edit
    </a>
    <a href=".?action=deleteAlbum&albumId=<?php echo $album['id']; ?>"
        class="btn btn-danger">
        Delete
    </a>
</div>

<table class="table table-dark mt-3">
    <tbody>
        <tr>
            <th>Artist</th>
            <td>
                <a href=".?action=viewArtist&artistId=<?php echo $artist['id']; ?>">
                    <?php echo htmlspecialchars($artist['name']); ?>
                </a>
            </td>
        </tr>
        <tr>
            <th>Duration</th>
            <td>
                <?php echo formatTime($album['length']); ?>
            </td>
        </tr>
    </tbody>
</table>

<table class="table table-dark mt-3">
    <thead>
        <tr>
            <th>Song</th>
            <th>Duration</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($songs as $song) : ?>
    <tr>
        <td>
            <a href=".?action=viewSong&songId=<?php echo $song['id']; ?>">
                <?php echo htmlspecialchars($song['name']); ?>
            </a>
        </td>
        <td>
            <?php echo formatTime($song['length']); ?>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php include('views/_partials/footer.php'); ?>
