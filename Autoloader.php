<?php

// Load all files from the includes folder
load('includes');

// Load all files fom the controllers folder
load('controllers');

// Load all files from the models folder
load('models');

function load($dir)
{
    // Get all files in the directory
    $files = glob($dir . '/*');

    // Loop through all files
    foreach ($files as $file) {
        // Skip @eaDir
        if (strpos($file, '@eaDir') !== false) {
            continue;
        }
        
        // Check if file is a directory
        if (is_dir($file)) {
            // Load all files from the subfolder
            load($file);
        } else {
            // Check if the file is .php
            if (
                pathinfo($file, PATHINFO_EXTENSION) !== 'php'
                && pathinfo($file, PATHINFO_EXTENSION) !== 'phar'
            ) {
                continue;
            }

            // Load the file
            require $file;
        }
    }
}
