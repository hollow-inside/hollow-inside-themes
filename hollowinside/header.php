<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package hollowinside
 */

?>
<!doctype html>
<html <?php language_attributes(); ?> data-sh-theme="head-wound" data-sh-theme-mode="dark">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'hollowinside' ); ?></a>
	<header class="bg-main <?php if (!is_home()) { ?>sticky-top<?php } ?>">
		<?php
		if (is_home()) { ?>
			<div class="container-xxl p-0">
				<img class="w-100-percent h-100-percent" src="http://hollowinside.local/wp-content/uploads/2022/06/band-couch-header-xxl.png" alt="<?php bloginfo( 'name' ); ?>" />
			</div>
		<?php } ?>
        <nav class="navbar navbar-expand-md w-100-percent <?php if (is_home()) { ?>sticky-top-nav<?php } ?>">
            <div class="container-xxl">
				<div class="row gx-0 d-flex align-items-center w-100-percent">
					<a class="navbar-brand col-4 col-md-3 me-0" href="<?php echo esc_url( home_url( '/' ) ); ?>">
						<img class="h-35-px" src="http://hollowinside.local/wp-content/uploads/2022/02/logo-dark.svg" alt="<?php bloginfo( 'name' ); ?>" />
					</a>
					<div class="d-flex order-md-2 col-8 col-md-3 justify-content-end">
						<div class="nav-link py-0 pe-0">
							<ul class="nav">
								<li class="nav-item">
									<a class="nav-link position-relative" href="<?php echo wc_get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>">
										<i class="fa-solid fa-cart-shopping"></i>
										<?php
										$items_count = WC()->cart->get_cart_contents_count();
										if ( $items_count > 0 ) {
											$items_text = WC()->cart->get_cart_contents_count();
										}
										else {
											$items_text = '';
										}
										?>
										<span class="cart-items"><?php echo $items_text; ?></span>
									</a>
								</li>
								<li class="nav-item"><a class="nav-link" href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php _e('My Account',''); ?>"><i class="fa-solid fa-user"></i></a></li>
							</ul>
						</div>
						<button class="btn btn-transparent d-md-none py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavigationToggle" aria-controls="mainNavigationToggle" aria-expanded="false" aria-label="Toggle navigation">
							<i class="fa-solid fa-bars text-opposite"></i>
						</button>
					</div>
					<?php
					wp_nav_menu(
						array(
							'theme_location' 	=> 'primary',
							'container_id'		=> 'mainNavigationToggle',
							'container_class' 	=> 'collapse navbar-collapse col-md-6',
							'menu_id'        	=> '',
							'menu_class'     	=> 'navbar-nav ms-auto mx-md-auto',
							'list_item_class'	=> '',
							'link_class'   		=> 'nav-link',
							'fallback_cb'	    => false
						)
					);
					?>
				</div>
                
            </div>
        </nav>
    </header>
