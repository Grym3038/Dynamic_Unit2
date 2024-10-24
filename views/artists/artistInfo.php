<?php
/**
 * Title: Artist Info
 * Purpose: To view all information about a given artist, including edit and
 *          delete buttons, their monthly listeners, and all their albums and
 *          songs
 */
?>

<?php include('views/_partials/header.php'); ?>

<h1><?php echo htmlspecialchars($artist['name']); ?></h1>

<div class="p-2">
    <div class="album-cover"
        style="background-image: url(<?php echo $artist['imagePath']; ?>)">
    </div>
</div>

<p class="mt-3">
    Monthly Listeners:
    <?php echo number_format($artist['monthlyListeners'], 0, '.', ','); ?>
</p>

<div class="mt-3">
    <a href=".?action=artistForm&artistId=<?php echo $artist['id']; ?>"
        class="btn btn-warning">
        Edit
    </a>
    <a href=".?action=deleteArtist&artistId=<?php echo $artist['id']; ?>"
        class="btn btn-danger">
        Delete
    </a>
</div>

<h2 class="mt-3">Albums</h2>

<?php if (count($albums) == 0) : ?>
<p>
    <i>No albums.</i>
</p>
<?php else : ?>
<ul>
    <?php foreach ($albums as $album) : ?>
    <li>
        <a href=".?action=viewAlbum&albumId=<?php echo $album['id']; ?>">
            <?php echo htmlspecialchars($album['name']); ?>
        </a>
    </li>
    <?php endforeach; ?>
</ul>
<?php endif; ?>

<h2>Songs</h2>

<?php if (count($songs) == 0) : ?>
<p>
    <i>No songs.</i>
</p>
<?php else : ?>
<ul>
    <?php foreach ($songs as $song) : ?>
    <li>
        <a href=".?action=viewSong&songId=<?php echo $song['id']; ?>">
            <?php echo htmlspecialchars($song['name']); ?>
        </a>
    </li>
    <?php endforeach; ?>
</ul>
<?php endif ?>

<?php include('views/_partials/footer.php'); ?>
