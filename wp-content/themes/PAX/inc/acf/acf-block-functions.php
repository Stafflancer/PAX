<?php
/**
 * Associate the possible block options with the appropriate section.
 *
 * @param array $block
 * @param array $container_args
 * @param array $content_args
 * @param bool  $module
 *
 * @return void
 */
function pax_display_block_background_options( array $block, array $container_args = [], array $content_args = [], bool $module = false ) {
	
	/**
	 * Get block/module background options.
	 */
	if ( $module ) {
		// Module background options, if used in an ACF group block.
		$background_options = get_sub_field( 'background_options' );
	} else {
		// ACF block background options.
		$background_options = get_field( 'background_options' )['background_options'];
	}

	/**
	 * Get block/module settings.
	 */
	$container_attributes = get_template_acf_block_settings( $block, $module );

	/**
	 * Setup block/module container defaults.
	 */
	$container_defaults = [
		'container'       => 'section',
		'id'              => '',
		'class'           => 'acf-block  overflow-hidden ',
		'background_type' => $background_options['background_type'],
	];

	/**
	 * Parse block/module container args.
	 */
	$container_args = wp_parse_args( $container_args, $container_defaults );

	// Align class must be applied to the main wrapper to work properly.
	$container_args['class'] .= ' ' . $container_attributes['align'];


	/**
	 * Setup content defaults: align_text, align_content, content_size.
	 */
	$content_defaults = [
		'class' => '',
	];

	// Parse block/module content args.
	$content_args = wp_parse_args( $content_args, $content_defaults );

	/**
	 * Join content classes for the block/module.
	 * Create class attribute allowing for custom 'container_size', 'align_text' and 'align_content' values.
	 */
	$content_class_name = join( ' ', [
		$content_args['class'],
		$container_attributes['container_size'],
		$container_attributes['container_padding_top'],
		$container_attributes['container_padding_bottom'],
		$container_attributes['container_margin_top'],
		$container_attributes['container_margin_bottom'],
		$container_attributes['heading_color'],
		$container_attributes['text_color'],
	] );

	$background_video_markup = $background_image_markup = $background_overlay_markup = $background_pattern_markup = '';

	// Only try to get the rest of the settings if the background type is set to anything.
	if ( $container_args['background_type'] ) {
		if ( 'none' === $container_args['background_type'] ) {
			$container_args['class'] .= ' no-background ';
		}
		$container_args['class'] .= ' position-relative ';
		
		if ( 'color' === $container_args['background_type'] && $background_options['background_color']['color_picker'] ) {
			$background_color        = $background_options['background_color']['color_picker'];
			$container_args['class'] .= ' has-background color-as-background has-' . esc_attr( $background_color ) . '-background-color ';
		}

		if ( 'image' === $container_args['background_type'] ) {
			$background_image_id   = '';
			$background_image_size = 'full-width';

			if ( $background_options['background_image'] ) {
				$background_image_id = $background_options['background_image']['ID'];
			}

			// Make sure images stay in their containers - relative + overflow hidden.
			$container_args['class'] .= ' has-background image-as-background  overflow-hidden';

			ob_start();
			$background_class = 'image-background d-block w-100 h-100 m-0 position-absolute top-0 bottom-0 start-0 end-0 object-center z-0';

			if ( $background_options['has_parallax'] ):
				$background_class .= ' bg-fixed bg-center bg-cover';
				$background_image_url = wp_get_attachment_image_url( $background_image_id, $background_image_size );
				?>
				<figure class="<?php echo esc_attr( $background_class ); ?>"
				        style="background-image:url(<?php echo $background_image_url; ?>);" aria-hidden="true"></figure>
			<?php else:
				?>
				<figure class="<?php echo esc_attr( $background_class ); ?>" aria-hidden="true">
					<?php echo wp_get_attachment_image( $background_image_id, $background_image_size, false, array( 'class' => 'w-100 h-100 object-cover' ) ); ?>
				</figure>
			<?php endif; ?>
			<?php
			$background_image_markup = ob_get_clean();
		}

		if ( 'video' === $container_args['background_type'] && ! empty( $background_options['background_oembed_video'] ) ) {
			$background_video = $background_options['background_oembed_video'];
            // Use preg_match to find iframe src.
            preg_match('/src="(.+?)"/', $background_video, $matches);
            $src = $matches[1];
            // Add extra parameters to src and replace HTML.
            $params = array(
				'controls'  => 0,
				'muted'        => 1,
				'hd'        => 1,
				'autoplay' => 1,
				'loop' => 1,
            );
            $new_src = add_query_arg($params, $src);
            $iframe = str_replace($src, $new_src, $background_video);

            // Add extra attributes to iframe HTML.
            $attributes = 'frameborder="0"';
            $iframe = str_replace('></iframe>', ' ' . $attributes . '></iframe>', $iframe);

			// Make sure videos stay in their containers - relative + overflow hidden.
			$container_args['class'] .= ' has-background video-as-background  overflow-hidden';

			ob_start();
			?>
			<figure class="video-background d-block h-auto w-100 h-100 object-cover m-0 position-absolute top-0 bottom-0 start-0 end-0 object-top z-0">
				<?php echo $iframe; ?>
			</figure>
			<?php
			$background_video_markup = ob_get_clean();
		}

		if ( 'image' === $container_args['background_type'] || 'video' === $container_args['background_type'] ) {
			if ( $background_options['has_overlay'] == 1 && $background_options['overlay_type'] == 'color') {
				$overlay_class = 'position-absolute z-1 has-background-dim';
				$overlay_color = $background_options['overlay_color']['color_picker'];

				if ( '' !== $overlay_color ) {
					$overlay_class .= ' has-' . esc_attr( $overlay_color ) . '-background-color';
				}

				if ( ! empty( $background_options['overlay_opacity'] ) && is_numeric( $background_options['overlay_opacity'] ) ) {
					$overlay_class .= ' has-background-dim-' . esc_attr( $background_options['overlay_opacity'] );
				}

				ob_start();
				?>
				<span aria-hidden="true" class="<?php esc_attr_e( $overlay_class ); ?>"></span>
				<?php
				$background_overlay_markup = ob_get_clean();
			}

			if ( $background_options['has_overlay'] == 1 && $background_options['overlay_type'] == 'gradient') {
				$overlay_class = 'position-absolute z-1 has-background-dim';
				$gradient = $background_options['gradient'];

				if ( '' !== $gradient ) {
					$overlay_class .= ' has-' . esc_attr( $gradient ) . '-gradient-color';
				}

				if ( ! empty( $background_options['overlay_opacity'] ) && is_numeric( $background_options['overlay_opacity'] ) ) {
					$overlay_class .= ' has-background-dim-' . esc_attr( $background_options['overlay_opacity'] );
				}

				ob_start();
				?>
				<span aria-hidden="true" class="w-100 h-100 m-0 <?php esc_attr_e( $overlay_class ); ?>"></span>
				<?php
				$background_overlay_markup = ob_get_clean();
			}

			if ( $background_options['has_parallax'] ) {
				$container_args['class'] .= ' has-parallax';
			}
		}
		if ( $background_options['has_pattern'] == 1) {
			if ( $background_options['pattern_image'] ){
				ob_start();
				$pattern_image = $background_options['pattern_image']; 
				if(!empty($pattern_image) && !empty($pattern_image['url']))?>
				<figure class="has-pattern-show"><img src="<?php echo $pattern_image['url']; ?>"></figure><?php 
				$background_pattern_markup = ob_get_clean();
			} 
			
		}
		if ( $background_options['separator'] ) {
			$separator = $background_options['separator'];
			foreach( $separator as $separatorvalue ){
				$container_args['class'] .= ' separator-'.$separatorvalue.'';
			}
		}
	}

	// Print our block container with options.
	printf( '<%s id="%s" class="%s">', esc_html( $container_args['container'] ), esc_attr( $container_args['id'] ), esc_attr( $container_args['class'] ) );

	// If we have an overlay, echo our overlay markup inside the block container.
	if ( $background_overlay_markup ) {
		echo $background_overlay_markup; // WPCS XSS OK.
	}

	// If we have a background video, echo our background video markup inside the block container.
	if ( $background_video_markup ) {
		echo $background_video_markup; // WPCS XSS OK.
	}

	// If we have a background image, echo our background image markup inside the block container.
	if ( $background_image_markup ) {
		echo $background_image_markup; // WPCS XSS OK.
	}

	// If we have a pattern image and enable pattern option, echo our pattern image markup.
	if ( $background_pattern_markup ) {
		echo $background_pattern_markup; // WPCS XSS OK.
	}

	/**
	 * Print our block/module content container:
	 * align_text - text-(left | center | right) classes.
	 * align_content - justify-content-* and align-items-* classes.
	 * container_size - container or container-fluid class.
	 */
	printf( '<div class="z-10 position-relative inner-container %s">', esc_attr( $content_class_name ) );

	/**
	 * Print our block/module content with width classes:
	 * content_width - col-* classes
	 */
	printf( '<div class="%s">', esc_attr( $container_attributes['content_width'] ) );
}

function pax_close_block( string $container ) {
	if ( ! empty( $container ) && is_string( $container ) ) {
		printf( '</div>' ); // Close content with .col-* classes.
		printf( '</div>' ); // Close layout .inner-container.
		printf( '</%s>', esc_html( $container ) ); // Close main container.
	}
}

/**
 * Associate the block settings with the appropriate section.
 *
 * @param array $block Block settings.
 *
 * @return array $block_settings
 */
function get_template_acf_block_settings( $block, $module ) {
	// Bail if the $block is not provided.
	if ( empty( $block ) ) {
		return [];
	}

	// Setup defaults.
	$defaults = [
		'align'             => 'alignfull',
		'heading_color'		=> '',
		'text_color'		=> '',
		'align_text'        => '',
		'align_content'     => '',
		'container_size'    => 'container',
		'container_padding_top' => '',
		'container_padding_bottom' => '',
		'container_margin_top' => '',
		'container_margin_bottom' => '',
		'content_width'     => 'col-12',
	];

	$block_settings = [];

	// Get block display options.
	if ( $module ) {
		$display_options = get_sub_field( 'display_options' );
	} else {
		$display_options = get_field( 'display_options' )['display_options'];
	}

	// Set the container width.
	if ( isset( $display_options['container_size'] ) && ! empty( $display_options['container_size'] ) ) {
		$block_settings['container_size'] = esc_attr( $display_options['container_size'] );
	}

	// Set the heading color.
	if ( isset( $display_options['heading_color'] ) && ! empty( $display_options['heading_color'] ) ) {
		$block_settings['heading_color'] = 'heading-color'.esc_attr( $display_options['heading_color'] );
	}

	// Set the text color.
	if ( isset( $display_options['text_color'] ) && ! empty( $display_options['text_color'] ) ) {
		$block_settings['text_color'] = 'text-color'.esc_attr( $display_options['text_color'] );
	}

	// Set content width.
	if ( isset( $display_options['content_width'] ) && ! empty( $display_options['content_width'] ) ) {
		switch ( $display_options['content_width'] ) {
			case '6':
				$block_settings['content_width'] = 'col-12 col-md-6';
				break;
			case '7':
				$block_settings['content_width'] = 'col-12 col-md-7';
				break;
			case '8':
				$block_settings['content_width'] = 'col-12 col-md-8';
				break;
			case '9':
				$block_settings['content_width'] = 'col-12 col-md-9';
				break;
			case '10':
				$block_settings['content_width'] = 'col-12 col-md-10';
				break;
			case '11':
				$block_settings['content_width'] = 'col-12 col-md-11';
				break;
			case '12':
			default:
				$block_settings['content_width'] = 'col-12';
				break;
		}
	}

	// Set top/bottom padding for the block.
	if ( isset( $display_options['container_padding_top'] ) && ! empty( $display_options['container_padding_top'] ) ) {
		switch ( $display_options['container_padding_top'] ) {
			case 'sm':
				$block_settings['container_padding_top'] = 'padding-top-small';
				break;
			case 'md':
				$block_settings['container_padding_top'] = 'padding-top-medium';
				break;
			case 'lg':
				$block_settings['container_padding_top'] = 'padding-top-large';
				break;
			case 'none':
			default:
				$block_settings['container_padding_top'] = 'pt-0';
				break;
		}
	}

	if ( isset( $display_options['container_padding_bottom'] ) && ! empty( $display_options['container_padding_bottom'] ) ) {
		switch ( $display_options['container_padding_bottom'] ) {
			case 'sm':
				$block_settings['container_padding_bottom'] = 'padding-bottom-small';
				break;
			case 'md':
				$block_settings['container_padding_bottom'] = 'padding-bottom-medium';
				break;
			case 'lg':
				$block_settings['container_padding_bottom'] = 'padding-bottom-large';
				break;
			case 'none':
			default:
				$block_settings['container_padding_bottom'] = 'pb-0';
				break;
		}
	}

	// Set top/bottom margin for the block.
	if ( isset( $display_options['container_margin_top'] ) && ! empty( $display_options['container_margin_top'] ) ) {
		switch ( $display_options['container_margin_top'] ) {
			case 'sm':
				$block_settings['container_margin_top'] = 'margin-top-small';
				break;
			case 'md':
				$block_settings['container_margin_top'] = 'margin-top-medium';
				break;
			case 'lg':
				$block_settings['container_margin_top'] = 'margin-top-large';
				break;
			case 'none':
			default:
				$block_settings['container_margin_top'] = 'mt-0';
				break;
		}
	}

	if ( isset( $display_options['container_margin_bottom'] ) && ! empty( $display_options['container_margin_bottom'] ) ) {
		switch ( $display_options['container_margin_bottom'] ) {
			case 'sm':
				$block_settings['container_margin_bottom'] = 'margin-bottom-small';
				break;
			case 'md':
				$block_settings['container_margin_bottom'] = 'margin-bottom-medium';
				break;
			case 'lg':
				$block_settings['container_margin_bottom'] = 'margin-bottom-large';
				break;
			case 'none':
			default:
				$block_settings['container_margin_bottom'] = 'mb-0';
				break;
		}
	}

	// Parse args.
	$block_settings = wp_parse_args( $block_settings, $defaults );

	return $block_settings;
}


/**
 * Load colors dynamically into select field from @param array $field field options.
 *
 * @return array new field choices.
 * @see pax_get_theme_colors().
 *
 */
function pax_acf_load_color_picker_field_choices( $field ) {
	// Reset choices.
	$field['choices'] = [];

	// Grab our colors array.
	$colors = pax_get_theme_colors();

	// Loop through colors.
	foreach ( $colors as $key => $color ) {
		// Create display markup.
		$color_output = '<div style="display: flex; align-items: center;"><span style="background-color:' . esc_attr( $color ) . '; border: 1px solid #ccc;display:inline-block; height: 15px; margin-right: 10px; width: 15px;"></span>' . esc_html( $key ) . '</div>';

		// Set values.
		$field['choices'][ sanitize_title( $key ) ] = $color_output;
	}

	// Return the field.
	return $field;
}

add_filter( 'acf/load_field/name=color_picker', 'pax_acf_load_color_picker_field_choices' );

/**
 * Get the theme colors for this project. Set these first in the Sass partial then migrate them over here.
 *
 * @return array The array of our color names and hex values.
 */
function pax_get_theme_colors() {
	$theme_colors    = [];
	$theme_json_file = get_theme_file_path( 'theme.json' );

	if ( file_exists( $theme_json_file ) ) {
		$theme_json_contents = file_get_contents( $theme_json_file );
		$theme_json_data     = json_decode( $theme_json_contents, true );

		if ( ! empty( $theme_json_data ) && ! empty( $theme_json_data['settings']['color']['palette'] ) ) {
			foreach ( $theme_json_data['settings']['color']['palette'] as $color ) {
				$color_name  = esc_html__( $color['name'], THEME_TEXT_DOMAIN );
				$color_value = $color['color'];

				$theme_colors[ $color_name ] = $color_value;
			}
		}

		if ( ! empty( $theme_colors ) ) {
			return $theme_colors;
		}
	}

	return [
		esc_html__( 'Base', THEME_TEXT_DOMAIN )       => '#fff',
		esc_html__( 'Contrast', THEME_TEXT_DOMAIN )   => '#333333',
		esc_html__( 'Primary', THEME_TEXT_DOMAIN )     => '#11a1f2',
		esc_html__( 'Secondary', THEME_TEXT_DOMAIN )       => '#07055b',
		esc_html__( 'Accent Blue', THEME_TEXT_DOMAIN ) => '#2a7de1',
		esc_html__( 'Sky Blue', THEME_TEXT_DOMAIN )       => '#72d6f1',
		esc_html__( 'Green', THEME_TEXT_DOMAIN )     => '#21ba8c',
		esc_html__( 'Light Gray', THEME_TEXT_DOMAIN )        => '#a7b0b5',
	];
}

/**
 * Get the theme gradients for this project. Set these first in the Sass partial then migrate them over here.
 *
 * @return array The array of our gradients names and hex values.
 */
function pax_get_theme_gradients() {
	$theme_colors    = [];
	$theme_json_file = get_theme_file_path( 'theme.json' );

	if ( file_exists( $theme_json_file ) ) {
		$theme_json_contents = file_get_contents( $theme_json_file );
		$theme_json_data     = json_decode( $theme_json_contents, true );

		if ( ! empty( $theme_json_data ) && ! empty( $theme_json_data['settings']['color']['gradients'] ) ) {
			foreach ( $theme_json_data['settings']['color']['gradients'] as $gradient ) {
				$gradient_name  = esc_html__( $gradient['name'], THEME_TEXT_DOMAIN );
				$gradient_value = $gradient;

				$theme_gradients[ $gradient_name ] = $gradient_value;
			}
		}

		if ( ! empty( $theme_gradients ) ) {
			return $theme_gradients;
		}
	}

	return [
		esc_html__( 'Dark Blue to Transparent', THEME_TEXT_DOMAIN )       => 'linear-gradient(90deg, #07055b 0%, #07055b00 100%)',
		esc_html__( 'Transparent to Dark Blue', THEME_TEXT_DOMAIN )   => 'linear-gradient(90deg, #07055b00 0%, #07055b 100%)',
	];
}

/**
 * Load gradients dynamically into select field from @param array $field field options.
 *
 * @return array new field choices.
 * @see pax_get_theme_gradients().
 *
 */
function pax_acf_load_gradients_field_choices( $field ) {
	// Reset choices.
	$field['choices'] = [];

	// Grab our gradients array.
	$gradients = pax_get_theme_gradients();

	// Loop through gradients.
	foreach ( $gradients as $key => $gradient ) {

		// Create display markup.
		$gradient_output = '<div style="display: flex; align-items: center;"><span style="background:' . esc_attr( $gradient['gradient'] ) . '; border: 1px solid #ccc;display:inline-block; height: 15px; margin-right: 10px; width: 15px;"></span>' . esc_html( $key ) . '</div>';

		// Set values.
		$field['choices'][ sanitize_title( $key ) ] = $gradient_output;
	}

	// Return the field.
	return $field;
}

add_filter( 'acf/load_field/name=gradient', 'pax_acf_load_gradients_field_choices' );


function pax_global_background_display_options( array $block, array $container_args = []) {

	$background_options = $block['background_options'];
	$display_options = $block['display_options'];


	/**
	 * Setup block/module container defaults.
	 */
	$container_defaults = [
		'container'       => 'section',
		'id'              => '',
		'class'           => 'acf-block  overflow-hidden ',
		'background_type' => $background_options['background_type'],
	];

	/**
	 * Parse block/module container args.
	 */
	$container_args = wp_parse_args( $container_args, $container_defaults );

	// Align class must be applied to the main wrapper to work properly.
	$container_args['class'] .= ' ' . $display_options['align'];


	/**
	 * Setup content defaults: align_text, align_content, content_size.
	 */
	$content_defaults = [
		'class' => '',
	];

	// Parse block/module content args.
	$content_args = wp_parse_args( $content_args, $content_defaults );

	/**
	 * Join content classes for the block/module.
	 * Create class attribute allowing for custom 'container_size', 'align_text' and 'align_content' values.
	 */
	$content_class_name = join( ' ', [
		$content_args['class'],
		$display_options['container_size'],
		$display_options['container_padding_top'],
		$display_options['container_padding_bottom'],
		$display_options['container_margin_top'],
		$display_options['container_margin_bottom'],
		'heading-color'.$display_options['heading_color'],
		'text-color'.$display_options['text_color'],
	] );

	$background_video_markup = $background_image_markup = $background_overlay_markup = $background_pattern_markup = '';

	// Only try to get the rest of the settings if the background type is set to anything.
	if ( $container_args['background_type'] ) {
		if ( 'none' === $container_args['background_type'] ) {
			$container_args['class'] .= ' no-background ';
		}
		$container_args['class'] .= ' position-relative ';
		
		if ( 'color' === $container_args['background_type'] && $background_options['background_color']['color_picker'] ) {
			$background_color        = $background_options['background_color']['color_picker'];
			$container_args['class'] .= ' has-background color-as-background has-' . esc_attr( $background_color ) . '-background-color ';
		}

		if ( 'image' === $container_args['background_type'] ) {
			$background_image_id   = '';
			$background_image_size = 'full-width';

			if ( $background_options['background_image'] ) {
				$background_image_id = $background_options['background_image']['ID'];
			}

			// Make sure images stay in their containers - relative + overflow hidden.
			$container_args['class'] .= ' has-background image-as-background  overflow-hidden';

			ob_start();
			$background_class = 'image-background d-block w-100 h-100 m-0 position-absolute top-0 bottom-0 start-0 end-0 object-center z-0';

			if ( $background_options['has_parallax'] ):
				$background_class .= ' bg-fixed bg-center bg-cover';
				$background_image_url = wp_get_attachment_image_url( $background_image_id, $background_image_size );
				?>
				<figure class="<?php echo esc_attr( $background_class ); ?>"
				        style="background-image:url(<?php echo $background_image_url; ?>);" aria-hidden="true"></figure>
			<?php else:
				?>
				<figure class="<?php echo esc_attr( $background_class ); ?>" aria-hidden="true">
					<?php echo wp_get_attachment_image( $background_image_id, $background_image_size, false, array( 'class' => 'w-100 h-100 object-cover' ) ); ?>
				</figure>
			<?php endif; ?>
			<?php
			$background_image_markup = ob_get_clean();
		}

		if ( 'video' === $container_args['background_type'] && ! empty( $background_options['background_oembed_video'] ) ) {
			$background_video = $background_options['background_oembed_video'];
            // Use preg_match to find iframe src.
            preg_match('/src="(.+?)"/', $background_video, $matches);
            $src = $matches[1];
            // Add extra parameters to src and replace HTML.
            $params = array(
				'controls'  => 0,
				'muted'        => 1,
				'hd'        => 1,
				'autoplay' => 1,
				'loop' => 1,
            );
            $new_src = add_query_arg($params, $src);
            $iframe = str_replace($src, $new_src, $background_video);

            // Add extra attributes to iframe HTML.
            $attributes = 'frameborder="0"';
            $iframe = str_replace('></iframe>', ' ' . $attributes . '></iframe>', $iframe);

			// Make sure videos stay in their containers - relative + overflow hidden.
			$container_args['class'] .= ' has-background video-as-background  overflow-hidden';

			ob_start();
			?>
			<figure class="video-background d-block h-auto w-100 h-100 object-cover m-0 position-absolute top-0 bottom-0 start-0 end-0 object-top z-0">
				<?php echo $iframe; ?>
			</figure>
			<?php
			$background_video_markup = ob_get_clean();
		}

		if ( 'image' === $container_args['background_type'] || 'video' === $container_args['background_type'] ) {
			if ( $background_options['has_overlay'] == 1 && $background_options['overlay_type'] == 'color') {
				$overlay_class = 'position-absolute z-1 has-background-dim';
				$overlay_color = $background_options['overlay_color']['color_picker'];

				if ( '' !== $overlay_color ) {
					$overlay_class .= ' has-' . esc_attr( $overlay_color ) . '-background-color';
				}

				if ( ! empty( $background_options['overlay_opacity'] ) && is_numeric( $background_options['overlay_opacity'] ) ) {
					$overlay_class .= ' has-background-dim-' . esc_attr( $background_options['overlay_opacity'] );
				}

				ob_start();
				?>
				<span aria-hidden="true" class="<?php esc_attr_e( $overlay_class ); ?>"></span>
				<?php
				$background_overlay_markup = ob_get_clean();
			}

			if ( $background_options['has_overlay'] == 1 && $background_options['overlay_type'] == 'gradient') {
				$overlay_class = 'position-absolute z-1 has-background-dim';
				$gradient = $background_options['gradient'];

				if ( '' !== $gradient ) {
					$overlay_class .= ' has-' . esc_attr( $gradient ) . '-gradient-color';
				}

				if ( ! empty( $background_options['overlay_opacity'] ) && is_numeric( $background_options['overlay_opacity'] ) ) {
					$overlay_class .= ' has-background-dim-' . esc_attr( $background_options['overlay_opacity'] );
				}

				ob_start();
				?>
				<span aria-hidden="true" class="w-100 h-100 m-0 <?php esc_attr_e( $overlay_class ); ?>"></span>
				<?php
				$background_overlay_markup = ob_get_clean();
			}

			if ( $background_options['has_parallax'] ) {
				$container_args['class'] .= ' has-parallax';
			}
		}
		if ( $background_options['has_pattern'] == 1) {
			if ( $background_options['pattern_image'] ){
				ob_start();
				$pattern_image = $background_options['pattern_image']; 
				if(!empty($pattern_image) && !empty($pattern_image['url']))?>
				<figure class="has-pattern-show"><img src="<?php echo $pattern_image['url']; ?>"></figure><?php 
				$background_pattern_markup = ob_get_clean();
			} 
			
		}
		if ( $background_options['separator'] ) {
			$separator = $background_options['separator'];
			foreach( $separator as $separatorvalue ){
				$container_args['class'] .= ' separator-'.$separatorvalue.'';
			}
		}
	}

	// Print our block container with options.
	printf( '<%s id="%s" class="%s">', esc_html( $container_args['container'] ), esc_attr( $container_args['id'] ), esc_attr( $container_args['class'] ) );

	// If we have an overlay, echo our overlay markup inside the block container.
	if ( $background_overlay_markup ) {
		echo $background_overlay_markup; // WPCS XSS OK.
	}

	// If we have a background video, echo our background video markup inside the block container.
	if ( $background_video_markup ) {
		echo $background_video_markup; // WPCS XSS OK.
	}

	// If we have a background image, echo our background image markup inside the block container.
	if ( $background_image_markup ) {
		echo $background_image_markup; // WPCS XSS OK.
	}

	// If we have a pattern image and enable pattern option, echo our pattern image markup.
	if ( $background_pattern_markup ) {
		echo $background_pattern_markup; // WPCS XSS OK.
	}

	/**
	 * Print our block/module content container:
	 * align_text - text-(left | center | right) classes.
	 * align_content - justify-content-* and align-items-* classes.
	 * container_size - container or container-fluid class.
	 */
	printf( '<div class="z-10 position-relative inner-container %s">', esc_attr( $content_class_name ) );

	/**
	 * Print our block/module content with width classes:
	 * content_width - col-* classes
	 */
	printf( '<div class="%s">', esc_attr( $container_attributes['content_width'] ) );

}