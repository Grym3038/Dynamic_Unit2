<?php include('views/partials/header.php'); ?>

<?php
if (empty($song))
{
    $song = array(
        'id' => 0,
        'name' => '',
        'length' => 0,
        'albumId' => 0
    );
}
?>

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
            value="<?php echo $song['name']; ?>" />
    </div>

    <h2>Format</h2>

    <div>
        <input type="radio" id="songFormatSingle" name="songFormat"
            value="single" />
        <label for="songFormatSingle">Single</label>
        <select name="artistId">
            <?php foreach ($artists as $artist) : ?>
                <option value="<?php echo $artist['id']; ?>">
                    <?php echo htmlspecialchars($artist['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <input type="radio" id="songFormatAlbum" name="songFormat"
            value="album" />
        <label for="songFormatAlbum">Album</label>
        <select name="albumId">
            <?php foreach ($albums as $album) : ?>
                <option value="<?php echo $album['id']; ?>">
                    <?php echo htmlspecialchars($album['name']); ?>
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
        <?php $i = 0 ?>
        <?php foreach ($artists as $artist) : ?>
            <div>
                <input type="checkbox" name="artists[<?php echo $i; ?>]"
                    value="<?php echo $artist['id']; ?>"/>
                <label>
                    <?php echo htmlspecialchars($artist['name']); ?>
                </label>
            </div>
            <?php $i++; ?>
        <?php endforeach; ?>
    </div>

    <div>
        <input type="submit" value="Submit" />
        <a href=".">Cancel</a>
    </div>
</form>

<?php include('views/partials/footer.php'); ?>
