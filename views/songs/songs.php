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

<?php include('views/_partials/footer.php'); ?>
