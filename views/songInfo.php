<?php include('views/partials/header.php'); ?>

<h1>
    <?php echo htmlspecialchars($song['name']); ?>
</h1>

<ul>
    <li>
        <a href=".?action=songForm&songId=<?php echo $song['id']; ?>">
            Edit
        </a>
    </li>
    <li>
        <a href=".?action=deleteSong&songId=<?php echo $song['id']; ?>">
            Delete
        </a>
    </li>
    <li>
        <form action="." method="post">
            <input type="hidden" name="action" value="toggleFavorite" />
            <input type="hidden" name="songId"
                value="<?php echo $song['id']; ?>" />
            
            <?php
                if (in_array($song['id'], $_SESSION['likedSongIds']))
                {
                    $buttonText = 'Unlike';
                }
                else
                {
                    $buttonText = 'Like';
                }
            ?>

            <input type="submit" value="<?php echo $buttonText; ?>" />
        </form>
    </li>
</ul>

<table>
    <tbody>
        <tr>
            <th>Album</th>
            <td>
                <a href=".?action=viewAlbum&albumId=<?php echo $album['id']; ?>">
                    <?php echo htmlspecialchars($album['name']); ?>
                </a>
            </td>
        </tr>
        <tr>
            <th>Runtime</th>
            <td>
                <?php
                    require('views/utilities/formattime.php');
                    echo formatTime($song['length']);
                ?>
            </td>
        </tr>
    </tbody>
</table>

<h2>Artists</h2>

<ul>
<?php foreach ($artists as $artist) : ?>
    <li>
        <a href=".?action=viewArtist&artistId=<?php echo $artist['id']; ?>">
            <?php echo htmlspecialchars($artist['name']); ?>
        </a>
    </li>
<?php endforeach; ?>
</ul>

<?php include('views/partials/footer.php'); ?>
