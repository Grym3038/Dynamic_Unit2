<?php
/**
 * Title: Albums List
 * Purpose: To list all the albums, including the album names and artist names
 */
?>

<?php include('views/_partials/header.php'); ?>

<h1>Albums</h1>

<p>
    <a href=".?action=albumForm" class="btn btn-primary">
        &plus; Add Album
    </a>
</p>

<table class="table table-dark table-vertical-align">
    <thead>
        <tr>
            <th></th>
            <th>Name</th>
            <th>Artist</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($albums as $album) : ?>
            <tr>
                <td>
                    <div class="album-cover" style="background-image: url(<?php echo $album['iPath']; ?>);"></div>
                </td>
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

<?php include('views/_partials/footer.php'); ?>
