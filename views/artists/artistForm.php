<?php
/**
 * Title: Artist Form
 * Purpose: To provide a form for adding or editing an album
 */
?>

<?php include('views/_partials/header.php'); ?>

<h1>
    <?php echo ($artist['id'] == 0 ? 'Add' : 'Edit'); ?>
    Artist
</h1>

<form action="." method="post">
    <?php include('views/_partials/formErrors.php'); ?>

    <input type="hidden" name="action" value="editArtist" />
    <input type="hidden" name="artistId" value="<?php echo $artist['id']; ?>" />

    <div>
        <label for="name">Name</label>
        <input type="text" name="name" id="name" autofocus
            value="<?php echo htmlspecialchars($artist['name']); ?>" />
    </div>
    <div>
        <label for="monthlyListeners">Monthly Listeners</label>
        <input type="number" name="monthlyListeners" id="monthlyListeners"
            value="<?php echo htmlspecialchars($artist['monthlyListeners']); ?>" />
    </div>
    <div>
        <label for="iPath">Image Path</label>
        <input type="text" name="iPath" id="iPath" autofocus
            value="<?php echo htmlspecialchars($artist['iPath']); ?>" />
    </div>
    <div>
        <input type="submit" value="Submit" />
        <?php if ($artist['id'] == 0) : ?>
            <a href=".?action=listArtists">
                Cancel
            </a>
        <?php else : ?>
            <a href=".?action=viewArtist&artistId=<?php echo $artist['id']; ?>">
                Cancel
            </a>
        <?php endif; ?>
    </div>
</form>

<?php include('views/_partials/footer.php'); ?>
