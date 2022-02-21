<?php
/**
 * This template controls the contact page.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package hollowinside
 */

get_header();
?>
	<main id="primary" class="site-main my-auto">
		<div class="container py-5">
			<div class="row align-items-center">
				<div class="d-none d-md-flex col-md-6 col-lg-4 offset-lg-2 align-items-center justify-content-center py-5">
					<img class="h-500-px" src="http://hollowinside.local/wp-content/uploads/2022/06/robot-white.png" alt="Hollow Inside Robot" />
				</div>
				<div class="col-md-6 col-lg-4">
					<h1>Contact</h1>
					<div class="custom-ninja-form">
						<?php echo do_shortcode("[ninja_form id=1]"); ?>
					</div>
				</div>
			</div>
		</div>
	</main>
<?php
get_footer();
