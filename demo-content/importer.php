<?php
/**
 * Programmatic demo content importer for Linea.
 *
 * @package Linea
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function linea_import_demo_content() {
	linea_demo_prepare_site_options();
	$categories  = linea_demo_create_categories();
	$attachments = linea_demo_create_placeholder_attachments();
	$post_ids    = linea_demo_create_posts( $categories, $attachments );
	linea_demo_create_comments( $post_ids );
	linea_demo_create_navigation();
	return array( 'posts' => count( $post_ids ), 'categories' => count( $categories ), 'attachments' => count( $attachments ) );
}

function linea_demo_prepare_site_options() {
	update_option( 'blogname', 'The Campus Chronicle' );
	update_option( 'blogdescription', 'Independent. Student-run. Always informed.' );
	update_option( 'show_on_front', 'posts' );
	update_option( 'posts_per_page', 10 );
	$default_post = get_page_by_path( 'hello-world', OBJECT, 'post' );
	if ( $default_post instanceof WP_Post && 'publish' === $default_post->post_status ) {
		wp_update_post( array( 'ID' => $default_post->ID, 'post_status' => 'draft' ) );
	}
}

function linea_demo_create_categories() {
	$ids = array();
	foreach ( array( 'news' => 'News', 'features' => 'Features', 'opinion' => 'Opinion', 'sports' => 'Sports', 'arts' => 'Arts', 'student-life' => 'Student Life' ) as $slug => $name ) {
		$term = get_term_by( 'slug', $slug, 'category' );
		if ( $term ) {
			$ids[ $slug ] = (int) $term->term_id;
			continue;
		}
		$result = wp_insert_term( $name, 'category', array( 'slug' => $slug, 'description' => sprintf( __( 'Demo stories for the %s desk.', 'linea' ), $name ) ) );
		if ( ! is_wp_error( $result ) ) {
			$ids[ $slug ] = (int) $result['term_id'];
		}
	}
	return $ids;
}

function linea_demo_create_placeholder_attachments() {
	$upload_dir  = wp_upload_dir();
	$target_dir  = trailingslashit( $upload_dir['basedir'] ) . 'linea-demo';
	$target_url  = trailingslashit( $upload_dir['baseurl'] ) . 'linea-demo';
	$placeholder = array();
	if ( ! wp_mkdir_p( $target_dir ) ) {
		return $placeholder;
	}
	foreach ( array( 'red' => 'campus-red.svg', 'blue' => 'campus-blue.svg', 'green' => 'campus-green.svg', 'purple' => 'campus-purple.svg', 'gold' => 'campus-gold.svg' ) as $key => $file_name ) {
		$existing_id = linea_demo_find_post_by_meta( 'attachment', '_linea_demo_placeholder', $key );
		if ( $existing_id ) {
			$placeholder[ $key ] = $existing_id;
			continue;
		}
		$source = get_template_directory() . '/assets/placeholders/' . $file_name;
		$target = trailingslashit( $target_dir ) . $file_name;
		if ( ! file_exists( $source ) || ! copy( $source, $target ) ) {
			continue;
		}
		$attachment_id = wp_insert_attachment( array( 'guid' => trailingslashit( $target_url ) . $file_name, 'post_mime_type' => 'image/svg+xml', 'post_title' => 'Linea demo placeholder ' . $key, 'post_excerpt' => __( 'Plain color demo placeholder.', 'linea' ), 'post_status' => 'inherit' ), $target );
		if ( is_wp_error( $attachment_id ) || ! $attachment_id ) {
			continue;
		}
		update_post_meta( $attachment_id, '_linea_demo_placeholder', $key );
		update_post_meta( $attachment_id, '_wp_attachment_image_alt', __( 'Plain color demo placeholder', 'linea' ) );
		$placeholder[ $key ] = (int) $attachment_id;
	}
	return $placeholder;
}

function linea_demo_create_posts( $categories, $attachments ) {
	$post_ids = array();
	foreach ( linea_demo_story_data() as $index => $story ) {
		$existing_id = linea_demo_find_post_by_meta( 'post', '_linea_demo_story', $story['slug'] );
		if ( $existing_id ) {
			$post_ids[] = $existing_id;
			continue;
		}
		$post_id = wp_insert_post( array( 'post_title' => $story['title'], 'post_name' => $story['slug'], 'post_excerpt' => $story['excerpt'], 'post_content' => linea_demo_lorem_content( $story ), 'post_status' => 'publish', 'post_author' => linea_demo_author_id(), 'post_date' => gmdate( 'Y-m-d H:i:s', strtotime( '2026-05-22 12:00:00 UTC' ) - ( $index * DAY_IN_SECONDS ) ), 'post_date_gmt' => gmdate( 'Y-m-d H:i:s', strtotime( '2026-05-22 12:00:00 UTC' ) - ( $index * DAY_IN_SECONDS ) ), 'meta_input' => array( '_linea_demo_story' => $story['slug'] ) ) );
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

function linea_demo_create_comments( $post_ids ) {
	foreach ( $post_ids as $post_id ) {
		$existing = get_comments( array( 'post_id' => $post_id, 'meta_key' => '_linea_demo_comment', 'meta_value' => '1', 'number' => 1, 'status' => 'approve' ) );
		if ( ! empty( $existing ) ) {
			continue;
		}
		$comment_id = wp_insert_comment( array( 'comment_post_ID' => $post_id, 'comment_author' => 'Linea Demo Reader', 'comment_author_email' => 'reader@example.com', 'comment_content' => __( 'This sample comment helps demonstrate discussion styling.', 'linea' ), 'comment_approved' => 1 ) );
		if ( $comment_id ) {
			update_comment_meta( $comment_id, '_linea_demo_comment', '1' );
		}
	}
}

function linea_demo_create_navigation() {
	$existing_id = linea_demo_find_post_by_meta( 'wp_navigation', '_linea_demo_navigation', 'primary' );
	if ( $existing_id ) {
		return $existing_id;
	}
	$content = '';
	foreach ( array( 'Home' => '/', 'News' => '/category/news/', 'Features' => '/category/features/', 'Opinion' => '/category/opinion/', 'Sports' => '/category/sports/', 'Arts' => '/category/arts/', 'Student Life' => '/category/student-life/' ) as $label => $url ) {
		$content .= '<!-- wp:navigation-link ' . wp_json_encode( array( 'label' => $label, 'url' => $url ) ) . ' /-->' . PHP_EOL;
	}
	$navigation_id = wp_insert_post( array( 'post_type' => 'wp_navigation', 'post_status' => 'publish', 'post_title' => 'Linea Demo Sections', 'post_content' => $content, 'meta_input' => array( '_linea_demo_navigation' => 'primary' ) ) );
	return is_wp_error( $navigation_id ) ? 0 : (int) $navigation_id;
}

function linea_demo_find_post_by_meta( $post_type, $meta_key, $meta_value ) {
	$query = new WP_Query( array( 'post_type' => $post_type, 'post_status' => 'any', 'posts_per_page' => 1, 'fields' => 'ids', 'no_found_rows' => true, 'update_post_meta_cache' => false, 'update_post_term_cache' => false, 'meta_query' => array( array( 'key' => $meta_key, 'value' => $meta_value ) ) ) );
	return empty( $query->posts ) ? 0 : (int) $query->posts[0];
}

function linea_demo_author_id() {
	$current_user_id = get_current_user_id();
	if ( $current_user_id ) {
		return $current_user_id;
	}
	$users = get_users( array( 'role__in' => array( 'administrator', 'editor', 'author' ), 'number' => 1, 'fields' => 'ID' ) );
	return ! empty( $users ) ? (int) $users[0] : 1;
}

function linea_demo_story_data() {
	return array(
		array( 'title' => 'Student council reviews spring event calendar', 'slug' => 'student-council-reviews-spring-event-calendar', 'excerpt' => 'Leaders discussed assemblies, service projects, and new ways for students to submit event ideas.', 'category' => 'news', 'media' => 'red' ),
		array( 'title' => 'Robotics team prepares for regional showcase', 'slug' => 'robotics-team-prepares-for-regional-showcase', 'excerpt' => 'The team is testing drive systems, pit displays, and a student-built scouting dashboard.', 'category' => 'features', 'media' => 'blue' ),
		array( 'title' => 'Opinion: Cafeteria redesign should include student feedback', 'slug' => 'cafeteria-redesign-should-include-student-feedback', 'excerpt' => 'A student perspective on making shared spaces more flexible, welcoming, and useful.', 'category' => 'opinion', 'media' => 'gold' ),
		array( 'title' => 'Varsity soccer opens season with strong defensive effort', 'slug' => 'varsity-soccer-opens-season-with-strong-defensive-effort', 'excerpt' => 'The opening match highlighted communication, depth, and a late push from the midfield.', 'category' => 'sports', 'media' => 'green' ),
		array( 'title' => 'Art students build gallery around everyday objects', 'slug' => 'art-students-build-gallery-around-everyday-objects', 'excerpt' => 'A new hallway display turns familiar classroom items into studies of color, shadow, and form.', 'category' => 'arts', 'media' => 'purple' ),
		array( 'title' => 'Freshman mentors share advice for first semester', 'slug' => 'freshman-mentors-share-advice-for-first-semester', 'excerpt' => 'Upperclassmen offered practical tips on clubs, homework routines, and finding help early.', 'category' => 'student-life', 'media' => 'red' )
	);
}

function linea_demo_lorem_content( $story ) {
	$content  = '<!-- wp:paragraph --><p>' . esc_html( $story['excerpt'] ) . ' ' . esc_html__( 'This sample article gives editors realistic content to test Linea layouts, typography, and archives.', 'linea' ) . '</p><!-- /wp:paragraph -->' . PHP_EOL . PHP_EOL;
	$content .= '<!-- wp:paragraph --><p>' . esc_html__( 'Replace this demo copy with local student reporting from the WordPress editor.', 'linea' ) . '</p><!-- /wp:paragraph -->' . PHP_EOL;
	return $content;
}
