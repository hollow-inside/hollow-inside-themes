<?php
/**
 * This template controls the about page.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package hollowinside
 */

get_header();
?>

	<main id="primary" class="site-main">
		<section class="bg-cover bg-grunge-black bg-gamma py-4 py-md-5">
			<div class="container-xxl">
				<h2 class="text-center">Listen Now</h2>
				<ul class="list-inline d-flex justify-content-center">
					<li class="list-inline-item">
						<a href="#" class="link-white" target="_blank" rel="noreferrer"><i class="fa-brands fa-spotify fa-2x"></i></a>
						<a href="#" class="link-white mx-4" target="_blank" rel="noreferrer"><i class="fa-brands fa-apple fa-2x"></i></a>
						<a href="#" class="link-white" target="_blank" rel="noreferrer"><i class="fa-brands fa-youtube fa-2x"></i></a>
					</li>
				</ul>
			</div>
		</section>	
		<section class="py-4 py-md-5">
			<div class="container-xxl">
				<h2 class="text-center">Official Hollow Inside Merch</h2>
			</div>
		</section>
		<section class="py-4 py-md-5">
			<div class="container-xxl">
				<h2 class="text-center">Get Updates</h2>
			</div>
		</section>
		<?php get_sidebar(); ?>
	</main><!-- #main -->

<?php
get_footer();
