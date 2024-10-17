<?php require('views/utilities/formattime.php'); ?>

<?php include('views/partials/header.php'); ?>

<h1>
    <?php echo htmlspecialchars($album['name']); ?>
</h1>

<p>
    <a href=".?action=viewArtist&artistId=<?php echo $artist['id']; ?>">
        <?php echo htmlspecialchars($artist['name']); ?>
    </a>
</p>

<table>
    <thead>
        <tr>
            <th>Song</th>
            <th>Length</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($songs as $song) : ?>
    <tr>
        <td>
            <a href=".?action=viewSong&songId=<?php echo $song['id']; ?>">
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

<?php include('views/partials/footer.php'); ?>
