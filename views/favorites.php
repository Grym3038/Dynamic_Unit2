<?php include('views/partials/header.php'); ?>

<h1>Favorite Songs</h1>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($songs as $song) : ?>
            <tr>
                <td>
                    <a href=".?action=viewSong&songId=<?php echo song['id']; ?>">
                        <?php echo htmlspecialchars(song['name']); ?>
                    </a>
                </td>
                <td>
                    <form action="." method="post">
                        <input type="hidden" name="action"
                            value="removeFavorite" />
                        <input type="hidden" name="songId"
                            value="<?php echo song['id']; ?>" />
                        <input type="submit" value="Remove" />
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include('views/partials/footer.php'); ?>
