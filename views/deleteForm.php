<?php
/**
 * Title: Deletion Confirmation
 * Purpose: To provide a form for confirming the deletion of arbitrary entites
 *          in the database
 */
?>

<?php include('views/_partials/header.php'); ?>

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
        <input type="submit" value="Yes" class="btn btn-submit" />
        <?php
            $href = '.?action=view' . htmlspecialchars(ucwords($entity['type']))
                . '&' . htmlspecialchars(strtolower($entity['type'])) . 'Id=' .
                $entity['id'];
        ?>
        <a href="<?php echo $href; ?>" class="btn btn-cancel">
            Cancel
        </a>
    </div>
</form>

<?php include('views/_partials/footer.php'); ?>
