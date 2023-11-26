import { createRoot, useEffect, useState } from '@wordpress/element';
import { close } from '@wordpress/icons';

import { initLiveSearch } from '../search';

import { LiveSearch } from './LiveSearch';

/* The `SearchModal` component is a functional component that renders a modal for a search box. It uses
the `useState` hook to manage the state of whether the modal is shown or not. */
export const SearchModal = () => {
  const [showModal, setShowModal] = useState(false);

  const handleClick = () => {
    setShowModal(true);
  };

  const handleClose = () => {
    setShowModal(false);
  };

  useEffect(() => {
    const searchBoxButtons = document.querySelectorAll('.search-box-button');

    searchBoxButtons.forEach((button) => {
      button.addEventListener('click', handleClick);
    });
  }, []);

  useEffect(() => {
    const searchBoxModal = document.querySelector(
      '#search-box-modal .wp-block-live-search'
    );
    if (showModal) initLiveSearch(searchBoxModal);
  }, [showModal]);

  return showModal ? (
    <>
      <div
        id="search-box-modal-overlay"
        className={'overlay'}
        onClick={handleClose}
      ></div>
      <div id="search-box" className="modal overlay-card">
        <div className="card-header">
          <button
            className="search-box-icons close-button"
            key={'close'}
            onClick={handleClose}
          >
            {close}
          </button>
        </div>
        <div className="card-content">
          <LiveSearch />
        </div>
      </div>
    </>
  ) : null;
};

/**
 * The function initializes a search modal component in a specified container element.
 */
export function initSearchModal() {
  // Create a root for the SearchModal component
  const container = document.getElementById('search-box-modal');
  const root = createRoot(container as HTMLElement);
  root.render(<SearchModal />);
}
