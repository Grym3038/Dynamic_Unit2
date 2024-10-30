<?php
/*
    Title: Main Controller
    Purpose: To serve as the entry point of the application that imports all
             data models and controllers
*/

// Import the data models
require('models/_database.php');
require('models/artists.php');
require('models/albums.php');
require('models/songs.php');
require('models/artistsSongs.php');

// Define a 404 Not Found function
function return404()
{
    $title = '404 Not Found';
    $body = 'That page does not exist';
    include('views/error.php');
    exit();
}

// Start the session
$lifetime = 60 * 60 * 24 * 365; // 1 year in seconds
session_set_cookie_params($lifetime, '/');
session_start();
if (empty($_SESSION['likedSongIds']))
{
    $_SESSION['likedSongIds'] = array();
}

// Get the action
$action = filter_input(INPUT_POST, 'action');
if ($action == NULL)
{
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL)
    {
        $action = 'listArtists';
    }
}

// Register the controllers
require('controllers/artistsController.php');
require('controllers/albumsController.php');
require('controllers/songsController.php');
require('controllers/likedSongsController.php');
require('controllers/deletionController.php');

return404();
