<?php include('views/partials/header.php'); ?>

<?php require('views/utilities/formattime.php'); ?>

<h1>Songs</h1>

<p>
    <a href=".?action=songForm">
        Add Song
    </a>
</p>

<div>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Duration</th>
                <th>Album</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($songs as $song) : ?>
                <tr>
                    <td>
                        <a href=".?action=viewSong&songId=<?php echo $song['id']; ?>">
                            <?php echo htmlspecialchars($song['name']); ?>
                        </a>
                    </td>
                    <td>
                        <?php echo formattime($song['length']); ?>
                    </td>
                    <td>
                        <a href=".?action=viewAlbum&albumId=<?php echo $song['albumId']; ?>">
                            <?php echo htmlspecialchars($song['albumName']); ?>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include('views/partials/footer.php'); ?>
