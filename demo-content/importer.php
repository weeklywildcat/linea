<?php
/**
 * Programmatic demo content importer for Linea.
 *
 * This file is intentionally standalone so WordPress Playground, WP-CLI, and
 * local testers can seed a working newspaper demo without external services.
 *
 * @package Linea
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Import Linea demo content.
 *
 * @return array<string, int>
 */
function linea_import_demo_content() {
	linea_demo_prepare_site_options();

	$categories  = linea_demo_create_categories();
	$attachments = linea_demo_create_placeholder_attachments();
	$post_ids    = linea_demo_create_posts( $categories, $attachments );

	linea_demo_create_comments( $post_ids );
	linea_demo_create_navigation();

	return array(
		'posts'       => count( $post_ids ),
		'categories'  => count( $categories ),
		'attachments' => count( $attachments ),
	);
}

/**
 * Set site options that make the theme demo read like a school newspaper.
 */
function linea_demo_prepare_site_options() {
	update_option( 'blogname', 'The Campus Chronicle' );
	update_option( 'blogdescription', 'Independent. Student-run. Always informed.' );
	update_option( 'show_on_front', 'posts' );
	update_option( 'posts_per_page', 10 );

	$default_post = get_page_by_path( 'hello-world', OBJECT, 'post' );
	if ( $default_post instanceof WP_Post && 'publish' === $default_post->post_status ) {
		wp_update_post(
			array(
				'ID'          => $default_post->ID,
				'post_status' => 'draft',
			)
		);
	}
}

/**
 * Create newspaper section categories.
 *
 * @return array<string, int>
 */
function linea_demo_create_categories() {
	$terms = array(
		'news'         => 'News',
		'features'     => 'Features',
		'opinion'      => 'Opinion',
		'sports'       => 'Sports',
		'arts'         => 'Arts',
		'student-life' => 'Student Life',
	);

	$ids = array();

	foreach ( $terms as $slug => $name ) {
		$term = get_term_by( 'slug', $slug, 'category' );
		if ( ! $term ) {
			$result = wp_insert_term(
				$name,
				'category',
				array(
					'slug'        => $slug,
					'description' => sprintf(
						/* translators: %s: category name. */
						__( 'Demo stories for the %s desk.', 'linea' ),
						$name
					),
				)
			);

			if ( is_wp_error( $result ) ) {
				continue;
			}

			$ids[ $slug ] = (int) $result['term_id'];
			continue;
		}

		$ids[ $slug ] = (int) $term->term_id;
	}

	return $ids;
}

/**
 * Create local attachment records for the bundled placeholder SVGs.
 *
 * @return array<string, int>
 */
function linea_demo_create_placeholder_attachments() {
	$files = array(
		'red'    => 'campus-red.svg',
		'blue'   => 'campus-blue.svg',
		'green'  => 'campus-green.svg',
		'purple' => 'campus-purple.svg',
		'gold'   => 'campus-gold.svg',
	);

	$upload_dir  = wp_upload_dir();
	$target_dir  = trailingslashit( $upload_dir['basedir'] ) . 'linea-demo';
	$target_url  = trailingslashit( $upload_dir['baseurl'] ) . 'linea-demo';
	$placeholder = array();

	if ( ! wp_mkdir_p( $target_dir ) ) {
		return $placeholder;
	}

	foreach ( $files as $key => $file_name ) {
		$title       = 'Linea demo placeholder ' . $key;
		$existing_id = linea_demo_find_post_by_meta( 'attachment', '_linea_demo_placeholder', $key );

		if ( $existing_id ) {
			$placeholder[ $key ] = $existing_id;
			continue;
		}

		$source = get_template_directory() . '/assets/placeholders/' . $file_name;
		$target = trailingslashit( $target_dir ) . $file_name;

		if ( ! file_exists( $source ) ) {
			continue;
		}

		copy( $source, $target );

		$attachment_id = wp_insert_attachment(
			array(
				'guid'           => trailingslashit( $target_url ) . $file_name,
				'post_mime_type' => 'image/svg+xml',
				'post_title'     => $title,
				'post_content'   => '',
				'post_excerpt'   => __( 'Plain color demo placeholder.', 'linea' ),
				'post_status'    => 'inherit',
			),
			$target
		);

		if ( is_wp_error( $attachment_id ) || ! $attachment_id ) {
			continue;
		}

		update_post_meta( $attachment_id, '_linea_demo_placeholder', $key );
		update_post_meta( $attachment_id, '_wp_attachment_image_alt', __( 'Plain color demo placeholder', 'linea' ) );
		$placeholder[ $key ] = (int) $attachment_id;
	}

	return $placeholder;
}

/**
 * Create demo posts.
 *
 * @param array<string, int> $categories Category IDs keyed by slug.
 * @param array<string, int> $attachments Attachment IDs keyed by color name.
 * @return array<int>
 */
function linea_demo_create_posts( $categories, $attachments ) {
	$stories = linea_demo_story_data();
	$post_ids = array();

	foreach ( $stories as $index => $story ) {
		$existing_id = linea_demo_find_post_by_meta( 'post', '_linea_demo_story', $story['slug'] );

		if ( $existing_id ) {
			$post_ids[] = $existing_id;
			continue;
		}

		$post_id = wp_insert_post(
			array(
				'post_title'    => $story['title'],
				'post_name'     => $story['slug'],
				'post_excerpt'  => $story['excerpt'],
				'post_content'  => linea_demo_lorem_content(),
				'post_status'   => 'publish',
				'post_author'   => linea_demo_author_id(),
				'post_date'     => gmdate( 'Y-m-d H:i:s', strtotime( '2025-05-22 12:00:00 UTC' ) - ( $index * DAY_IN_SECONDS ) ),
				'post_date_gmt' => gmdate( 'Y-m-d H:i:s', strtotime( '2025-05-22 12:00:00 UTC' ) - ( $index * DAY_IN_SECONDS ) ),
				'meta_input'    => array(
					'_linea_demo_story' => $story['slug'],
				),
			)
		);

		if ( is_wp_error( $post_id ) || ! $post_id ) {
			continue;
		}

		if ( isset( $categories[ $story['category'] ] ) ) {
			wp_set_post_categories( $post_id, array( $categories[ $story['category'] ] ) );
		}

		if ( isset( $attachments[ $story['media'] ] ) ) {
			set_post_thumbnail( $post_id, $attachments[ $story['media'] ] );
		}

		$post_ids[] = (int) $post_id;
	}

	return $post_ids;
}

/**
 * Demo story data.
 *
 * @return array<int, array<string, string>>
 */
function linea_demo_story_data() {
	return array(
		array(
			'title'    => 'Lorem ipsum campus initiative opens the semester',
			'slug'     => 'lorem-ipsum-campus-initiative-opens-the-semester',
			'category' => 'news',
			'media'    => 'red',
			'excerpt'  => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore.',
		),
		array(
			'title'    => 'Dolor sit amet funding plan reaches student council',
			'slug'     => 'dolor-sit-amet-funding-plan-reaches-student-council',
			'category' => 'news',
			'media'    => 'blue',
			'excerpt'  => 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo.',
		),
		array(
			'title'    => 'Consectetur arts showcase fills the auditorium',
			'slug'     => 'consectetur-arts-showcase-fills-the-auditorium',
			'category' => 'arts',
			'media'    => 'purple',
			'excerpt'  => 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
		),
		array(
			'title'    => 'Adipiscing elit runners finish strong at invitational',
			'slug'     => 'adipiscing-elit-runners-finish-strong-at-invitational',
			'category' => 'sports',
			'media'    => 'green',
			'excerpt'  => 'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim.',
		),
		array(
			'title'    => 'Sed do eiusmod clubs announce spring projects',
			'slug'     => 'sed-do-eiusmod-clubs-announce-spring-projects',
			'category' => 'student-life',
			'media'    => 'gold',
			'excerpt'  => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.',
		),
		array(
			'title'    => 'Tempor incididunt opinion: rethink the study week',
			'slug'     => 'tempor-incididunt-opinion-rethink-the-study-week',
			'category' => 'opinion',
			'media'    => 'blue',
			'excerpt'  => 'Totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae.',
		),
		array(
			'title'    => 'Labore et dolore schedule changes begin Monday',
			'slug'     => 'labore-et-dolore-schedule-changes-begin-monday',
			'category' => 'news',
			'media'    => 'green',
			'excerpt'  => 'Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur.',
		),
		array(
			'title'    => 'Magna aliqua photo desk plans new gallery',
			'slug'     => 'magna-aliqua-photo-desk-plans-new-gallery',
			'category' => 'features',
			'media'    => 'purple',
			'excerpt'  => 'Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit.',
		),
		array(
			'title'    => 'Ut enim athletes prepare for regional finals',
			'slug'     => 'ut-enim-athletes-prepare-for-regional-finals',
			'category' => 'sports',
			'media'    => 'red',
			'excerpt'  => 'Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae.',
		),
		array(
			'title'    => 'Minim veniam profile: a day in the newsroom',
			'slug'     => 'minim-veniam-profile-a-day-in-the-newsroom',
			'category' => 'features',
			'media'    => 'gold',
			'excerpt'  => 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum.',
		),
		array(
			'title'    => 'Quis nostrud editorial board sets coverage goals',
			'slug'     => 'quis-nostrud-editorial-board-sets-coverage-goals',
			'category' => 'opinion',
			'media'    => 'red',
			'excerpt'  => 'Et harum quidem rerum facilis est et expedita distinctio nam libero tempore cum soluta nobis.',
		),
		array(
			'title'    => 'Ullamco laboris wellness program expands',
			'slug'     => 'ullamco-laboris-wellness-program-expands',
			'category' => 'student-life',
			'media'    => 'blue',
			'excerpt'  => 'Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet.',
		),
	);
}

/**
 * Shared lorem ipsum body copy for demo posts.
 *
 * @return string
 */
function linea_demo_lorem_content() {
	return '<!-- wp:paragraph --><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p><!-- /wp:paragraph -->' .
		'<!-- wp:paragraph --><p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Integer feugiat scelerisque varius morbi enim nunc faucibus a pellentesque.</p><!-- /wp:paragraph -->' .
		'<!-- wp:quote --><blockquote class="wp-block-quote"><!-- wp:paragraph --><p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p><!-- /wp:paragraph --></blockquote><!-- /wp:quote -->' .
		'<!-- wp:paragraph --><p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</p><!-- /wp:paragraph -->';
}

/**
 * Add a few comments so ranked/comment templates have real data.
 *
 * @param array<int> $post_ids Post IDs.
 */
function linea_demo_create_comments( $post_ids ) {
	foreach ( array_slice( $post_ids, 0, 5 ) as $index => $post_id ) {
		if ( get_comments( array( 'post_id' => $post_id, 'meta_key' => '_linea_demo_comment', 'number' => 1 ) ) ) {
			continue;
		}

		wp_insert_comment(
			array(
				'comment_post_ID'      => $post_id,
				'comment_author'       => 'Linea Reader',
				'comment_author_email' => 'reader@example.com',
				'comment_content'      => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
				'comment_approved'     => 1,
				'comment_date'         => gmdate( 'Y-m-d H:i:s', time() - ( $index * HOUR_IN_SECONDS ) ),
				'comment_meta'         => array(
					'_linea_demo_comment' => 1,
				),
			)
		);
	}
}

/**
 * Create a simple navigation menu for classic menu fallback support.
 */
function linea_demo_create_navigation() {
	$menu_name = 'Linea Demo Sections';
	$menu      = wp_get_nav_menu_object( $menu_name );

	if ( ! $menu ) {
		$menu_id = wp_create_nav_menu( $menu_name );
	} else {
		$menu_id = (int) $menu->term_id;
	}

	if ( is_wp_error( $menu_id ) || ! $menu_id ) {
		return;
	}

	$menu_items = wp_get_nav_menu_items( $menu_id );
	if ( ! empty( $menu_items ) ) {
		return;
	}

	foreach ( array( 'news', 'features', 'opinion', 'sports', 'arts' ) as $slug ) {
		$term = get_term_by( 'slug', $slug, 'category' );
		if ( ! $term ) {
			continue;
		}

		wp_update_nav_menu_item(
			$menu_id,
			0,
			array(
				'menu-item-title'     => $term->name,
				'menu-item-object-id' => $term->term_id,
				'menu-item-object'    => 'category',
				'menu-item-type'      => 'taxonomy',
				'menu-item-status'    => 'publish',
			)
		);
	}
}

/**
 * Return a stable author ID.
 *
 * @return int
 */
function linea_demo_author_id() {
	$users = get_users(
		array(
			'role__in' => array( 'administrator', 'editor', 'author' ),
			'number'   => 1,
			'fields'   => 'ID',
		)
	);

	return $users ? (int) $users[0] : 1;
}

/**
 * Find generated content by metadata.
 *
 * @param string $post_type Post type.
 * @param string $meta_key Meta key.
 * @param string $meta_value Meta value.
 * @return int
 */
function linea_demo_find_post_by_meta( $post_type, $meta_key, $meta_value ) {
	$query = new WP_Query(
		array(
			'post_type'              => $post_type,
			'post_status'            => 'any',
			'posts_per_page'         => 1,
			'fields'                 => 'ids',
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
			'meta_key'               => $meta_key,
			'meta_value'             => $meta_value,
		)
	);

	return $query->posts ? (int) $query->posts[0] : 0;
}
