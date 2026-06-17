<?php
/**
 * Title: Article footer modules
 * Slug: weekly-wildcat/after-article
 * Categories: weekly-wildcat-articles
 * Description: Author card and more-stories module for the end of an article.
 * Inserter: no
 * Template Types: single
 */
?>
<!-- wp:group {"style":{"spacing":{"margin":{"top":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="margin-top:var(--wp--preset--spacing--70)">
	<!-- wp:group {"className":"ww-author-card","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","right":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|50"}}},"backgroundColor":"newsprint","layout":{"type":"constrained"}} -->
	<div class="wp-block-group ww-author-card has-newsprint-background-color has-background" style="padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--50)">
		<!-- wp:post-author {"showAvatar":true,"showBio":true,"byline":"Written by","avatarSize":72} /-->
	</div>
	<!-- /wp:group -->

	<!-- wp:spacer {"height":"var:preset|spacing|70"} -->
	<div style="height:var(--wp--preset--spacing--70)" aria-hidden="true" class="wp-block-spacer"></div>
	<!-- /wp:spacer -->

	<!-- wp:heading {"className":"ww-section-heading","level":2} -->
	<h2 class="wp-block-heading ww-section-heading">More Stories</h2>
	<!-- /wp:heading -->

	<!-- wp:query {"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","inherit":false},"align":"wide","className":"ww-archive-query"} -->
	<div class="wp-block-query alignwide ww-archive-query">
		<!-- wp:post-template {"layout":{"type":"grid","columnCount":3}} -->
			<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"16/9"} /-->
			<!-- wp:post-title {"isLink":true,"level":3,"fontSize":"medium"} /-->
			<!-- wp:post-date {"fontSize":"x-small"} /-->
		<!-- /wp:post-template -->
	</div>
	<!-- /wp:query -->
</div>
<!-- /wp:group -->
