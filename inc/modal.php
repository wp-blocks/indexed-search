<?php
function live_search_modal_window() {
	// the search modal window
	echo '<div id="search-box-modal" data-search-form="' . esc_url( home_url( '/' ) ) .'"></div>';
}
