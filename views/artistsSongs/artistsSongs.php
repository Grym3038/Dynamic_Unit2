<?php
/**
 * Title: Artists Songs List
 * Purpose: To list all artist-song relationships
 */
?>

<?php include('views/_partials/header.php'); ?>

<h1>Artists Songs</h1>

<p>
    <a href=".?action=artistsSongsForm">
        Add Relationship
    </a>
</p>

<table>
    <thead>
        <tr>
            <th>Artist</th>
            <th>Song</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($artistsSongs as $artistSong) : ?>
            <tr>
                <td>
                    <a href=".?action=viewArtist&artistId=<?php echo $artistSong['artistId']; ?>">
                        <?php echo htmlspecialchars($artistSong['artistName']); ?>
                    </a>
                </td>
                <td>
                    <a href=".?action=viewSong&songId=<?php echo $artistSong['songId']; ?>">
                        <?php echo htmlspecialchars($artistSong['songName']); ?>
                    </a>
                </td>
                <td>
                    <a href=".?action=artistsSongsForm&artistSongId=<?php echo $artistSong['id']; ?>">
                        Edit
                    </a>
                </td>
                <td>
                    <form action="." method="post">
                        <input type="hidden" name="action"
                            value="deleteEntity" />
                        <input type="hidden" name="entityType"
                            value="artistSong" />
                        <input type="hidden" name="entityId"
                            value="<?php echo $artistSong['id']; ?>" />
                        <input type="submit" value="Delete" />
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include('views/_partials/footer.php'); ?>
