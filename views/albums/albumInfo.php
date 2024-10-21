<?php require('views/_helpers/formatTime.php'); ?>

<?php include('views/_partials/header.php'); ?>

<h1>
    <?php echo htmlspecialchars($album['name']); ?>
</h1>

<div class="btn-group" role="group" aria-label="Basic example">
    
    <a class="btn btn-outline-info" href=".?action=albumForm&albumId=<?php echo $album['id']; ?>">
        Edit
    </a>
    <a class="btn btn-outline-danger" href=".?action=deleteAlbum&albumId=<?php echo $album['id']; ?>">
        Delete
    </a>
    </li>
</div>

<table>
    <tbody>
        <tr>
            <th>Artist</th>
            <td>
                <a class="btn btn-outline-secondary" href=".?action=viewArtist&artistId=<?php echo $artist['id']; ?>">
                    <?php echo htmlspecialchars($artist['name']); ?>
                </a>
            </td>
        </tr>
        <tr>
            <th>Length</th>
            <td>
                <?php echo formatTime($album['length']); ?>
            </td>
        </tr>
    </tbody>
</table>

<table class="table table-sm">
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

<?php include('views/_partials/footer.php'); ?>
