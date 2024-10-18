<?php include('views/partials/header.php'); ?>

<h1>Confirm Deletion</h1>

<form action="." method="post">
    <p>
        Are you sure you want to delete
        "<?php echo htmlspecialchars($entity['name']) ?>"?
    </p>
    <input type="hidden" name="action" value="deleteEntity" />
    <input type="hidden" name="entityType"
        value="<?php echo htmlspecialchars($entity['type']); ?>" />
    <input type="hidden" name="entityId"
        value="<?php echo htmlspecialchars($entity['id']); ?>" />
    <div>
        <input type="submit" value="Yes" />
        <?php
            $href = '.?action=view' . htmlspecialchars(ucwords($entity['type'])) .
                '&' . htmlspecialchars(strtolower($entity['type'])) . 'Id=' .
                $entity['id'];
        ?>
        <a href="<?php echo $href; ?>">
            Cancel
        </a>
    </div>
</form>

<?php include('views/partials/footer.php'); ?>
