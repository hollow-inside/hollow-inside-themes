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

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'hollowinside' ); ?></a>
	<header class="d-flex bg-main">
		<?php
		if ( is_front_page() && is_home() ) :
			?>
			<h1>Home Page</h1>
			<?php
		else :
			?>
			<h1>NOT Home Page</h1>
			<?php
		endif; ?>
        <nav class="navbar navbar-expand-md w-100-percent">
            <div class="container-fluid">
                <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <img class="dark-theme h-35-px" src="http://hollowinside.local/wp-content/uploads/2022/02/logo-dark.svg" alt="<?php bloginfo( 'name' ); ?>" />
                    <img class="light-theme h-35-px" src="http://hollowinside.local/wp-content/uploads/2022/02/logo-light.svg" alt="<?php bloginfo( 'name' ); ?>" />
                </a>
                <div class="d-flex order-md-2">
                    <button class="btn btn-transparent d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavigationToggle" aria-controls="mainNavigationToggle" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fa-solid fa-bars text-opposite"></i>
                    </button>
                </div>
				<?php
				if ( has_nav_menu( 'primary' )) {
					wp_nav_menu(
						array(
							'theme_location' 	=> 'primary',
							'container_id'		=> 'mainNavigationToggle',
							'container_class' 	=> 'collapse navbar-collapse',
							'menu_id'        	=> '',
							'menu_class'     	=> 'navbar-nav ms-auto',
							'list_item_class'	=> '',
							'link_class'   		=> 'nav-link'
						)
					);
				}
				?>
            </div>
        </nav>
    </header>
