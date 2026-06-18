<?php
/**
 * Title: Edition information strip
 * Slug: linea/homepage-edition-strip
 * Categories: linea-homepage, linea-modules
 * Description: A compact editable strip for issue metadata, staff notes, and quick links.
 */
?>
<!-- wp:group {"align":"wide","className":"linea-edition-strip","style":{"spacing":{"padding":{"top":"var:preset|spacing|30","right":"var:preset|spacing|40","bottom":"var:preset|spacing|30","left":"var:preset|spacing|40"},"margin":{"bottom":"var:preset|spacing|50"}}},"backgroundColor":"newsprint","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
<div class="wp-block-group alignwide linea-edition-strip has-newsprint-background-color has-background" style="margin-bottom:var(--wp--preset--spacing--50);padding-top:var(--wp--preset--spacing--30);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--40)">
	<!-- wp:paragraph {"className":"linea-edition-label","fontSize":"x-small"} -->
	<p class="linea-edition-label has-x-small-font-size">Today’s Edition</p>
	<!-- /wp:paragraph -->

	<!-- wp:paragraph {"fontSize":"small"} -->
	<p class="has-small-font-size">Campus news, sports, arts, opinion, and student life from the newsroom.</p>
	<!-- /wp:paragraph -->

	<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"right"}} -->
	<div class="wp-block-buttons">
		<!-- wp:button {"url":"#latest-stories","className":"is-style-outline","fontSize":"x-small"} -->
		<div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-x-small-font-size wp-element-button" href="#latest-stories">Latest Stories</a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->
</div>
<!-- /wp:group -->
