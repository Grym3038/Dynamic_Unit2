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
    <style>
        .album-cover {
            aspect-ratio: 1 / 1;
            display: block;
            object-fit: cover;
            width: 15rem;
            max-width: 100%;
        }
    </style>
    <div class="p-3">
        <img src="<?php echo htmlspecialchars($song['imagePath']); ?>" class="album-cover" />
    </div>
    <div class="p-3 d-flex flex-column justify-content-end">
        <div class="m-0">Song</div>
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
            <form action="." method="post" style="display: inline;">
                <input type="hidden" name="action" value="toggleLiked" />
                <input type="hidden" name="songId"
                    value="<?php echo $song['id']; ?>" />
                <input type="hidden" name="redirectTo"
                    value="?action=viewSong&songId=<?php echo $song['id']; ?>" />

                <style>
                    .btn-like, .btn-unlike {
                        height: 2.25rem;
                        width: 2.25rem;
                        background-color: orange;
                        border-color: orange;
                        background-position: center;
                        background-repeat: no-repeat;
                        filter: invert(100%);
                    }

                    .btn-like {
                        background-image: url('lib/bootstrap/icons/heart.svg');
                    }

                    .btn-unlike {
                        background-image: url('lib/bootstrap/icons/heart-fill.svg');
                    }

                    .btn-like:hover, .btn-unlike:hover {
                        background-color: orange;
                        background-image: url('lib/bootstrap/icons/heart-half.svg');
                    }
                </style>

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

                <button type="submit" class="btn btn-<?php echo $class; ?>"></button>
            </form>
        </div>
    </div>
</div>

<!-- Contributing Artists -->

<section class="pt-3">
    <style>
        .artist-profile-image {
            aspect-ratio: 1/1;
            border-radius: 1000px;
            object-fit: cover;
            max-width: 5rem;
        }
    </style>
    <?php foreach ($song['artists'] as $artist) : ?>
        <div class="d-flex">
            <div class="p-3">
                <a href="?action=viewArtist&artistId=<?php echo $artist['id']; ?>">
                    <img src="<?php echo $artist['imagePath']; ?>" class="artist-profile-image"/>
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
</section>

<?php include('views/_partials/footer.php'); ?>
