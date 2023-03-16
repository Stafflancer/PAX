<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link    https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Bopper
 */

get_header();

$heading = get_field('heading', 'option');
$content = get_field('content', 'option');
$buttons = get_field('buttons_group', 'option');
$block = get_field('404_page_background_options', 'option'); ?>
	<main id="main" class="site-main site-content wp-block-group" role="main"><?php
		// Create id attribute allowing for custom "anchor" value.
		$id = '404-page' . $block['id'];

		if ( ! empty( $block['anchor'] ) ) {
			$id = $block['anchor'];
		}

		// Create class attribute allowing for custom "className".
		$section_class_name = 'page-404';

		if ( ! empty( $block['className'] ) ) {
			$section_class_name .= ' ' . $block['className'];
		} 
		// Start a <container> with possible block options.
		$container_args = [
			'container' => 'section', // Any HTML5 container: section, div, etc...
			'id'        => $id, // Container id.
			'class'     => $section_class_name, // Container class.
		]; 
		pax_global_background_display_options($block, $container_args); ?>
		<div class="content-info-404"><?php
			if(!empty($heading)){ ?>
				<h2><?php echo $heading; ?></h2><?php
			} 
			if(!empty($content)){ ?>
				<div class="content-404">
					<?php echo $content; ?>
				</div><?php
			} 
			if ( $buttons ) { 
				$button = $buttons['button']; ?>
				<div class="d-flex is-layout-flex wp-block-buttons"><?php
					if ( ! empty( $button ) && ! empty( $button ) ) {
						$button_class  = '';
						$button_target = '';
						$button_text_color_class = '';
						$button_style  = $button['button_style'];
						$button_color_style  = $button['button_color_style'];
						$button_text_color_theme  = $button['button_text_color_theme']['color_picker'];
						if($button_color_style == 'color'){
							$button_color  = $button['button_color']['color_picker'];
							$button_class = ' has-' . esc_attr( $button_color ) . '-background-color has-background';
						}
						else{
							$button_color  = $button['gradient'];
							$button_class = ' has-' . esc_attr( $button_color ) . '-gradient-background';
						}
						if ( ! empty( $button['target'] ) ) {
							$button_target = ' target="' . esc_attr( $button['target'] ) . '"';
						}
						if ( ! empty( $button_text_color_theme ) ) {
							$button_text_color_class = ' has-' . esc_attr( $button_text_color_theme ) . '-color has-text-color';
						}
						if ( ! empty( $button_color ) ) {
							switch ( $button_style ) {
								case 'outline':
									$button_class = ' has-outline-' . esc_attr( $button_color ) . '-color outline-color';
									break;
								case 'fill':
								default:
									$button_class;
									break;
							}
						}
						?>
							<div class="wp-block-button is-style-<?php echo esc_attr( $button_style ); ?>">
								<a class="wp-block-button__link wp-element-button <?php echo esc_attr( $button_class ); ?> <?php echo esc_attr( $button_text_color_class ); ?>"
								   href="<?php echo esc_url( $button['url'] ); ?>"<?php echo $button_target; ?>>
									<?php esc_html_e( $button['title'], THEME_TEXT_DOMAIN ); ?>
								</a>
							</div><?php
					} ?>
				</div><?php 
			} ?>
		</div><?php
		pax_close_block( $container_args['container'] ); ?>
	</main>
<?php
get_footer();