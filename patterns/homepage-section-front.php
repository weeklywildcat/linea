<?php
/**
 * Title: Section front module
 * Slug: linea/homepage-section-front
 * Categories: linea-homepage, linea-sections
 * Description: A native section-front layout with a feature story and compact latest-story rail.
 */
?>
<!-- wp:group {"align":"wide","className":"linea-section-front","style":{"spacing":{"margin":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group alignwide linea-section-front" style="margin-top:var(--wp--preset--spacing--70);margin-bottom:var(--wp--preset--spacing--70)">
	<!-- wp:group {"layout":{"type":"constrained"}} -->
	<div class="wp-block-group">
		<!-- wp:heading {"className":"linea-section-heading","level":2} -->
		<h2 class="wp-block-heading linea-section-heading">Section Spotlight</h2>
		<!-- /wp:heading -->

		<!-- wp:query {"query":{"perPage":1,"pages":0,"offset":2,"postType":"post","order":"desc","orderBy":"date","inherit":false}} -->
		<div class="wp-block-query">
			<!-- wp:post-template -->
				<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"16/9"} /-->
				<!-- wp:post-terms {"term":"category"} /-->
				<!-- wp:post-title {"isLink":true,"level":3,"fontSize":"x-large"} /-->
				<!-- wp:post-excerpt {"moreText":"Read story","excerptLength":28} /-->
			<!-- /wp:post-template -->

			<!-- wp:query-no-results -->
				<!-- wp:paragraph {"fontSize":"small"} -->
				<p class="has-small-font-size">A spotlight story will appear here after more posts are published.</p>
				<!-- /wp:paragraph -->
			<!-- /wp:query-no-results -->
		</div>
		<!-- /wp:query -->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"layout":{"type":"constrained"}} -->
	<div class="wp-block-group">
		<!-- wp:heading {"className":"linea-section-heading","level":2} -->
		<h2 class="wp-block-heading linea-section-heading">More Stories</h2>
		<!-- /wp:heading -->

		<!-- wp:query {"query":{"perPage":4,"pages":0,"offset":3,"postType":"post","order":"desc","orderBy":"date","inherit":false},"className":"linea-tight-query"} -->
		<div class="wp-block-query linea-tight-query">
			<!-- wp:post-template -->
				<!-- wp:post-title {"isLink":true,"level":3,"fontSize":"medium"} /-->
				<!-- wp:post-date {"fontSize":"x-small"} /-->
			<!-- /wp:post-template -->

			<!-- wp:query-no-results -->
				<!-- wp:paragraph {"fontSize":"small"} -->
				<p class="has-small-font-size">Related stories will appear here as the archive grows.</p>
				<!-- /wp:paragraph -->
			<!-- /wp:query-no-results -->
		</div>
		<!-- /wp:query -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
