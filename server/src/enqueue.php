<?php
add_action(
	'wp_enqueue_scripts',
	function () {
		$asset = include S_PATH . 'build/search-block.asset.php';
		wp_enqueue_style( 'vsge-block-live-search', S_URL . 'build/style-search-block.css' );
		wp_enqueue_script( 'vsge-block-live-search', S_URL . 'build/search-block.js', $asset['dependencies'], $asset['version'], true );
	}
);
