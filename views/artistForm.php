<?php include('views/partials/header.php'); ?>

<h1>
    <?php echo ($artist['id'] == 0 ? 'Add' : 'Edit'); ?>
    Artist
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

<?php include('views/partials/footer.php'); ?>
