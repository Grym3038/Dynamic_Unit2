<?php
/**
 * Title: Song Info
 * Purpose: To view all information about a given song, including contributing
 *          artists, as well as buttons for editing, deleting, liking, and
 *          unliking the song
 */
?>

<?php require('views/_helpers/formatTime.php'); ?>

<?php include('views/_partials/header.php'); ?>

<!-- Song Overview -->

<div class="d-flex flex-wrap">
    <div class="p-3">
        <img src="<?php echo htmlspecialchars($song['imagePath']); ?>" class="album-cover" />
    </div>
    <div class="p-3 d-flex flex-column justify-content-end">
        <div>Song</div>
        <h1>
            <?php echo htmlspecialchars($song['name']); ?>
        </h1>
        <div>
            <?php $primaryArtist = $song['artists'][0]; ?>
            <a href="?action=viewArtist&artistId=<?php echo $primaryArtist['id']; ?>"
                class="link-light link-underline-opacity-0 link-underline-opacity-100-hover"><?php echo $primaryArtist['name']; ?></a>
            &#x2022;
            <a href="?action=viewAlbum&albumId=<?php echo $song['albumId']; ?>"
                class="link-light link-underline-opacity-0 link-underline-opacity-100-hover"><?php echo $song['albumName']; ?></a>
            &#x2022;
            <?php echo formatTime($song['length'], FALSE); ?>
        </div>
        <div class="pt-3">
            <a href=".?action=songForm&songId=<?php echo $song['id']; ?>"
                class="btn btn-warning">
                Edit
            </a>
            <a href=".?action=deleteSong&songId=<?php echo $song['id']; ?>"
                class="btn btn-danger">
                Delete
            </a>
            <form action="." method="post" class="d-inline">
                <input type="hidden" name="action" value="toggleLiked" />
                <input type="hidden" name="songId" value="<?php echo $song['id']; ?>" />
                <input type="hidden" name="redirectTo" value="?action=viewSong&songId=<?php echo $song['id']; ?>" />

                <?php
                    if (in_array($song['id'], $_SESSION['likedSongIds']))
                    {
                        $class = 'unlike';
                    }
                    else
                    {
                        $class = 'like';
                    }
                ?>

                <button type="submit" class="btn btn-<?php echo $class; ?>">
                    &nbsp;
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Contributing Artists -->

<div class="pt-3">
    <?php foreach ($song['artists'] as $artist) : ?>
        <div class="d-flex">
            <div class="p-3">
                <a href="?action=viewArtist&artistId=<?php echo $artist['id']; ?>">
                    <img src="<?php echo htmlspecialchars($artist['imagePath']); ?>" class="artist-profile-image" />
                </a>
            </div>
            <div class="p-3 d-flex flex-column justify-content-center">
                <div>Artist</div>
                <div>
                    <a href="?action=viewArtist&artistId=<?php echo $artist['id']; ?>"
                        class="link-light link-underline-opacity-0 link-underline-opacity-100-hover">
                        <?php echo htmlspecialchars($artist['name']); ?>
                    </a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php include('views/_partials/footer.php'); ?>
