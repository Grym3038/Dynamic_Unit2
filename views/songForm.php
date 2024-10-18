<?php include('views/partials/header.php'); ?>

<h1>
    <?php echo ($song['id'] == 0 ? 'Add' : 'Edit'); ?>
    Song
</h1>

<form action="." method="post">
    <?php if (!empty($errors) && count($errors) > 0) : ?>
        <ul>
            <?php foreach ($errors as $error) : ?>   
            <li>
                <?php echo $error; ?>
            </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <input type="hidden" name="action" value="editSong" />
    <input type="hidden" name="songId" value="<?php echo $song['id']; ?>" />

    <div>
        <label for="name">Name</label>
        <input type="text" name="name" id="name"
            value="<?php echo $song['name']; ?>" autofocus />
    </div>

    <div>
        <label for="albumId">Album</label>
        <select name="albumId">
            <?php foreach ($albums as $album) : ?>
                <option value="<?php echo $album['id']; ?>">
                    <?php echo htmlspecialchars($album['name']) . ' (' .
                        htmlspecialchars($album['artistName']) . ')'; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <h2>Duration</h2>

    <?php
    $length = $song['length'];
    $minutes = intdiv($length, 60);
    $seconds = $length - ($minutes * 60);
    ?>
                
    <div>
        <label for="minutes">Minutes</label>
        <input type="number" name="minutes" id="minutes"
            value="<?php echo $minutes; ?>" />
    </div>
    <div>
        <label for="seconds">Seconds</label>
        <input type="number" name="seconds" id="seconds"
            value="<?php echo $seconds; ?>" />
    </div>

    <h2>Contributing Artists</h2>

    <div>
        <?php foreach ($artists as $artist) : ?>
            <div>
                <input type="checkbox"
                    name="contributingArtistIds[<?php echo $artist['id']; ?>]"
                    <?php echo (in_array($artist['id'], $contributingArtistIds) ? 'checked' : ''); ?>
                />
                <label>
                    <?php echo htmlspecialchars($artist['name']); ?>
                </label>
            </div>
        <?php endforeach; ?>
    </div>

    <div>
        <input type="submit" value="Submit" />

        <?php if ($songId == 0) : ?>
            <a href=".">
                Cancel
            </a>
        <?php else : ?>
            <a href=".?action=viewSong&songId=<?php echo $songId; ?>">
                Cancel
            </a>
        <?php endif; ?>
    </div>
</form>

<?php include('views/partials/footer.php'); ?>
