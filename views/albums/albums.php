<?php
/**
 * Title: Albums List
 * Purpose: To list all the albums, including the album names and artist names
 */
?>

<?php include('views/_partials/header.php'); ?>

<h1>Albums</h1>

<div class="d-grid gap-2">
    <a class="btn btn-primary" href=".?action=albumForm" role="button"> 
        Add Album
    </a>
</div>

<table class="table table-hover">
    <thead class="table-light">
        <tr>
            <th>Name</th>
            <th>Artist</th>
        </tr>
    </thead>
    <tbody class="table-dark">
        <?php foreach($albums as $album) : ?>
            <img src="<?php echo $album['iPath']; ?>" alt="">
            <tr>
                <td>
                    <a class="btn btn-dark" href=".?action=viewAlbum&albumId=<?php echo $album['id']; ?>">
                        <?php echo htmlspecialchars($album['name']); ?>
                    </a>
                </td>
                <td>
                    <a class="btn btn-dark" href=".?action=viewArtist&artistId=<?php echo $album['artistId']; ?>">
                        <?php echo $album['artistName']; ?>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include('views/_partials/footer.php'); ?>
