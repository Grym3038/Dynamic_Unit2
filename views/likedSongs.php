<?php require('views/helpers/formatTime.php'); ?>

<?php include('views/partials/header.php'); ?>

<h1>Liked Songs</h1>

<?php if (count($songs) == 0) : ?>
    <p>
        <i>None.</i>
    </p>
<?php else : ?>
    <table>
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

<?php include('views/partials/footer.php'); ?>
