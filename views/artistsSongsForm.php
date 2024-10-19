<?php include('views/partials/header.php'); ?>

<h1>
    <?php echo ($artistSong['id'] == 0 ? 'Add' : 'Edit') . ' Artist-Song'; ?>
</h1>

<form action="." method="post">
    <?php include('views/partials/formErrors.php'); ?>

    <input type="hidden" name="action" value="editArtistSong" />
    <input type="hidden" name="artistSongId"
        value="<?php echo $artistSong['id']; ?>" />
    <div>
        <label for="artistId">Artist</label>
        <select name="artistId" id="artistId">
            <option value="">
                select an artist
            </option>
            <?php foreach ($artists as $artist) : ?>
                <option value="<?php echo $artist['id']; ?>">
                    <?php echo htmlspecialchars($artist['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <label for="songId">Song</label>
        <select name="songId" id="songId">
            <option value="">
                select a song
            </option>
            <?php foreach ($songs as $song) : ?>
                <option value="<?php echo $song['id']; ?>">
                    <?php echo htmlspecialchars($song['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <input type="submit" value="Submit" />
        <a href=".?action=listArtistsSongs">
            Cancel
        </a>
    </div>
</form>

<?php include('views/partials/footer.php'); ?>
