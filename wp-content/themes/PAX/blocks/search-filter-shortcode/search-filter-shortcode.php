<?php
/**
 * Search & Filter Shortcode
 *
 * @param array  $block      The block settings and attributes.
 * @param string $content    The block inner HTML (empty).
 * @param bool   $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 *
 * @package PAX
 */

$section_header = get_field('section_header');
$search_shortcode = get_field('search_shortcode');
$results_shortcode = get_field('results_shortcode');
if(!empty($section_header) || !empty($search_shortcode) || !empty($results_shortcode)){
	// Create id attribute allowing for custom "anchor" value.
	$id = 'search-filter-shortcode-' . $block['id'];

	if ( ! empty( $block['anchor'] ) ) {
		$id = $block['anchor'];
	}

	// Create class attribute allowing for custom "className".
	$section_class_name = 'search-filter-shortcode';

	if ( ! empty( $block['className'] ) ) {
		$section_class_name .= ' ' . $block['className'];
	}

	// Start a <container> with possible block options.
	$container_args = [
		'container' => 'section', // Any HTML5 container: section, div, etc...
		'id'        => $id, // Container id.
		'class'     => $section_class_name, // Container class.
	];

	pax_display_block_background_options( $block, $container_args ); ?>
		<div class="hero-banner-outer"><?php
			if(!empty($section_header)){
				pax_section_header($section_header);
			} ?>
			<div class="shortcode-box-outer" id="shortcode_result"><?php
                if(!empty($search_shortcode)){ ?>
                    <div class="shortcode-filter">
                        <div class="shortcode-filter-inner">
                            <?php echo $search_shortcode; ?>
                        </div>
                    </div><?php
                } 
                if(!empty($results_shortcode)){ ?>
                    <div class="shortcode-result">
                        <?php echo $results_shortcode; ?>
                    </div><?php
                } ?>
            </div>
		</div><?php
		
	pax_close_block( $container_args['container'] );
}