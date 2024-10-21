<?php
/**
 * Title: Header Partial
 * Purpose: To provide a header for all pages of the application, including
 *          navigation links
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Song App</title>
    <link rel="stylesheet" href="./lib/bootstrap/css/bootstrap.min.css" />
    <script src="./lib/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
    <nav>
        <ul>
            <li>
                <a href=".?action=listArtists">Artists</a>
            </li>
            <li>
                <a href=".?action=listAlbums">Albums</a>
            </li>
            <li>
                <a href=".?action=listSongs">Songs</a>
            </li>
            <li>
                <a href=".?action=listArtistsSongs">Artists Songs</a>
            </li>
            <li>
                <a href=".?action=listLikedSongs">Liked Songs</a>
            </li>
        </ul>
    </nav>
    <main>
