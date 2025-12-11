<?php
/**
 * FWPP Pro - Helper Functions Class
 *
 * This class provides utility functions for the FWPP Pro WordPress plugin.
 *
 * @package FWPP_Pro
 * @subpackage Includes
 * @version 1.0.0
 * @author fmd112000-coder
 * @created 2025-12-11 11:55:47 UTC
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Class FWPP_Pro_Helpers
 *
 * Contains utility helper functions for the FWPP Pro plugin.
 *
 * @class FWPP_Pro_Helpers
 */
class FWPP_Pro_Helpers {

	/**
	 * Check if a user has a specific capability
	 *
	 * @param string $capability The capability to check
	 * @param int    $user_id    Optional. User ID. Default is current user.
	 *
	 * @return bool True if user has capability, false otherwise
	 */
	public static function user_can( $capability, $user_id = null ) {
		if ( null === $user_id ) {
			$user_id = get_current_user_id();
		}

		return user_can( $user_id, $capability );
	}

	/**
	 * Check if current user is logged in
	 *
	 * @return bool True if user is logged in, false otherwise
	 */
	public static function is_user_logged_in() {
		return is_user_logged_in();
	}

	/**
	 * Get current user ID
	 *
	 * @return int Current user ID, 0 if not logged in
	 */
	public static function get_current_user_id() {
		return get_current_user_id();
	}

	/**
	 * Get current user data
	 *
	 * @return WP_User|false User object or false if not logged in
	 */
	public static function get_current_user() {
		$user_id = get_current_user_id();
		if ( $user_id ) {
			return get_user_by( 'id', $user_id );
		}

		return false;
	}

	/**
	 * Sanitize input data
	 *
	 * @param mixed  $data Data to sanitize
	 * @param string $type Type of sanitization. Options: 'text', 'email', 'url', 'int', 'float', 'array'
	 *
	 * @return mixed Sanitized data
	 */
	public static function sanitize_input( $data, $type = 'text' ) {
		if ( is_null( $data ) ) {
			return null;
		}

		switch ( $type ) {
			case 'email':
				return sanitize_email( $data );

			case 'url':
				return esc_url_raw( $data );

			case 'int':
				return intval( $data );

			case 'float':
				return floatval( $data );

			case 'array':
				if ( is_array( $data ) ) {
					return array_map( function ( $item ) {
						return sanitize_text_field( $item );
					}, $data );
				}
				return array();

			case 'text':
			default:
				return sanitize_text_field( $data );
		}
	}

	/**
	 * Validate email address
	 *
	 * @param string $email Email address to validate
	 *
	 * @return bool True if valid email, false otherwise
	 */
	public static function is_valid_email( $email ) {
		return is_email( $email ) !== false;
	}

	/**
	 * Validate URL
	 *
	 * @param string $url URL to validate
	 *
	 * @return bool True if valid URL, false otherwise
	 */
	public static function is_valid_url( $url ) {
		return filter_var( $url, FILTER_VALIDATE_URL ) !== false;
	}

	/**
	 * Get plugin option
	 *
	 * @param string $option  Option name
	 * @param mixed  $default Default value if option doesn't exist
	 *
	 * @return mixed Option value
	 */
	public static function get_option( $option, $default = '' ) {
		return get_option( 'fwpp_pro_' . $option, $default );
	}

	/**
	 * Update plugin option
	 *
	 * @param string $option Option name
	 * @param mixed  $value  Option value
	 *
	 * @return bool True if option was updated, false otherwise
	 */
	public static function update_option( $option, $value ) {
		return update_option( 'fwpp_pro_' . $option, $value );
	}

	/**
	 * Delete plugin option
	 *
	 * @param string $option Option name
	 *
	 * @return bool True if option was deleted, false otherwise
	 */
	public static function delete_option( $option ) {
		return delete_option( 'fwpp_pro_' . $option );
	}

	/**
	 * Get user meta
	 *
	 * @param int    $user_id User ID
	 * @param string $meta_key Meta key
	 * @param bool   $single   Single value or array
	 *
	 * @return mixed User meta value
	 */
	public static function get_user_meta( $user_id, $meta_key, $single = true ) {
		return get_user_meta( $user_id, 'fwpp_pro_' . $meta_key, $single );
	}

	/**
	 * Update user meta
	 *
	 * @param int    $user_id   User ID
	 * @param string $meta_key  Meta key
	 * @param mixed  $meta_value Meta value
	 *
	 * @return int|bool Meta ID on success, false otherwise
	 */
	public static function update_user_meta( $user_id, $meta_key, $meta_value ) {
		return update_user_meta( $user_id, 'fwpp_pro_' . $meta_key, $meta_value );
	}

	/**
	 * Get post meta
	 *
	 * @param int    $post_id  Post ID
	 * @param string $meta_key Meta key
	 * @param bool   $single   Single value or array
	 *
	 * @return mixed Post meta value
	 */
	public static function get_post_meta( $post_id, $meta_key, $single = true ) {
		return get_post_meta( $post_id, 'fwpp_pro_' . $meta_key, $single );
	}

	/**
	 * Update post meta
	 *
	 * @param int    $post_id    Post ID
	 * @param string $meta_key   Meta key
	 * @param mixed  $meta_value Meta value
	 *
	 * @return int|bool Meta ID on success, false otherwise
	 */
	public static function update_post_meta( $post_id, $meta_key, $meta_value ) {
		return update_post_meta( $post_id, 'fwpp_pro_' . $meta_key, $meta_value );
	}

	/**
	 * Delete post meta
	 *
	 * @param int    $post_id  Post ID
	 * @param string $meta_key Meta key
	 *
	 * @return bool True if meta was deleted, false otherwise
	 */
	public static function delete_post_meta( $post_id, $meta_key ) {
		return delete_post_meta( $post_id, 'fwpp_pro_' . $meta_key );
	}

	/**
	 * Log message to file
	 *
	 * @param string $message Message to log
	 * @param string $type    Log type: 'info', 'warning', 'error'
	 *
	 * @return bool True if logged successfully, false otherwise
	 */
	public static function log( $message, $type = 'info' ) {
		if ( ! defined( 'WP_DEBUG' ) || ! WP_DEBUG ) {
			return false;
		}

		$log_dir = WP_CONTENT_DIR . '/fwpp-pro-logs';

		if ( ! is_dir( $log_dir ) ) {
			@mkdir( $log_dir, 0755, true );
		}

		$log_file = $log_dir . '/fwpp-pro-' . gmdate( 'Y-m-d' ) . '.log';
		$timestamp = gmdate( 'Y-m-d H:i:s' );
		$log_entry = "[{$timestamp}] [{$type}] {$message}\n";

		return (bool) @file_put_contents( $log_file, $log_entry, FILE_APPEND );
	}

	/**
	 * Get formatted date
	 *
	 * @param mixed  $date   Date to format (timestamp, string, etc.)
	 * @param string $format Date format. Default: WordPress date format
	 *
	 * @return string Formatted date
	 */
	public static function get_formatted_date( $date = null, $format = null ) {
		if ( null === $format ) {
			$format = get_option( 'date_format' );
		}

		if ( null === $date ) {
			$date = current_time( 'timestamp' );
		} elseif ( is_string( $date ) ) {
			$date = strtotime( $date );
		}

		return gmdate( $format, $date );
	}

	/**
	 * Get formatted time
	 *
	 * @param mixed  $time   Time to format (timestamp, string, etc.)
	 * @param string $format Time format. Default: WordPress time format
	 *
	 * @return string Formatted time
	 */
	public static function get_formatted_time( $time = null, $format = null ) {
		if ( null === $format ) {
			$format = get_option( 'time_format' );
		}

		if ( null === $time ) {
			$time = current_time( 'timestamp' );
		} elseif ( is_string( $time ) ) {
			$time = strtotime( $time );
		}

		return gmdate( $format, $time );
	}

	/**
	 * Get human readable time difference
	 *
	 * @param int $timestamp Timestamp
	 *
	 * @return string Human readable time difference
	 */
	public static function human_time_diff( $timestamp ) {
		return human_time_diff( $timestamp, current_time( 'timestamp' ) ) . ' ago';
	}

	/**
	 * Check if post exists
	 *
	 * @param int $post_id Post ID
	 *
	 * @return bool True if post exists, false otherwise
	 */
	public static function post_exists( $post_id ) {
		return get_post( $post_id ) !== null;
	}

	/**
	 * Get post permalink
	 *
	 * @param int $post_id Post ID
	 *
	 * @return string|bool Post permalink or false if not found
	 */
	public static function get_post_permalink( $post_id ) {
		return get_permalink( $post_id );
	}

	/**
	 * Get post excerpt
	 *
	 * @param int $post_id    Post ID
	 * @param int $length     Max length of excerpt
	 * @param string $more    Text to append if truncated
	 *
	 * @return string Post excerpt
	 */
	public static function get_post_excerpt( $post_id, $length = 55, $more = '...' ) {
		$post = get_post( $post_id );

		if ( ! $post ) {
			return '';
		}

		$excerpt = $post->post_excerpt ? $post->post_excerpt : $post->post_content;
		$excerpt = wp_strip_all_tags( $excerpt );
		$excerpt = preg_replace( '`\[[^\]]*\]`', '', $excerpt );

		if ( strlen( $excerpt ) > $length ) {
			$excerpt = substr( $excerpt, 0, $length ) . $more;
		}

		return $excerpt;
	}

	/**
	 * Enqueue script with error handling
	 *
	 * @param string $handle     Script handle
	 * @param string $src        Script source
	 * @param array  $deps       Dependencies
	 * @param string $version    Version
	 * @param bool   $in_footer  Load in footer
	 *
	 * @return void
	 */
	public static function enqueue_script( $handle, $src, $deps = array(), $version = FWPP_PRO_VERSION, $in_footer = true ) {
		wp_enqueue_script( $handle, $src, $deps, $version, $in_footer );
	}

	/**
	 * Enqueue style with error handling
	 *
	 * @param string $handle  Style handle
	 * @param string $src     Style source
	 * @param array  $deps    Dependencies
	 * @param string $version Version
	 * @param string $media   Media type
	 *
	 * @return void
	 */
	public static function enqueue_style( $handle, $src, $deps = array(), $version = FWPP_PRO_VERSION, $media = 'all' ) {
		wp_enqueue_style( $handle, $src, $deps, $version, $media );
	}

	/**
	 * Send JSON response
	 *
	 * @param mixed $data       Data to send
	 * @param int   $status_code HTTP status code
	 *
	 * @return void
	 */
	public static function send_json_response( $data, $status_code = 200 ) {
		wp_send_json( $data, $status_code );
	}

	/**
	 * Send success JSON response
	 *
	 * @param string $message Message to send
	 * @param mixed  $data    Additional data
	 *
	 * @return void
	 */
	public static function send_success_response( $message = '', $data = null ) {
		wp_send_json_success(
			array(
				'message' => $message,
				'data'    => $data,
			)
		);
	}

	/**
	 * Send error JSON response
	 *
	 * @param string $message Message to send
	 * @param int    $code    Error code
	 *
	 * @return void
	 */
	public static function send_error_response( $message = '', $code = 400 ) {
		wp_send_json_error(
			array(
				'message' => $message,
				'code'    => $code,
			)
		);
	}

	/**
	 * Get plugin URL
	 *
	 * @param string $path Optional path within plugin
	 *
	 * @return string Plugin URL
	 */
	public static function get_plugin_url( $path = '' ) {
		$url = plugin_dir_url( FWPP_PRO_FILE );

		if ( $path ) {
			$url = trailingslashit( $url ) . $path;
		}

		return $url;
	}

	/**
	 * Get plugin path
	 *
	 * @param string $path Optional path within plugin
	 *
	 * @return string Plugin path
	 */
	public static function get_plugin_path( $path = '' ) {
		$plugin_path = plugin_dir_path( FWPP_PRO_FILE );

		if ( $path ) {
			$plugin_path = trailingslashit( $plugin_path ) . $path;
		}

		return $plugin_path;
	}

	/**
	 * Load template file
	 *
	 * @param string $template_name Template file name
	 * @param array  $args          Variables to pass to template
	 * @param string $template_path Path within plugin to templates
	 *
	 * @return void
	 */
	public static function load_template( $template_name, $args = array(), $template_path = 'templates/' ) {
		$file = self::get_plugin_path( $template_path . $template_name );

		if ( file_exists( $file ) ) {
			if ( ! empty( $args ) ) {
				extract( $args );
			}
			include $file;
		}
	}

	/**
	 * Check if AJAX request
	 *
	 * @return bool True if AJAX request, false otherwise
	 */
	public static function is_ajax_request() {
		return defined( 'DOING_AJAX' ) && DOING_AJAX;
	}

	/**
	 * Verify AJAX nonce
	 *
	 * @param string $nonce Nonce value
	 * @param string $action Nonce action
	 *
	 * @return bool True if nonce is valid, false otherwise
	 */
	public static function verify_ajax_nonce( $nonce, $action = '' ) {
		return wp_verify_nonce( $nonce, 'fwpp_pro_' . $action ) !== false;
	}

	/**
	 * Get AJAX nonce
	 *
	 * @param string $action Nonce action
	 *
	 * @return string Nonce value
	 */
	public static function get_ajax_nonce( $action = '' ) {
		return wp_create_nonce( 'fwpp_pro_' . $action );
	}

	/**
	 * Escape output for display
	 *
	 * @param mixed  $data Data to escape
	 * @param string $type Type of escaping: 'html', 'attr', 'js', 'url'
	 *
	 * @return mixed Escaped data
	 */
	public static function escape_output( $data, $type = 'html' ) {
		switch ( $type ) {
			case 'attr':
				return esc_attr( $data );

			case 'js':
				return esc_js( $data );

			case 'url':
				return esc_url( $data );

			case 'html':
			default:
				return wp_kses_post( $data );
		}
	}

	/**
	 * Get WordPress version
	 *
	 * @return string WordPress version
	 */
	public static function get_wp_version() {
		global $wp_version;
		return $wp_version;
	}

	/**
	 * Check minimum WordPress version
	 *
	 * @param string $required Required version
	 *
	 * @return bool True if WordPress version meets requirement, false otherwise
	 */
	public static function check_wp_version( $required ) {
		global $wp_version;
		return version_compare( $wp_version, $required, '>=' );
	}

	/**
	 * Check minimum PHP version
	 *
	 * @param string $required Required version
	 *
	 * @return bool True if PHP version meets requirement, false otherwise
	 */
	public static function check_php_version( $required ) {
		return version_compare( phpversion(), $required, '>=' );
	}

	/**
	 * Get all plugin data
	 *
	 * @return array Plugin data
	 */
	public static function get_plugin_data() {
		if ( ! function_exists( 'get_plugin_data' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		return get_plugin_data( FWPP_PRO_FILE );
	}

	/**
	 * Debug variable output
	 *
	 * @param mixed $var Variable to debug
	 * @param bool  $die  Whether to die after output
	 *
	 * @return void
	 */
	public static function debug( $var, $die = false ) {
		if ( current_user_can( 'manage_options' ) && ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ) {
			echo '<pre>';
			print_r( $var );
			echo '</pre>';

			if ( $die ) {
				die();
			}
		}
	}

}
