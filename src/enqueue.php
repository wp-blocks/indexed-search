<?php

add_action(
    'wp_enqueue_scripts',
    function () {
        $asset = include S_PATH . 'build/frontend.asset.php';
        wp_enqueue_style('indexed-search-block', S_URL . 'build/style-frontend.css');
        wp_enqueue_script('indexed-search-block', S_URL . 'build/frontend.js', $asset['dependencies'], $asset['version'], true);
    }
);
