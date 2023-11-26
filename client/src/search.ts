import { __, _n, sprintf } from '@wordpress/i18n';

import { SEARCH_DEBOUNCE_TIME, SEARCH_MIN_LENGTH } from './constants';
import { debounce, hideSpinner, liveSearch, showSpinner } from './utils';

/**
 * The `initLiveSearch` function initializes a live search functionality for a search input element in
 * a React TypeScript application.
 *
 * @param searchBlock - The `searchBlock` parameter is the HTML element that contains the search input
 *                    field and the search results. It is the parent element that holds all the elements related to the
 *                    search functionality.
 */
export function initLiveSearch(searchBlock) {
  let searchResultsWrapper: HTMLElement;
  let isWrapperFocused = false;
  let hasResultsWrapper = false;
  const searchInput = searchBlock.querySelector('input.wp-block-search__input');
  // select the input element
  //searchInput.focus();

  /**
   * The function appends a search results wrapper to a search input element and returns the wrapper.
   *
   * @param {HTMLInputElement} input - The input parameter is an HTMLInputElement, which represents an
   *                                 input element in an HTML form.
   * @return the searchResultsWrapper, which is a newly created div element with the class
   * 'search-results'.
   */
  function appendWrapper(input: HTMLInputElement) {
    //the search results wrapper
    searchResultsWrapper = document.createElement('div');
    searchResultsWrapper.classList.add('search-results');

    // append the wrapper inside the search input
    searchBlock.appendChild(searchResultsWrapper);

    // then add to the wrapper a focus event listener
    searchBlock.addEventListener('focusin', function () {
      isWrapperFocused = true;
    });

    searchBlock.addEventListener('focusout', function () {
      isWrapperFocused = false;
    });

    return searchResultsWrapper;
  }

  /* The `debouncedSearch` function is a debounced version of the `liveSearch` function. It is created
	using the `debounce` utility function, which ensures that the `liveSearch` function is only called
	after a certain delay (specified by `SEARCH_DEBOUNCE_TIME`) since the last invocation of the
	`debouncedSearch` function. */
  const debouncedSearch = debounce((searchTerm) => {
    if (searchTerm.length >= SEARCH_MIN_LENGTH) {
      liveSearch(searchTerm).then((resultsHtml) => {
        hideSpinner(searchResultsWrapper);
        searchResultsWrapper.classList.remove('awaitingResponse');

        // adds the focused class to the search block to show the search results
        searchBlock.classList.add('focused');

        // append the results to the search results wrapper
        if (resultsHtml) {
          searchResultsWrapper.innerHTML = `<ul class="search-results-wrapper">${resultsHtml}</ul>`;
        } else {
          searchResultsWrapper.innerHTML = `<ul class="search-results-wrapper"><li>${__(
            'Sorry, no results found',
            'search-block'
          )}</li></ul>`;
        }
      });
    } else if (searchTerm.length !== 0) {
      // the minimum number of characters is 3
      searchResultsWrapper.innerHTML = `<ul class="search-results-wrapper"><li>${sprintf(
        _n(
          'Please add %s more characters',
          'Please add %s more character',
          searchTerm.length
        ),
        SEARCH_MIN_LENGTH - searchTerm.length
      )}</li></ul>`;
      showSpinner(searchResultsWrapper);
    } else {
      // store the current results wrapper status
      hasResultsWrapper = false;
      // remove the search results wrapper
      searchResultsWrapper.remove();
    }
  }, SEARCH_DEBOUNCE_TIME);

  /**
   * The `activate` function adds event listeners to the search input element for keyup, focus, and blur
   * events.
   */
  function activate() {
    /* When the user releases a key after typing in the search input, the event listener function is
		triggered. */
    searchInput.addEventListener('keyup', (e) => {
      const input = e.target as HTMLInputElement;
      const searchTerm = input.value;

      // append the search results wrapper if it doesn't exist
      if (!hasResultsWrapper) {
        searchResultsWrapper = appendWrapper(searchInput);

        // store the current results wrapper status
        hasResultsWrapper = true;
      }

      // show the loading spinner if the spinner isn't show
      if (!searchResultsWrapper.classList.contains('awaitingResponse')) {
        searchResultsWrapper.classList.add('awaitingResponse');
        showSpinner(searchResultsWrapper);
      }

      debouncedSearch(searchTerm);
    });

    /* adds an event listener to the `searchInput` element for the `focus` event. */
    searchInput.addEventListener('focus', function () {
      searchBlock.classList.add('focused');
    });

    /* The code snippet adds an event listener to the `searchInput` element for the `blur` event. */
    searchInput.addEventListener('blur', function (e) {
      if (
        !isWrapperFocused &&
        !(e.target as HTMLInputElement).classList.contains(
          'wp-block-search__input'
        )
      ) {
        searchBlock.classList.remove('focused');
      }
    });
  }

  // Initialize the script
  activate();
}
