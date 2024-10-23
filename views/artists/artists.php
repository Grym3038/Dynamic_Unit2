<?php
/**
 * Title: Artists List
 * Purpose: To list all the artists and their monthly listeners
 */
?>

<?php include('views/_partials/header.php'); ?>
<div class="container bg-dark text-light rounded" style="margin-bottom: 60px;">

<h1>Artists</h1>
    <div class="row bg-dark text-light rounded">

        <?php foreach ($artists as $artist) : ?>

            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-2">
                <a href=".?action=viewArtist&artistId=<?php echo $artist['id']; ?>" class="card bg-black border-0 text-center text-light product-card">
                    <!-- Hover container -->
                    <div class="product-container position-relative">
                        <div class="image-wrapper">
                            <img class="product-image img-fluid" src="<?php echo htmlspecialchars($artist['iPath']); ?>" alt="<?php echo htmlspecialchars($artist['name']); ?>" />
                        </div>
                        <!-- Dark overlay -->
                        <div class="overlay"></div>
                        <!-- Product name centered -->
                        <div class="product-name position-absolute bottom-0 start-0 end-0 d-flex justify-content-center align-items-center">
                            <?php echo htmlspecialchars($artist['name']); ?>
                        </div>
                    </div>
                </a>
            </div>

        <?php endforeach ?>
    

        <!-- Add Product Card -->
        <div class="col-md-2 mb-2">
            <a href=".?action=artistForm" class="card bg-black border-0 text-center text-light product-card">
                <div class="product-container position-relative">
                    <div class="image-wrapper d-flex justify-content-center align-items-center">
                        <div class="plus-icon" style="font-size: 5rem; color: lightgray;">+</div>
                    </div>
                    <!-- Overlay for hover effect -->
                    <div class="overlay"></div>
                    <!-- Placeholder text centered -->
                    <div class="product-name position-absolute bottom-0 start-0 end-0 d-flex justify-content-center align-items-center">
                        Add Artist
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<?php include('views/_partials/footer.php'); ?>
