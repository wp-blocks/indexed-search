<?php
/**
 * Registers a custom block variation for the `core/search` block.
 */
function register_search_block_variation() {
	// Define the variation attributes
	$variation_attributes = array();

	$variation_render_callback = function ( $attributes, $content, $block ) {
		// Older versions of the Search block defaulted the label and buttonText
		// attributes to `__( 'Search' )` meaning that many posts contain `<!--
		// wp:search /-->`. Support these by defaulting an undefined label and
		// buttonText to `__( 'Search' )`.
		$attributes = wp_parse_args(
			$attributes,
			array(
				'label'      => __( 'Search', 'search-block' ),
				'buttonText' => __( 'Search', 'search-block' ),
			)
		);

		$input_id            = wp_unique_id( 'wp-block-search__input-' );
		$classnames          = classnames_for_block_core_search( $attributes );
		$show_label          = ( ! empty( $attributes['showLabel'] ) ) ? true : false;
		$use_icon_button     = ( ! empty( $attributes['buttonUseIcon'] ) ) ? true : false;
		$show_input          = ( ! empty( $attributes['buttonPosition'] ) && 'button-only' === $attributes['buttonPosition'] ) ? false : true;
		$show_button         = ( ! empty( $attributes['buttonPosition'] ) && 'no-button' === $attributes['buttonPosition'] ) ? false : true;
		$query_params        = ( ! empty( $attributes['query'] ) ) ? $attributes['query'] : array();
		$input_markup        = '';
		$button_markup       = '';
		$query_params_markup = '';
		$inline_styles       = styles_for_block_core_search( $attributes );
		$color_classes       = get_color_classes_for_block_core_search( $attributes );
		$typography_classes  = get_typography_classes_for_block_core_search( $attributes );
		$is_button_inside    = ! empty( $attributes['buttonPosition'] ) &&
		                       'button-inside' === $attributes['buttonPosition'];
		// Border color classes need to be applied to the elements that have a border color.
		$border_color_classes = get_border_color_classes_for_block_core_search( $attributes );

		$label_inner_html = empty( $attributes['label'] ) ? __( 'Search', 'search-block' ) : wp_kses_post( $attributes['label'] );

		$label_markup = sprintf(
			'<label for="%1$s" class="wp-block-search__label screen-reader-text">%2$s</label>',
			esc_attr( $input_id ),
			$label_inner_html
		);

		if ( $show_label && ! empty( $attributes['label'] ) ) {
			$label_classes = array( 'wp-block-search__label' );
			if ( ! empty( $typography_classes ) ) {
				$label_classes[] = $typography_classes;
			}
			$label_markup = sprintf(
				'<label for="%1$s" class="%2$s" %3$s>%4$s</label>',
				esc_attr( $input_id ),
				esc_attr( implode( ' ', $label_classes ) ),
				$inline_styles['label'],
				$label_inner_html
			);
		}

		if ( $show_input ) {
			$input_classes = array( 'wp-block-search__input' );
			if ( ! $is_button_inside && ! empty( $border_color_classes ) ) {
				$input_classes[] = $border_color_classes;
			}
			if ( ! empty( $typography_classes ) ) {
				$input_classes[] = $typography_classes;
			}
			$input_markup = sprintf(
				'<input type="search" id="%s" class="%s" name="s" value="%s" placeholder="%s" %s required />',
				$input_id,
				esc_attr( implode( ' ', $input_classes ) ),
				get_search_query(),
				esc_attr( $attributes['placeholder'] ),
				$inline_styles['input']
			);
		}

		if ( count( $query_params ) > 0 ) {
			foreach ( $query_params as $param => $value ) {
				$query_params_markup .= sprintf(
					'<input type="hidden" name="%s" value="%s" />',
					esc_attr( $param ),
					esc_attr( $value )
				);
			}
		}

		if ( $show_button ) {
			$button_classes         = array( 'wp-block-search__button' );
			$button_internal_markup = '';
			if ( ! empty( $color_classes ) ) {
				$button_classes[] = $color_classes;
			}
			if ( ! empty( $typography_classes ) ) {
				$button_classes[] = $typography_classes;
			}
			$aria_label = '';

			if ( ! $is_button_inside && ! empty( $border_color_classes ) ) {
				$button_classes[] = $border_color_classes;
			}
			if ( ! $use_icon_button ) {
				if ( ! empty( $attributes['buttonText'] ) ) {
					$button_internal_markup = wp_kses_post( $attributes['buttonText'] );
				}
			} else {
				$aria_label       = sprintf( 'aria-label="%s"', esc_attr( wp_strip_all_tags( $attributes['buttonText'] ) ) );
				$button_classes[] = 'has-icon';

				$button_internal_markup =
					'<svg class="search-icon" viewBox="0 0 24 24" width="24" height="24">
					<path d="M13.5 6C10.5 6 8 8.5 8 11.5c0 1.1.3 2.1.9 3l-3.4 3 1 1.1 3.4-2.9c1 .9 2.2 1.4 3.6 1.4 3 0 5.5-2.5 5.5-5.5C19 8.5 16.5 6 13.5 6zm0 9.5c-2.2 0-4-1.8-4-4s1.8-4 4-4 4 1.8 4 4-1.8 4-4 4z"></path>
				</svg>';
			}

			// Include the button element class.
			$button_classes[] = wp_theme_get_element_class_name( 'button' );
			$button_markup    = sprintf(
				'<button type="submit" class="%s" %s %s>%s</button>',
				esc_attr( implode( ' ', $button_classes ) ),
				$inline_styles['button'],
				$aria_label,
				$button_internal_markup
			);
		}

		$field_markup_classes = $is_button_inside ? $border_color_classes : '';
		$field_markup         = sprintf(
			'<div class="wp-block-search__inside-wrapper %s" %s>%s</div>',
			esc_attr( $field_markup_classes ),
			$inline_styles['wrapper'],
			$input_markup . $query_params_markup . $button_markup
		);
		$wrapper_attributes   = get_block_wrapper_attributes(
			array( 'class' => $classnames )
		);

		return sprintf(
			'<form role="search" method="get" autocomplete="off" action="%s" %s>%s</form>',
			esc_url( home_url( '/' ) ),
			$wrapper_attributes,
			$label_markup . $field_markup
		);
	};

	// Get the existing block type
	$cloned_block = WP_Block_Type_Registry::get_instance()->get_registered( 'core/search' );

	// Add the variation attributes
	$cloned_block->attributes = array_merge( $cloned_block->attributes, $variation_attributes );

	$cloned_block->name     = 'search-block';
	$cloned_block->title    = __( 'Live Search', 'search-block' );
	$cloned_block->category = 'wp-blocks';

	// Add the variation rendering callback
	$cloned_block->render_callback = $variation_render_callback;

	$namespace   = 'wp-blocks';
	$block_title = 'search-block';

	// Register the new block type.
	register_block_type( $namespace . '/' . $block_title, $cloned_block );
}

add_action( 'init', 'register_search_block_variation' );
