<?php
/**
 * Title: Album Form
 * Purpose: To provide a form for adding or editing an album
 */
?>

<?php include('views/_partials/header.php'); ?>

<h1>
    <?php echo ($album['id'] == 0 ? 'Add' : 'Edit') . ' Album'; ?>
</h1>

<form action="." method="post">
    <?php include('views/_partials/formErrors.php'); ?>

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

        <?php
            if ($album['id'] == 0)
            {
                $href = '.?action=listAlbums';
            }
            else
            {
                $href = '.?action=viewAlbum&albumId=' . $album['id'];
            }
        ?>

        <a href="<?php echo $href; ?>">
            Cancel
        </a>
    </div>
</form>

<?php include('views/_partials/footer.php'); ?>
