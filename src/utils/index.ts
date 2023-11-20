import apiFetch from '@wordpress/api-fetch';

/**
 * The `showSpinner` function creates and appends a spinner element to a given container.
 *
 * @param container - The "container" parameter is the element where you want to show the spinner. It
 *                  is the parent element that will contain the spinner element.
 */
export function showSpinner(container: HTMLElement): void {
	// Create and append spinner element
	const hasSpinner = container.querySelector('.spinner');
	if (!hasSpinner) {
		const spinner = document.createElement('div');
		spinner.style.margin = '36px auto';
		spinner.style.textAlign = 'center';
		spinner.innerHTML =
			'<svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12,1A11,11,0,1,0,23,12,11,11,0,0,0,12,1Zm0,19a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z" opacity=".25"/><path d="M10.14,1.16a11,11,0,0,0-9,8.92A1.59,1.59,0,0,0,2.46,12,1.52,1.52,0,0,0,4.11,10.7a8,8,0,0,1,6.66-6.61A1.42,1.42,0,0,0,12,2.69h0A1.57,1.57,0,0,0,10.14,1.16Z"><animateTransform attributeName="transform" type="rotate" dur="0.75s" values="0 12 12;360 12 12" repeatCount="indefinite"/></path></svg>';
		container.appendChild(spinner);
	}
}

/**
 * The function hides the spinner element by removing it from the container.
 *
 * @param container - The container parameter is the element that contains the spinner element. It is
 *                  the parent element of the spinner element that you want to remove.
 */
export function hideSpinner(container: HTMLElement): void {
	// Remove spinner element
	const spinner = container.querySelector('.spinner');
	if (spinner) {
		spinner.remove();
	}
}

/**
 * The debounce function is a utility function that delays the execution of a given function by a
 * specified delay time.
 *
 * @param fn    - The `fn` parameter is a function that you want to debounce. It is the function that will
 *              be called after the specified delay has passed without any new invocations.
 * @param delay - The `delay` parameter is the amount of time in milliseconds that the function should
 *              wait before executing the debounced function.
 * @return The debounce function is returning a new function that will execute the provided function
 * (fn) after a specified delay (delay) has passed.
 */
export const debounce = (fn: (searchTerm) => void, delay: number) => {
	let timerId;
	return (...args) => {
		clearTimeout(timerId);
		timerId = setTimeout(() => {
			fn(...args);
		}, delay);
	};
};

/**
 * The function `getCookieValue` is a TypeScript function that retrieves the value of a cookie by its
 * name.
 *
 * @param name - The name parameter is a string that represents the name of the cookie whose value you
 *             want to retrieve.
 */
export const getCookieValue = (name) =>
	document.cookie.match('(^|;)\\s*' + name + '\\s*=\\s*([^;]+)')?.pop() || '';

/**
 * The `liveSearch` function fetches data from a REST API based on a given query and displays the
 * results in a search results div.
 *
 * @param query - The `query` parameter is the search query that is used to search for data in the REST
 *              API. It is passed as the `data` property in the `apiFetch` function call.
 * @return The liveSearch function is returning a Promise.
 */
export async function liveSearch(query): Promise<Object> {
	// Fetch data from REST API
	return apiFetch({
		path: '/vsge/v2/live-search',
		method: 'POST',
		data: { query },
	})
		.then((data) => {
			// Display results in the search results div
			if (data) {
				return data;
			}
			return false;
		})
		.catch((error) => {
			console.error(error);
		});
}
