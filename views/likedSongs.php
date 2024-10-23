<?php
/**
 * Title: Liked Songs List
 * Purpose: To list all the songs that have been liked and provide buttons for
 *          unliking songs and clearing the list of liked songs
 */
?>

<?php require('views/_helpers/formatTime.php'); ?>

<?php include('views/_partials/header.php'); ?>

<h1>Liked Songs</h1>

<?php if (count($songs) == 0) : ?>
    <p>
        <i>None.</i>
    </p>
<?php else : ?>
    <table class="table table-dark">
        <thead>
            <tr>
                <th>&nbsp;</th>
                <th>Name</th>
                <th>Duration</th>
            </tr>
        </thead>
        <tbody>
            <?php  foreach($songs as $song) : ?>
                <tr>
                    <td>
                        <form action="." method="post">
                            <input type="hidden" name="action"
                                value="toggleFavorite" />
                            <input type="hidden" name="songId"
                                value="<?php echo $song['id']; ?>" />
                            <input type="submit" value="&times;" />
                        </form>
                    </td>
                    <td>
                        <?php
                        $href = '.?action=viewSong&songId=' . $song['id'];
                        ?>
                        <a href="<?php echo $href; ?>">
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
    <p>
        <form action="." method="post">
            <input type="hidden" name="action" value="clearLikedSongs" />
            <input type="submit" value="Unlike All" />
        </form>
    </p>
<?php endif; ?>

<?php include('views/_partials/footer.php'); ?>
