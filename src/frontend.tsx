import { initSearchModal } from './components/SearchModal';
import { initLiveSearch } from './search';
import './style/style.scss';

/* The `initSearchModal()` function is initializing the search modal functionality. It is responsible
for setting up the necessary event listeners and functionality to display and interact with the
search modal. */
initSearchModal();

/* The code is adding an event listener to the `DOMContentLoaded` event of the `document` object. This
event is fired when the initial HTML document has been completely loaded and parsed, without waiting
for stylesheets, images, and subframes to finish loading. */
document.addEventListener('DOMContentLoaded', function () {
	// get all the search blocks
	const searchBlocks = document.querySelectorAll('.wp-block-search-block');

	searchBlocks.forEach(initLiveSearch);
});
