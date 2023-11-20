/**
 * The `LiveSearch` function returns a form component for a live search feature in a React application.
 *
 * @return The LiveSearch function returns a JSX element representing a search form.
 */
export function LiveSearch(): JSX.Element {
	const container = document.getElementById('search-box-modal');
	const searchForm = container.dataset.searchForm;

	return (
		<form
			role="search"
			method="get"
			autoComplete="off"
			action={searchForm}
			className="wp-block-search__button-inside wp-block-search__icon-button wp-block-live-search"
		>
			<label className="wp-block-search__label screen-reader-text">
				Search
			</label>
			<div className="wp-block-search__inside-wrapper ">
				<input
					type="search"
					className="wp-block-search__input"
					name="s"
					placeholder=""
				/>
				<input type="hidden" name="lang" />
				<button
					type="submit"
					className="wp-block-search__button has-icon wp-element-button"
					aria-label="Search"
				>
					<svg
						className="search-icon"
						viewBox="0 0 24 24"
						width="24"
						height="24"
					>
						<path d="M13.5 6C10.5 6 8 8.5 8 11.5c0 1.1.3 2.1.9 3l-3.4 3 1 1.1 3.4-2.9c1 .9 2.2 1.4 3.6 1.4 3 0 5.5-2.5 5.5-5.5C19 8.5 16.5 6 13.5 6zm0 9.5c-2.2 0-4-1.8-4-4s1.8-4 4-4 4 1.8 4 4-1.8 4-4 4z"></path>
					</svg>
				</button>
			</div>
		</form>
	);
}
