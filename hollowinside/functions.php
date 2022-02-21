<?php
/**
 * hollowinside functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package hollowinside
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '0.1.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function hollowinside_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on hollowinside, use a find and replace
		* to change 'hollowinside' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'hollowinside', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'primary' => __( 'Primary', 'hollowinside' ),
			'footer'  => __( 'Footer', 'hollowinside' )
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
}
add_action( 'after_setup_theme', 'hollowinside_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function hollowinside_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'hollowinside_content_width', 640 );
}
add_action( 'after_setup_theme', 'hollowinside_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function hollowinside_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'hollowinside' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'hollowinside' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'hollowinside_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function hollowinside_scripts() {
	wp_enqueue_style( 'hollowinside-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'hollowinside-style', 'rtl', 'replace' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Remove unwanted styles from head
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
	wp_dequeue_style( 'wc-block-style' ); // REMOVE WOOCOMMERCE BLOCK CSS
	wp_dequeue_style( 'global-styles' ); // REMOVE THEME.JSON

	// Add closing scripts
	wp_enqueue_script( 'main', get_bloginfo('template_url') . '/output/assets/js/main.js', '', '', true );
}
add_action( 'wp_enqueue_scripts', 'hollowinside_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}

/**
 * Add classes to wp_nav_menu list item
 */
function add_menu_list_item_class($classes, $item, $args) {
	if (property_exists($args, 'list_item_class')) {
		$classes[] = $args->list_item_class;
	}
	return $classes;
}
add_filter('nav_menu_css_class', 'add_menu_list_item_class', 1, 3);

/**
 * Add classes to wp_nav_menu list item link
 */
function add_menu_link_class( $atts, $item, $args ) {
	if (property_exists($args, 'link_class')) {
		$atts['class'] = $args->link_class;
	}
	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'add_menu_link_class', 1, 3 );

/**
 * Show cart contents / total Ajax
 */
add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment' );
function woocommerce_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;

	ob_start();

	$items_count = WC()->cart->get_cart_contents_count();
	$items_active = 'cart-active';

	if ($items_count > 0) {
		$items_text = WC()->cart->get_cart_contents_count();
		$items_active = 'cart-active';
	}
	else
	{
		$items_text = '';
		$items_active = '';
	}

	?>
	<span class="cart-items <?php echo $items_active ?>"><?php echo $items_text ?></span>
	<?php
	$fragments['span.cart-items'] = ob_get_clean();
	return $fragments;
}

/**
 * @snippet       Hide SKU, Cats, Tags @ Single Product Page - WooCommerce
 */
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

