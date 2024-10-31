<?php
/**
 * Title: Artist Info
 * Purpose: To view all information about a given artist, including edit and
 *          delete buttons, their monthly listeners, and all their albums and
 *          songs
 */
?>

<?php require('views/_helpers/artistList.php'); ?>
<?php require('views/_helpers/formatTime.php'); ?>

<?php include('views/_partials/header.php'); ?>

<div class="d-flex flex-wrap">
    <div class="p-3">
        <img src="<?php echo htmlspecialchars($artist['imagePath']); ?>"
            class="album-cover" />
    </div>
    <div class="p-3 d-flex flex-column justify-content-end">
        <div>Artist</div>
        <h1>
            <?php echo htmlspecialchars($artist['name']); ?>
        </h1>
        <div>
            <?php echo number_format($artist['monthlyListeners'], 0, '.', ',')
                . ' monthly listener' . ($artist['monthlyListeners'] == 1 ? '' : 's'); ?>
            &#x2022;
            <?php echo count($albums) . ' album' . (count($albums) == 1 ? '' : 's'); ?>
            &#x2022;
            <?php echo count($songs) . ' song' . (count($songs) == 1 ? '' : 's'); ?>
        </div>
        <div class="pt-3">
            <a href=".?action=artistForm&artistId=<?php echo $artist['id']; ?>"
                class="btn btn-warning">
                Edit
            </a>
            <a href=".?action=deleteArtist&artistId=<?php echo $artist['id']; ?>"
                class="btn btn-danger">
                Delete
            </a>
        </div>
    </div>
</div>

<h2 class="mt-3">Albums</h2>

<?php if (count($albums) == 0) : ?>
    <p>
        <i>No albums.</i>
    </p>
<?php else : ?>
    <div class="table-responsive">
        <table class="table table-dark">
            <thead>
                <tr>
                    <th></th>
                    <th>Name</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($albums as $album) : ?>
                    <tr>
                        <td>
                            <a href=".?action=viewAlbum&albumId=<?php echo $album['id']; ?>"
                                class="link-light link-underline-opacity-0 link-underline-opacity-100-hover">
                                <img src="<?php echo htmlspecialchars($album['imagePath']); ?>"
                                    class="album-thumbnail" />
                            </a>
                        </td>
                        <td>
                            <a href=".?action=viewAlbum&albumId=<?php echo $album['id']; ?>"
                                class="link-light link-underline-opacity-0 link-underline-opacity-100-hover">
                                <?php echo htmlspecialchars($album['name']); ?>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<h2 class="pt-3">Songs</h2>

<?php if (count($songs) == 0) : ?>
    <p>
        <i>No songs.</i>
    </p>
<?php else : ?>
    <div class="table-responsive">
        <table class="table table-dark">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Artists</th>
                    <th>Duration</th>
                    <th>Album</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($songs as $song) : ?>
                    <tr>
                        <td>
                            <a href=".?action=viewSong&songId=<?php echo $song['id']; ?>"
                                class="link-light link-underline-opacity-0 link-underline-opacity-100-hover">
                                <?php echo htmlspecialchars($song['name']); ?>
                            </a>
                        </td>
                        <td>
                            <?php artistList\build($song['artists']); ?>
                        </td>
                        <td>
                            <?php echo formatTime($song['length']); ?>
                        </td>
                        <td>
                            <a href=".?action=viewAlbum&albumId=<?php echo $song['albumId']?>"
                                class="link-light link-underline-opacity-0 link-underline-opacity-100-hover">
                                <?php echo htmlspecialchars($song['albumName']); ?>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php include('views/_partials/footer.php'); ?>
