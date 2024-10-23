<?php
/**
 * Title: Header Partial
 * Purpose: To provide a header for all pages of the application, including
 *          navigation links
 */
?>
<!DOCTYPE html>
<html lang="en-us">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Song App</title>
    <link rel="stylesheet" href="./lib/bootstrap/css/bootstrap.min.css" />
    <script src="./lib/bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./css/site.css" />
</head>
<body class="container mt-4 bg-dark text-light rounded">
    <nav class="navbar navbar-expand-lg navbar-dark mb-3">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Song App</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link" aria-current="page" href=".?action=listArtists">Artists</a>
                    <a class="nav-link" href=".?action=listAlbums">Albums</a>
                    <a class="nav-link" href=".?action=listSongs">Songs</a>
                    <a class="nav-link" href=".?action=listArtistsSongs">Artists Songs</a>
                    <a class="nav-link" href=".?action=listLikedSongs">Liked Songs</a>
                </div>
            </div>
        </div>
    </nav>
<main>
