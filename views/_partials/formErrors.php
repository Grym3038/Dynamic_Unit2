<?php
/**
 * Title: Form Errors
 * Purpose: To format error messages for use on a form
 */
?>

<?php if (!empty($errors) && count($errors) > 0) : ?>
    <ul>
        <?php foreach ($errors as $error) : ?>   
        <li>
            <?php echo $error; ?>
        </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
