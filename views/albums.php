<?php include('views/partials/header.php'); ?>

<h1>Albums</h1>

<p>
    <a href=".?action=albumForm">
        Add Album
    </a>
</p>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Artist</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($albums as $album) : ?>
            <tr>
                <td>
                    <a href=".?action=viewAlbum&albumId=<?php echo $album['id']; ?>">
                        <?php echo htmlspecialchars($album['name']); ?>
                    </a>
                </td>
                <td>
                    <a href=".?action=viewArtist&artistId=<?php echo $album['artistId']; ?>">
                        <?php echo $album['artistName']; ?>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include('views/partials/footer.php'); ?>
