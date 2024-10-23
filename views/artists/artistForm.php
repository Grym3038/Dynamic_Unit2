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

<form action="." method="post" class="form-dark">
    <?php include('views/_partials/formErrors.php'); ?>

    <input type="hidden" name="action" value="editArtist" />
    <input type="hidden" name="artistId" value="<?php echo $artist['id']; ?>" />

    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" class="form-control" autofocus
            value="<?php echo htmlspecialchars($artist['name']); ?>" />
    </div>

    <div class="form-group">
        <label for="monthlyListeners">Monthly Listeners</label>
        <input type="number" name="monthlyListeners" id="monthlyListeners" class="form-control"
            value="<?php echo htmlspecialchars($artist['monthlyListeners']); ?>" />
    </div>

    <div class="form-group">
        <label for="iPath">Image Path</label>
        <input type="text" name="iPath" id="iPath" class="form-control" 
            value="<?php echo htmlspecialchars($artist['iPath']); ?>" />
    </div>

    <div class="form-group">
        <input type="submit" value="Submit" class="btn btn-dark" />
        <?php if ($artist['id'] == 0) : ?>
            <a href=".?action=listArtists" class="btn-cancel">Cancel</a>
        <?php else : ?>
            <a href=".?action=viewArtist&artistId=<?php echo $artist['id']; ?>" class="btn-cancel">Cancel</a>
        <?php endif; ?>
    </div>
</form>


<?php include('views/_partials/footer.php'); ?>
