<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package hollowinside
 */

?>

	<footer class="p-3 text-center">
		<div class="d-flex align-items-center justify-content-center small">
		<?php
		echo "©";
		$year = date("Y");
		echo $year; 
		?>
		Hollow Inside

		<?php
		wp_nav_menu(
			array(
				'theme_location' 	=> 'footer',
				'container'		    => false,
				'menu_id'        	=> '',
				'menu_class'     	=> 'nav justify-content-center',
				'list_item_class'	=> 'nav-item',
				'link_class'   		=> 'nav-link',
				'fallback_cb'	    => false
			)
		);
		?>
		</div>
	</footer>

<?php wp_footer(); ?>

</body>
</html>
