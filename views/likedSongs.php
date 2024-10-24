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
    <p class="mt-5">
        No liked songs.
    </p>
<?php else : ?>
    <p>
        <form action="." method="post">
            <input type="hidden" name="action" value="clearLikedSongs" />
            <input type="submit" value="Unlike All" class="btn btn-danger" />
        </form>
    </p>
    <table class="table table-dark">
        <thead>
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
                        <img src="<?php echo $song['imagePath']; ?>" class="album-thumbnail-image" />
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
                    <td>
                        <?php foreach ($song['artists'] as $artist) : ?>
                            <?php
                            $href = '?action=viewArtist&artistId=' . $artist['id'];
                            $text = htmlspecialchars($artist['name']);
                            $comma = ($artist == end($song['artists'])) ? '' : ',';

                            echo "<a href=\"$href\">$text</a>$comma";
                            ?>
                        <?php endforeach; ?>
                    </td>
                    <td>
                        <form action="." method="post">
                            <input type="hidden" name="action"
                                value="toggleLiked" />
                            <input type="hidden" name="songId"
                                value="<?php echo $song['id']; ?>" />
                            <input type="hidden" name="redirectTo"
                                value="?action=listLikedSongs" />
                            <input type="submit" value="Remove" />
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php include('views/_partials/footer.php'); ?>
