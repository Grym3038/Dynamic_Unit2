<?php include('views/partials/header.php'); ?>

<?php
if (!isset($album))
{
    $album = array(
        'id' => 0,
        'name' => '',
        'artistId' => ''
    );
}
?>

<h1>
    <?php echo ($album['id'] == 0 ? 'Add' : 'Edit'); ?>
    Album
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

    <input type="hidden" name="action" value="editAlbum" />
    <input type="hidden" name="albumId" value="<?php echo $album['id']; ?>" />

    <div>
        <label for="name">Name</label>
        <input type="text" name="name" id="name" autofocus
            value="<?php echo htmlspecialchars($album['name']); ?>" />
    </div>
    <div>
        <label for="artistId">Artist</label>
        <select name="artistId" id="artistId">
            <?php foreach ($artists as $artist) : ?>
                <option value="<?php echo $artist['id']; ?>"
                    <?php if ($album['artistId'] == $artist['id']) : ?>
                        selected
                    <?php endif; ?>>
                    <?php echo htmlspecialchars($artist['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <input type="submit" value="Submit" />
        <a href=".">Cancel</a>
    </div>
</form>

<?php include('views/partials/footer.php'); ?>
