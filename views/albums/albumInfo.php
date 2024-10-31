<?php
/**
 * Title: Album Info
 * Purpose: To view all information about a given album, including edit and
 *          delete buttons, the artist, the songs, and the lengths of the album
 *          and the songs
 */
?>

<?php require('views/_helpers/artistList.php'); ?>
<?php require('views/_helpers/formatTime.php'); ?>

<?php include('views/_partials/header.php'); ?>

<div class="d-flex flex-wrap">
    <div class="p-3">
        <img src="<?php echo htmlspecialchars($album['imagePath']); ?>"
            class="album-cover" />
    </div>
    <div class="p-3 d-flex flex-column justify-content-end">
        <div>Album</div>
        <h1>
            <?php echo htmlspecialchars($album['name']); ?>
        </h1>
        <div>
            <a href="?action=viewArtist&artistId=<?php echo $artist['id']; ?>"
                class="link-light link-underline-opacity-0 link-underline-opacity-100-hover"><?php echo htmlspecialchars($artist['name']); ?></a>
            <span>&#x2022;</span>
            <?php echo count($songs) . ' song' . (count($songs) == 1 ? '' : 's'); ?>
            <span>&#x2022;</span>
            <?php echo formatTime($album['length']); ?>
        </div>
        <div class="pt-3">
            <a class="btn btn-warning"
                href=".?action=albumForm&albumId=<?php echo $album['id']; ?>">
                Edit
            </a>
            <a class="btn btn-danger"
                href=".?action=deleteAlbum&albumId=<?php echo $album['id']; ?>">
                Delete
            </a>
        </div>
    </div>
</div>

<?php if (count($songs) == 0) : ?>
    <p class="pt-3">
        <i>No songs.</i>
    </p>
<?php else : ?>
    <table class="table table-sm table-dark">
        <thead>
            <tr>
                <th>Song</th>
                <th>Artists</th>
                <th>Duration</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($songs as $song) : ?>
                <tr>
                    <td>
                        <a class="link-light link-underline-opacity-0 link-underline-opacity-100-hover"
                            href=".?action=viewSong&songId=<?php echo $song['id']; ?>">
                            <?php echo htmlspecialchars($song['name']); ?>
                        </a>
                    </td>
                    <td>
                        <?php artistList\build($song['artists']); ?>
                    </td>
                    <td>
                        <?php echo formatTime($song['length']); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php include('views/_partials/footer.php'); ?>
