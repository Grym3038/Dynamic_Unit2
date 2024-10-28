<?php
/*
    Title: Artist List
    Purpose: To provide a function for rendering a list of contributing artists
             links
*/

namespace artistList;

function build($artists)
{
    foreach ($artists as $artist)
    {
        $href = '?action=viewArtist&artistId=' . $artist['id'];
        $classes = array('link-light', 'link-underline-opacity-0',
            'link-underline-opacity-100-hover');
        $classList = implode(' ', $classes);
        $text = htmlspecialchars($artist['name']);
        $comma = ($artist == end($artists)) ? '' : ',';

        echo "<a href=\"$href\" class=\"$classList\">$text</a>$comma ";
    }
}
