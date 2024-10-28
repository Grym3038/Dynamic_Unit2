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

<form action="." method="post" class="form form-dark">
    <?php include('views/_partials/formErrors.php'); ?>

    <input type="hidden" name="action" value="editArtist" />
    <input type="hidden" name="artistId" value="<?php echo $artist['id']; ?>" />

    <div class="form-group">
        <label for="name" class="label">Name</label>
        <input type="text" name="name" id="name" class="input" autofocus
            value="<?php echo htmlspecialchars($artist['name']); ?>" />
    </div>

    <div class="form-group">
        <label for="monthlyListeners" class="label">Monthly Listeners</label>
        <input type="number" name="monthlyListeners" id="monthlyListeners" class="input"
            value="<?php echo htmlspecialchars($artist['monthlyListeners']); ?>" />
    </div>

    <div class="form-group">
        <label for="imagePath" class="label">Image Path</label>
        <input type="text" name="imagePath" id="imagePath" class="input" 
            value="<?php echo htmlspecialchars($artist['imagePath']); ?>" />
    </div>

    <div class="form-group">
        <input type="submit" value="Submit" class="btn btn-submit" />

        <?php
            if ($artist['id'] == 0)
            {
                $href = '.?action=listArtists';
            }
            else
            {
                $href = '.?action=viewArtist&artistId=' . $artist['id'];
            }
        ?>

        <a href="<?php echo $href; ?>" class="btn btn-cancel">Cancel</a>
    </div>
</form>


<?php include('views/_partials/footer.php'); ?>
