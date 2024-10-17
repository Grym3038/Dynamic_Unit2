<?php include('views/partials/header.php'); ?>

<h1>Confirm Deletion</h1>

<form action="." method="post">
    <p>
        Are you sure you want to delete
        "<?php echo htmlspecialchars($entityName) ?>"?
    </p>
    <input type="hidden" name="action" value="deleteEntity" />
    <input type="hidden" name="entityType"
        value="<?php echo htmlspecialchars($entityType); ?>" />
    <input type="hidden" name="entityId"
        value="<?php echo htmlspecialchars($entityId); ?>" />
    <div>
        <input type="submit" value="Yes" />
        <?php
            $href = '.?action=view' . htmlspecialchars(ucwords($entityType)) .
                '&' . htmlspecialchars(strtolower($entityType)) . 'Id=' .
                $entityId;
        ?>
        <a href="<?php echo $href; ?>">
            Cancel
        </a>
    </div>
</form>

<?php include('views/partials/footer.php'); ?>
