<?php

function ddd($data) {
    // Get trace
    $trace = debug_backtrace();
    
    echo '<pre>';
    var_dump($trace[0]['file'] . ' on line ' . $trace[0]['line']);
    var_dump($data);
    echo '</pre>';
    die();
}

function trace() {
    // Get trace
    $trace = debug_backtrace();
    
    echo '<pre>';
    var_dump($trace);
    echo '</pre>';
    die();
}