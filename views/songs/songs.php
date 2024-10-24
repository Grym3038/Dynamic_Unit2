<?php
/**
 * Title: Songs List
 * Purpose: To list all songs, including their durations and albums
 */
?>

<?php require('views/_helpers/formatTime.php'); ?>

<?php include('views/_partials/header.php'); ?>

<h1>Songs</h1>

<p>
    <a href=".?action=songForm" class="btn btn-primary">
        &plus; Add Song
    </a>
</p>

<div class="table-responsive">
    <table class="table table-dark">
        <thead>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Duration</th>
                <th>Artists</th>
                <th>Album</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($songs as $song) : ?>
                <tr>
                    <td>
                        <img src="<?php echo htmlspecialchars($song['imagePath']); ?>" class="album-thumbnail-image" />
                    </td>
                    <td>
                        <a href=".?action=viewSong&songId=<?php echo $song['id']; ?>">
                            <?php echo htmlspecialchars($song['name']); ?>
                        </a>
                    </td>
                    <td>
                        <?php echo formattime($song['length']); ?>
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
                        <a href=".?action=viewAlbum&albumId=<?php echo $song['albumId']; ?>">
                            <?php echo htmlspecialchars($song['albumName']); ?>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include('views/_partials/footer.php'); ?>
