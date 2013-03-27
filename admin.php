<?php
/**
 * Include and setup custom metaboxes and fields.
 *
 * @category Genesis Minimum Images Extended
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
 */

//add_image_size( 'gmie-banner', 300, 200, true ); //(cropped)

add_filter( 'cmb_meta_boxes', 'gmie_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function gmie_metaboxes( array $meta_boxes ) {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_gmie_';

	$meta_boxes[] = array(
		'id'         => 'gmie_metabox',
		'title'      => 'Banner Image',
		'pages'      => array( 'page', 'post' ), // Post type
		'context'    => 'side',
		'priority'   => 'default',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
				array(
					'name' => 'Image',
					'desc' => 'Upload an image or enter a URL.',
					'id'   => $prefix . 'image',
					'type' => 'file',
					'save_id' => true,
					),
		),
	);

	// Add other metaboxes as needed

	return $meta_boxes;
}
