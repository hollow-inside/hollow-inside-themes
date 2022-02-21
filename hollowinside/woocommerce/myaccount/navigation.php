<?php
/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_account_navigation' );
?>
<div class="row">
	<div class="col-md-3">
		<nav class="woocommerce-MyAccount-navigation">
			<ul class="list-unstyled">
				<?php
					$icons = [
						'dashboard' => '<i class="fa-solid fa-gauge-high"></i>',
						'orders' => '<i class="fa-solid fa-cart-shopping"></i>',
						'subscriptions' => '<i class="fa-solid fa-rotate"></i>',
						'edit-account' => '<i class="fa-solid fa-user-pen"></i>',
						'customer-logout' => '<i class="fa-solid fa-arrow-right-from-bracket"></i>',
						'downloads' => '<i class="fa-solid fa-download"></i>',
						'edit-address' => '<i class="fa-solid fa-location-dot"></i>',
						'payment-methods' => '<i class="fa-solid fa-credit-card"></i>',
					];
				?>
				<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
					<li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?> py-3 border-bottom-gray">
						<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>" class="d-flex align-items-center justify-content-between link-white">
							<?php echo esc_html( $label ); ?>
							<?php echo $icons[$endpoint] ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</nav>
	</div>
<?php do_action( 'woocommerce_after_account_navigation' ); ?>
