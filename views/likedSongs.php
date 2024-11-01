<?php
/**
 * Title: Liked Songs List
 * Purpose: To list all the songs that have been liked and provide buttons for
 *          unliking songs and clearing the list of liked songs
 */
?>

<?php require('views/_helpers/artistList.php'); ?>
<?php require('views/_helpers/formatTime.php'); ?>

<?php include('views/_partials/header.php'); ?>

<h1>Liked Songs</h1>

<?php if (count($songs) == 0) : ?>
    <p class="mt-5">
        <i>No liked songs.</i>
    </p>
<?php else : ?>
    <p>
        <form action="." method="post">
            <input type="hidden" name="action" value="clearLikedSongs" />
            <input type="submit" value="Unlike All" class="btn btn-danger" />
        </form>
    </p>
    <div class="table-responsive">
        <table class="table table-dark">
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>Name</th>
                    <th>Duration</th>
                    <th>Artists</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php  foreach($songs as $song) : ?>
                    <tr>
                        <td>
                            <a href="?action=viewSong&songId=<?php echo $song['id']; ?>">
                                <img src="<?php echo $song['imagePath']; ?>" class="album-thumbnail" />
                            </a>
                        </td>
                        <td>
                            <?php
                                $href = '.?action=viewSong&songId=' . $song['id'];
                            ?>
                            <a href="<?php echo $href; ?>"
                                class="link-light link-underline-opacity-0 link-underline-opacity-100-hover">
                                <?php echo htmlspecialchars($song['name']); ?>
                            </a>
                        </td>
                        <td>
                            <?php echo formatTime($song['length']); ?>
                        </td>
                        <td>
                            <?php artistList\build($song['artists']); ?>
                        </td>
                        <td>
                            <form action="." method="post">
                                <input type="hidden" name="action" value="toggleLiked" />
                                <input type="hidden" name="songId" value="<?php echo $song['id']; ?>" />
                                <input type="hidden" name="redirectTo" value="?action=listLikedSongs" />
                                <button type="submit" class="btn btn-unlike pt-2">
                                    &nbsp;
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php include('views/_partials/footer.php'); ?>
