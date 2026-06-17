<?php
/**
 * Title: Breaking news banner
 * Slug: weekly-wildcat/breaking-news-banner
 * Categories: weekly-wildcat-homepage, weekly-wildcat-modules
 * Description: A prominent editable alert banner for urgent newsroom updates.
 */
?>
<!-- wp:group {"align":"wide","className":"ww-breaking","style":{"spacing":{"padding":{"top":"var:preset|spacing|40","right":"var:preset|spacing|50","bottom":"var:preset|spacing|40","left":"var:preset|spacing|50"},"margin":{"bottom":"var:preset|spacing|50"}},"border":{"color":"var:preset|color|line","width":"1px"}},"backgroundColor":"newsprint","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"center"}} -->
<div class="wp-block-group alignwide ww-breaking has-border-color has-line-border-color has-newsprint-background-color has-background" style="border-width:1px;margin-bottom:var(--wp--preset--spacing--50);padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--50)">
	<!-- wp:group {"layout":{"type":"flex","flexWrap":"wrap"}} -->
	<div class="wp-block-group">
		<!-- wp:paragraph {"className":"ww-alert-label","textColor":"accent"} -->
		<p class="ww-alert-label has-accent-color has-text-color">Breaking</p>
		<!-- /wp:paragraph -->

		<!-- wp:paragraph {"fontSize":"medium"} -->
		<p class="has-medium-font-size"><strong>Update this banner from the Site Editor when there is urgent school news.</strong></p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->

	<!-- wp:buttons -->
	<div class="wp-block-buttons">
		<!-- wp:button {"url":"/","className":"is-style-outline"} -->
		<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="/">Read latest</a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->
</div>
<!-- /wp:group -->
