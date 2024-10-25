<?php
/**
 * Title: Songs List
 * Purpose: To list all songs, including their durations and albums
 */
?>

<?php require('views/_helpers/formatTime.php'); ?>

<?php include('views/_partials/header.php'); ?>

<h1>Songs</h1>

<div class="mt-3">
    <a href=".?action=songForm" class="btn btn-primary">
        &plus; Add Song
    </a>
</div>

<div class="table-responsive mt-3">
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
            <style>
                .album-thumbnail {
                    aspect-ratio: 1 / 1;
                    object-fit: cover;
                    max-width: 7rem;
                }
            </style>
            <?php foreach($songs as $song) : ?>
                <tr>
                    <td>
                        <a href=".?action=viewSong&songId=<?php echo $song['id']; ?>">
                            <img src="<?php echo htmlspecialchars($song['imagePath']); ?>"
                                class="album-thumbnail" />
                        </a>
                    </td>
                    <td>
                        <a href=".?action=viewSong&songId=<?php echo $song['id']; ?>"
                            class="link-light link-underline-opacity-0 link-underline-opacity-100-hover">
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
                            ?>
                            <a href="<?php echo $href; ?>"
                                class="link-light link-underline-opacity-0 link-underline-opacity-100-hover"><?php echo $text; ?></a><?php echo $comma; ?>
                        <?php endforeach; ?>
                    </td>
                    <td>
                        <a href=".?action=viewAlbum&albumId=<?php echo $song['albumId']; ?>"
                            class="link-light link-underline-opacity-0 link-underline-opacity-100-hover">
                            <?php echo htmlspecialchars($song['albumName']); ?>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include('views/_partials/footer.php'); ?>
