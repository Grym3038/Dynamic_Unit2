<?php
/**
 * Title: Albums List
 * Purpose: To list all the albums, including the album names and artist names
 */
?>

<?php include('views/_partials/header.php'); ?>

<h1>Albums</h1>

<div class="d-grid gap-2">
    <a class="btn btn-primary" href=".?action=albumForm" role="button"> 
        Add Album
    </a>
<div class="row">
        <?php foreach($albums as $album) : ?>
            <div class="col-md-2 mb-3">
                    <a href=".?action=viewAlbum&albumId=<?php echo $album['id']; ?>" class="card link-underline link-underline-opacity-0 bg-black border-0 text-center text-light">
                        
                    <div class="card position-relative bg-dark text-light rounded">
                        <div class="card-img-top">
                            <img style="height: 10rem; width: 10rem;" src="<?php echo htmlspecialchars($album['iPath']); ?>" alt="<?php echo htmlspecialchars($album['name']); ?>" />
                        </div>
                        <div class="card-body ">
                            <div class="card-title ">
                                <?php echo htmlspecialchars($album['name']); ?>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>

<?php include('views/_partials/footer.php'); ?>
