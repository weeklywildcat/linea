<?php
/**
 * Title: Newspaper front page lead
 * Slug: linea/homepage-featured
 * Categories: linea-homepage
 * Description: A native Query Loop front page with a lead story and editor picks rail.
 */
?>
<!-- wp:group {"align":"wide","anchor":"latest-stories","className":"linea-home-layout","style":{"spacing":{"blockGap":"var:preset|spacing|50","margin":{"bottom":"var:preset|spacing|60"}}},"layout":{"type":"default"}} -->
<div id="latest-stories" class="wp-block-group alignwide linea-home-layout" style="margin-bottom:var(--wp--preset--spacing--60)">
	<!-- wp:query {"query":{"perPage":1,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","inherit":false},"className":"linea-lead-query"} -->
	<div class="wp-block-query linea-lead-query">
		<!-- wp:post-template -->
			<!-- wp:cover {"useFeaturedImage":true,"dimRatio":58,"overlayColor":"ink","isUserOverlayColor":true,"minHeight":520,"minHeightUnit":"px","className":"linea-lead-story","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","right":"var:preset|spacing|60","bottom":"var:preset|spacing|60","left":"var:preset|spacing|60"}}},"layout":{"type":"constrained","contentSize":"720px","wideSize":"720px","justifyContent":"left"}} -->
			<div class="wp-block-cover linea-lead-story" style="padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--60);min-height:520px"><span aria-hidden="true" class="wp-block-cover__background has-ink-background-color has-background-dim-60 has-background-dim"></span><div class="wp-block-cover__inner-container">
				<!-- wp:paragraph {"className":"linea-alert-label","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|30"}}},"textColor":"paper"} -->
				<p class="linea-alert-label has-paper-color has-text-color" style="margin-bottom:var(--wp--preset--spacing--30)">Top Story</p>
				<!-- /wp:paragraph -->

				<!-- wp:post-terms {"term":"category","style":{"elements":{"link":{"color":{"text":"var:preset|color|paper"}}},"spacing":{"margin":{"bottom":"var:preset|spacing|30"}}},"textColor":"paper"} /-->

				<!-- wp:post-title {"isLink":true,"level":2,"style":{"typography":{"fontSize":"clamp(2rem, 4.8vw, 4.1rem)","lineHeight":"1"},"spacing":{"margin":{"top":"0","bottom":"var:preset|spacing|40"}}},"textColor":"paper"} /-->

				<!-- wp:post-excerpt {"moreText":"","excerptLength":28,"style":{"typography":{"fontSize":"var:preset|font-size|medium","lineHeight":"1.35"},"spacing":{"margin":{"bottom":"var:preset|spacing|40"}}},"textColor":"paper"} /-->

				<!-- wp:group {"className":"linea-byline-row","layout":{"type":"flex","flexWrap":"wrap"}} -->
				<div class="wp-block-group linea-byline-row">
					<!-- wp:post-author-name {"isLink":true,"fontSize":"x-small"} /-->
					<!-- wp:paragraph {"fontSize":"x-small"} -->
					<p class="has-x-small-font-size">•</p>
					<!-- /wp:paragraph -->
					<!-- wp:post-date {"fontSize":"x-small"} /-->
				</div>
				<!-- /wp:group -->
			</div></div>
			<!-- /wp:cover -->
		<!-- /wp:post-template -->

		<!-- wp:query-no-results -->
			<!-- wp:group {"className":"linea-notice-box","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","right":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|50"}}},"backgroundColor":"newsprint","layout":{"type":"constrained"}} -->
			<div class="wp-block-group linea-notice-box has-newsprint-background-color has-background" style="padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--50)">
				<!-- wp:paragraph -->
				<p>No top story has been published yet.</p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		<!-- /wp:query-no-results -->
	</div>
	<!-- /wp:query -->

	<!-- wp:group {"className":"linea-home-rail","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained"}} -->
	<div class="wp-block-group linea-home-rail">
		<!-- wp:heading {"className":"linea-section-heading","level":2} -->
		<h2 class="wp-block-heading linea-section-heading">Editor’s Picks</h2>
		<!-- /wp:heading -->

		<!-- wp:query {"query":{"perPage":3,"pages":0,"offset":1,"postType":"post","order":"desc","orderBy":"date","inherit":false},"className":"linea-card-list"} -->
		<div class="wp-block-query linea-card-list">
			<!-- wp:post-template -->
				<!-- wp:columns {"verticalAlignment":"center","className":"linea-editor-pick","style":{"spacing":{"blockGap":"var:preset|spacing|40"}}} -->
				<div class="wp-block-columns are-vertically-aligned-center linea-editor-pick">
					<!-- wp:column {"verticalAlignment":"center","width":"42%"} -->
					<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:42%">
						<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"4/3","style":{"border":{"radius":"0px"}}} /-->
					</div>
					<!-- /wp:column -->

					<!-- wp:column {"verticalAlignment":"center","width":"58%"} -->
					<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:58%">
						<!-- wp:post-terms {"term":"category"} /-->
						<!-- wp:post-title {"isLink":true,"level":3,"fontSize":"medium"} /-->
						<!-- wp:post-date {"fontSize":"x-small"} /-->
					</div>
					<!-- /wp:column -->
				</div>
				<!-- /wp:columns -->
			<!-- /wp:post-template -->

			<!-- wp:query-no-results -->
				<!-- wp:paragraph {"fontSize":"small"} -->
				<p class="has-small-font-size">Add more posts to populate editor’s picks.</p>
				<!-- /wp:paragraph -->
			<!-- /wp:query-no-results -->
		</div>
		<!-- /wp:query -->

		<!-- wp:heading {"className":"linea-section-heading","level":2} -->
		<h2 class="wp-block-heading linea-section-heading">Most Discussed</h2>
		<!-- /wp:heading -->

		<!-- wp:query {"query":{"perPage":5,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"comment_count","inherit":false},"className":"linea-ranked-list"} -->
		<div class="wp-block-query linea-ranked-list">
			<!-- wp:post-template -->
				<!-- wp:post-title {"isLink":true,"level":3,"fontSize":"small"} /-->
			<!-- /wp:post-template -->

			<!-- wp:query-no-results -->
				<!-- wp:paragraph {"fontSize":"small"} -->
				<p class="has-small-font-size">Discussion links will appear after stories are published.</p>
				<!-- /wp:paragraph -->
			<!-- /wp:query-no-results -->
		</div>
		<!-- /wp:query -->

		<!-- wp:group {"className":"linea-newsletter-box","style":{"spacing":{"padding":{"top":"var:preset|spacing|40","right":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40"},"blockGap":"var:preset|spacing|30"}},"backgroundColor":"newsprint","layout":{"type":"constrained"}} -->
		<div class="wp-block-group linea-newsletter-box has-newsprint-background-color has-background" style="padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)">
			<!-- wp:heading {"className":"linea-newsletter-heading","level":2,"fontSize":"medium"} -->
			<h2 class="wp-block-heading linea-newsletter-heading has-medium-font-size">Newsroom Newsletter</h2>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"fontSize":"small"} -->
			<p class="has-small-font-size">Add announcements, staff notes, or a signup form here from the Site Editor.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
