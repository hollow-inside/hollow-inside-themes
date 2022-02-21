<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package hollowinside
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)
 * @link https://github.com/woocommerce/woocommerce/wiki/Declaring-WooCommerce-support-in-themes
 *
 * @return void
 */
function hollowinside_woocommerce_setup() {
	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 550,
			'single_image_width'    => 700,
			'product_grid'          => array(
				'default_rows'    => 3,
				'min_rows'        => 1,
				'default_columns' => 4,
				'min_columns'     => 1,
				'max_columns'     => 6
			),
		)
	);
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'hollowinside_woocommerce_setup' );

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */
function hollowinside_woocommerce_scripts() {
	wp_enqueue_style( 'hollowinside-woocommerce-style', get_template_directory_uri() . '/woocommerce.css', array(), _S_VERSION );

	$font_path   = WC()->plugin_url() . '/assets/fonts/';
	$inline_font = '@font-face {
			font-family: "star";
			src: url("' . $font_path . 'star.eot");
			src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
				url("' . $font_path . 'star.woff") format("woff"),
				url("' . $font_path . 'star.ttf") format("truetype"),
				url("' . $font_path . 'star.svg#star") format("svg");
			font-weight: normal;
			font-style: normal;
		}';

	wp_add_inline_style( 'hollowinside-woocommerce-style', $inline_font );
}
add_action( 'wp_enqueue_scripts', 'hollowinside_woocommerce_scripts' );

/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function hollowinside_woocommerce_active_body_class( $classes ) {
	$classes[] = 'woocommerce-active';

	return $classes;
}
add_filter( 'body_class', 'hollowinside_woocommerce_active_body_class' );

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function hollowinside_woocommerce_related_products_args( $args ) {
	$defaults = array(
		'posts_per_page' => 3,
		'columns'        => 3,
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'hollowinside_woocommerce_related_products_args' );

/**
 * Remove default WooCommerce wrapper.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

if ( ! function_exists( 'hollowinside_woocommerce_wrapper_before' ) ) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function hollowinside_woocommerce_wrapper_before() {
		?>
			<main id="primary" class="site-main"><div class="container-xl">
		<?php
	}
}
add_action( 'woocommerce_before_main_content', 'hollowinside_woocommerce_wrapper_before' );

if ( ! function_exists( 'hollowinside_woocommerce_wrapper_after' ) ) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
	 */
	function hollowinside_woocommerce_wrapper_after() {
		?>
			</div></main><!-- #main -->
		<?php
	}
}
add_action( 'woocommerce_after_main_content', 'hollowinside_woocommerce_wrapper_after' );

/**
 * Sample implementation of the WooCommerce Mini Cart.
 *
 * You can add the WooCommerce Mini Cart to header.php like so ...
 *
	<?php
		if ( function_exists( 'hollowinside_woocommerce_header_cart' ) ) {
			hollowinside_woocommerce_header_cart();
		}
	?>
 */

if ( ! function_exists( 'hollowinside_woocommerce_cart_link_fragment' ) ) {
	/**
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 */
	function hollowinside_woocommerce_cart_link_fragment( $fragments ) {
		ob_start();
		hollowinside_woocommerce_cart_link();
		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'hollowinside_woocommerce_cart_link_fragment' );

if ( ! function_exists( 'hollowinside_woocommerce_cart_link' ) ) {
	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @return void
	 */
	function hollowinside_woocommerce_cart_link() {
		?>
		<a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'hollowinside' ); ?>">
			<?php
			$item_count_text = sprintf(
				/* translators: number of items in the mini cart. */
				_n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'hollowinside' ),
				WC()->cart->get_cart_contents_count()
			);
			?>
			<span class="amount"><?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?></span> <span class="count"><?php echo esc_html( $item_count_text ); ?></span>
		</a>
		<?php
	}
}

if ( ! function_exists( 'hollowinside_woocommerce_header_cart' ) ) {
	/**
	 * Display Header Cart.
	 *
	 * @return void
	 */
	function hollowinside_woocommerce_header_cart() {
		if ( is_cart() ) {
			$class = 'current-menu-item';
		} else {
			$class = '';
		}
		?>
		<ul id="site-header-cart" class="site-header-cart">
			<li class="<?php echo esc_attr( $class ); ?>">
				<?php hollowinside_woocommerce_cart_link(); ?>
			</li>
			<li>
				<?php
				$instance = array(
					'title' => '',
				);

				the_widget( 'WC_Widget_Cart', $instance );
				?>
			</li>
		</ul>
		<?php
	}
}

// Adds classes to individual product
/*add_filter('post_class', function($classes, $class, $product_id) {
	if(is_product_category() || is_shop()) {
    	$classes = array_merge(['col-sm-6','col-lg-4', 'text-center'], $classes);
	}
    return $classes;
},10,3);*/

// Adds classes to product title
add_filter( 'woocommerce_product_loop_title_classes', 'custom_woocommerce_product_loop_title_classes' );
function custom_woocommerce_product_loop_title_classes( $class ) {
	return $class . ' h6 text-uppercase pt-3 mb-0'; // set your additional class(es) here.
}

// Removes "Add to Cart" button from product loops
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');

/**
 * Disable reviews.
 */
function iconic_disable_reviews() {
	remove_post_type_support( 'product', 'comments' );
}

add_action( 'init', 'iconic_disable_reviews' );

// Add classes to product variation select dropdown
add_filter( 'woocommerce_dropdown_variation_attribute_options_args', static function( $args ) {
    $args['class'] = 'form-select';
    return $args;
}, 2 );

// Moves product tabs on product page onto the right column instead of underneath
remove_action( 'woocommerce_after_single_product_summary','woocommerce_output_related_products', 20 );
add_action( 'woocommerce_after_single_product','woocommerce_output_related_products', 30 );

// Add class to input fields

add_filter('woocommerce_form_field_args','wc_form_field_args',10,3);
function wc_form_field_args( $args, $key, $value = null ) {

/*********************************************************************************************/
/** This is not meant to be here, but it serves as a reference

* $defaults = array(
    *'type'              => 'text',
    *'label'             => '',
    *'description'       => '',
    *'placeholder'       => '',
    *'maxlength'         => false,
    *'required'          => false,
    *'id'                => $key,
    *'class'             => array(),
    *'label_class'       => array(),
    *'input_class'       => array(),
    *'return'            => false,
    *'options'           => array(),
    *'custom_attributes' => array(),
    *'validate'          => array(),
    *'default'           => '',
*);
*/
// Start field type switch case

switch ( $args['type'] ) {

    case "select" :  /* Targets all select input type elements, except the country and state select input types */
        //$args['class'][] = 'form-group'; // Add a class to the field's html element wrapper - woocommerce input types (fields) are often wrapped within a <p></p> tag  
        $args['input_class'] = array('form-select'); // Add a class to the form input itself
        //$args['custom_attributes']['data-plugin'] = 'select2';
        $args['label_class'] = array('form-label');
        //$args['custom_attributes'] = array( 'data-plugin' => 'select2', 'data-allow-clear' => 'true', 'aria-hidden' => 'true',  ); // Add custom data attributes to the form input itself
    break;

    case "password" :
    case "text" :
    case "email" :
    case "tel" :
    case "number" :
        //$args['class'][] = 'form-group';
        //$args['input_class'][] = 'form-control input-lg'; // will return an array of classes, the same as bellow
        $args['input_class'] = array('form-control');
        $args['label_class'] = array('form-label');
    break;

    case 'textarea' :
        $args['input_class'] = array('form-control');
        $args['label_class'] = array('form-label');
    break;

    case 'checkbox' :  
    break;

    case 'radio' :
    break;

    default :
        $args['class'][] = 'form-group';
        $args['input_class'] = array('form-control');
        $args['label_class'] = array('form-label');
    break;
    }

    return $args;
}


function add_classes( $fields ) {

    $fields['billing']['billing_phone']['class'] = array('col-sm-6', 'form-row-first');
    
    return $fields;
} add_filter( 'woocommerce_checkout_fields', 'add_classes');


function add_classes_two( $address_fields ) {

    $address_fields['first_name']['class'] = array('col-sm-6', 'form-row-first');
    $address_fields['last_name']['class'] = array('col-sm-6', 'form-row-last');
    $address_fields['city']['class'] = array('col-sm-6', 'form-row-first');
    $address_fields['postcode']['class'] = array('col-sm-6', 'form-row-last');
    $address_fields['state']['class'] = array('col-sm-6', 'form-row-first');

    return $address_fields;
} add_filter( 'woocommerce_default_address_fields', 'add_classes_two');