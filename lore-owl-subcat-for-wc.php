<?php
/**
 * Plugin Name: Lore Owl SubCat for WC
 * Description: Show an Owl carousel of WooCommerce subcategories outside WooCommerce archive loop
 * Version: 1.0.1
 * Author: Lorenzo Moio
 * Author URI: lorenzomoio.it
 * License: GPLv2 or later
 * Text Domain: lore-owl-subcat-for-wc
 */

/*
Lore Owl SubCat for WC is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 2 of the License, or any later version.

Lore Owl SubCat for WC is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with Lore Owl SubCat for WC. If not, see https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html.
*/

defined('ABSPATH') or die( 'Stop cheating man!' );

// ADMIN AREA

	// Register settings page

add_action('admin_menu', 'losw_setup_menu');

function losw_setup_menu(){
	add_menu_page( 'Owl SubCat', 'Owl SubCat', 'manage_options', 'subcategories_carousel', 'losw_admin_init' );
}

	// Add settings link

add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'losw_add_plugin_page_settings_link');
function losw_add_plugin_page_settings_link( $links ) {
	$links[] = '<a href="' .
		admin_url( 'options-general.php?page=subcategories_carousel' ) .
		'">' . __('Settings') . '</a>';
	return $links;
}

	// Register settings

function losw_register_settings() {

	// Responsive options

	register_setting('losw_settings_group', 'mobile_noi');
	register_setting('losw_settings_group', 'tablet_noi');
	register_setting('losw_settings_group', 'desktop_noi');
	add_settings_section('losw_responsive_options','Subcategories Carousel Options','losw_responsive_options','subcategories_carousel');
	add_settings_field('responsive-mobile', 'Mobile (< 600px)', 'losw_mobile', 'subcategories_carousel', 'losw_responsive_options');
	add_settings_field('responsive-tablet', 'Tablet (600px - 1000px)', 'losw_tablet', 'subcategories_carousel', 'losw_responsive_options');
	add_settings_field('responsive-desktop', 'Desktop (> 1000px)', 'losw_desktop', 'subcategories_carousel', 'losw_responsive_options');

	// Navigation options

	register_setting('losw_settings_group', 'ch_arrows');
	register_setting('losw_settings_group', 'ch_dots');
	add_settings_field('ch-arrows', 'Show navigation arrows', 'losw_nav_arrows', 'subcategories_carousel', 'losw_responsive_options');
	add_settings_field('ch-dots', 'Show navigation dots', 'losw_nav_dots', 'subcategories_carousel', 'losw_responsive_options');

	// Style options

	register_setting('losw_settings_group', 'font_size');
	add_settings_field('font-size', 'Subcategories title font size', 'losw_font_size', 'subcategories_carousel', 'losw_responsive_options');
	register_setting('losw_settings_group', 'carousel_padding');
	add_settings_field('carousel-padding', 'Padding between items', 'losw_carousel_padding', 'subcategories_carousel', 'losw_responsive_options');
	register_setting('losw_settings_group', 'top_arrows');
	add_settings_field('top-arrows', 'Show navigation arrows on top of the carousel', 'losw_top_arrows', 'subcategories_carousel', 'losw_responsive_options');
}

function losw_responsive_options(){
	echo '<p>Choose number of items to display, navigation arrows and dots, arrow position.</p>';
}

	// Responsive fields

function losw_mobile() {
	$mobile_noi = get_option('mobile_noi');
	if( get_option('mobile_noi') ) {
	echo '<input type="number" name="mobile_noi" value="'.$mobile_noi.'" /><p class="description">Smartphone number of items. Default 2</p>';
	} else {
	echo '<input type="number" name="mobile_noi" value="2" /><p class="description">Smartphone number of items. Default 2</p>';	
	}
}

function losw_tablet() {
	$tablet_noi = get_option('tablet_noi');
	if( get_option('tablet_noi') ) {
	echo '<input type="number" name="tablet_noi" value="'.$tablet_noi.'" /><p class="description">Tablet number of items. Default 3</p>';
	} else {
	echo '<input type="number" name="tablet_noi" value="3" /><p class="description">Tablet number of items. Default 3</p>';	
	}
}

function losw_desktop() {
	$desktop_noi = get_option('desktop_noi');
	if( get_option('desktop_noi' )) {
	echo '<input type="number" name="desktop_noi" value="'.$desktop_noi.'" /><p class="description">Desktop number of items. Default 4</p>';
	} else {
	echo '<input type="number" name="desktop_noi" value="4" /><p class="description">Desktop number of items. Default 4</p>';	
	}
}

	// Navigation fields

function losw_nav_arrows() { 
	$options = get_option( 'ch_arrows' );
	$checked = ( @$options == 1 ? 'checked' : '' );
	echo '<input type="checkbox" id="ch_arrows" name="ch_arrows" value="1" '.$checked.' />';
 }

function losw_nav_dots() { 
	$options = get_option( 'ch_dots' );
	$checked = ( @$options == 1 ? 'checked' : '' );
	echo '<input type="checkbox" id="ch_dots" name="ch_dots" value="1" '.$checked.' />';
 }

add_action( 'admin_init', 'losw_register_settings' );

	// Font size

function losw_font_size() {
	$font_size = get_option('font_size');
	if( get_option('font_size') ) {
	echo '<input type="number" name="font_size" value="'.$font_size.'" /><p class="description">Default 14px</p>';
	} else {
	echo '<input type="number" name="font_size" value="14" /><p class="description">Default 14px</p>';	
	}
}

	// Padding

function losw_carousel_padding() {
	$carousel_padding = get_option('carousel_padding');
	if( get_option('carousel_padding') ) {
	echo '<input type="number" name="carousel_padding" value="'.$carousel_padding.'" /><p class="description">Default 5px</p>';
	} else {
	echo '<input type="number" name="carousel_padding" value="5" /><p class="description">Default 5px</p>';	
	}
}

	// Top Arrows

function losw_top_arrows() { 
	$options = get_option( 'top_arrows' );
	$checked = ( @$options == 1 ? 'checked' : '' );
	echo '<input type="checkbox" id="top_arrows" name="top_arrows" value="1" '.$checked.' />';
 }


	// Settings page function

function losw_admin_init() { ?>
	<div style="
	    flex-wrap: wrap;
	    display: flex;
	    align-items: center;
	    background: white;
	    padding: 20px;">
		<div style="margin-right: 25px;">
			<h3>Is this pugin useful?</h3>
			<p>Offer a cup of coffee to the developer!</p>
		</div>
		<div>
			<a style="background: linear-gradient(#f0d8b3,#de8906,#f0d8b3);font-weight: bold !important;border-color: #de8906;border-radius: 20px;padding: 0 15px;" class="button" href="https://www.paypal.me/lorenzomoio888" target="_blank">Donate <span style="vertical-align: middle;margin-top: -4px;" class="dashicons dashicons-heart"></span></a>
		</div>
	</div>
	<div class="wrap">
		<h1 class="wp-heading-inline">Owl SubCat for WC Options</h1>
		<p>Be shure to have set all the product subcategories thumbnails. I suggest to use 1:1 or 16:9 ratio.</p>
		<a class="button" href="<?php echo site_url(); ?>/wp-admin/edit-tags.php?taxonomy=product_cat&post_type=product">Check now</a>
	</div>
	<div class="wrap settings">
		<?php settings_errors(); ?>
		<form method="post" action="options.php">
			<?php settings_fields( 'losw_settings_group' ); ?>
			<?php do_settings_sections('subcategories_carousel'); ?>
			<?php submit_button(); ?>
		</form>
	</div>
<?php }

// FRONTEND

	// Load Owl Carousel files

function losw_enqueue_scripts() {   
    wp_enqueue_style( 'owl-default-css', plugin_dir_url( __FILE__ ) . '/assets/css/owl.theme.default.min.css','', '2.3.4' );
    wp_enqueue_style( 'owl-css', plugin_dir_url( __FILE__ ) . '/assets/css/owl.carousel.min.css','', '2.3.4' );
    wp_enqueue_script( 'owl-js', plugin_dir_url( __FILE__ ) . '/assets/js/owl.carousel.min.js', array('jquery'), '1.0', true );
}

add_action('wp_enqueue_scripts', 'losw_enqueue_scripts');

	// Load WooCommerce subcategories

function losw_loadSubCat( $args = array() ) {
   if( !is_shop() ){
    $parentid = get_queried_object_id();       
	$args = array(
    'parent' => $parentid
);
 
$terms = get_terms( 'product_cat', $args );
 
if ( $terms ) { ?>

    <style>
    <?php
    $top_arrows = get_option('top_arrows');
    if( @$top_arrows == 1 ) {
    	echo '
		.owl-prev, 
		.owl-next {
		    position: absolute;
		    top: 0 !important;
		}
		.owl-prev {
		    left: -25px;
		}

		.owl-next {
		    right: -25px;
		}';
    } else {
    	echo '';
    } ?>
    	.owl-prev, 
		.owl-next {
		    font-size: 30px !important;
		    background: transparent !important;
		    width: 20px;
		}
		.owl-theme .owl-nav [class*=owl-]:hover {
	    color: #b0aaaa;
		}
		.owl-next:focus, .owl-next span:focus, .owl-prev:focus, .owl-prev span:focus {
		    outline-width: 0 !important;
		    text-decoration: none;
		}
		.product-subcats .owl-item {
		padding: 0 <?php if( get_option( 'carousel_padding' ) ){ echo get_option( 'carousel_padding' ); } else {echo '5';} ?>px;
		}
		.product-subcats h3 {
		    margin: 10px 0;
		    text-align: center;
		    font-size: <?php if( get_option( 'font_size' ) ){ echo get_option( 'font_size' ); } else {echo '14';} ?>px;
		}
		.category {
		    box-shadow: 1px 1px 5px 0 rgba(0, 0, 0, 0.25);
		    padding-bottom: 1px;
		}
		.product-subcats a {
		    text-decoration: none;
		}
		.product-subcats .owl-stage-outer {
		    padding: 5px 0;
		}
	</style>
    <div class="product-subcats owl-carousel owl-theme">
     <?php
        foreach ( $terms as $term ) { ?>
            <div class="category item">
            	<a href="<?php esc_url( get_term_link( $term ) ) ?>" class="<?php echo $term->slug ?>">
                <?php woocommerce_subcategory_thumbnail( $term ); ?>
                <h3>
                        <?php echo $term->name; ?>
                </h3>
              </a>                                              
            </div>
    	<?php } ?>
    </div>
    <?php
    $arrows = get_option('ch_arrows');
    if( @$arrows == 1 ) {
    	$arr = 'true';
    } else {
    	$arr = 'false';
    }
    $dots = get_option('ch_dots');
    if( @$dots == 1 ) {
    	$dot = 'true';
    } else {
    	$dot = 'false';
    }
    ?>
    <script>
	jQuery(document).ready(function(){
	  jQuery(".product-subcats").owlCarousel({
	    loop:false,
	    nav:<?php echo $arr ?>,
	    dots:<?php echo $dot ?>,
	    responsive:{
	    0:{
	    	items:'<?php if(get_option( 'mobile_noi' )){ echo get_option( 'mobile_noi' ); } else {echo '2';} ?>'
	    },
	    600:{
	        items:'<?php if(get_option( 'tablet_noi' )){ echo get_option( 'tablet_noi' ); } else {echo '3';} ?>'
	    },
	    1000:{
	        items:'<?php if(get_option( 'desktop_noi' )){ echo get_option( 'desktop_noi' ); } else {echo '4';} ?>'
	    }
	    }
	  });
	});
	</script>
 <?php
		}
	}
}

add_action( 'woocommerce_before_shop_loop', 'losw_loadSubCat', 1 );