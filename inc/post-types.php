<?php

/**
 * Custom Post Types for this theme.
 *
 * @package wp-bootstrap-starter
 */

/**
 * Register Custom Post types.
 */
function register_cpts() {
  $types = [
    'news' => [
      'icon' => 'dashicons-location-alt',
      'plural' => 'news',
    ],
  ];

  foreach ($types as $type => $data) {
    // Sets the defaults.
    $slug = str_replace(["/", "  ", " "], ["", " ", "_"], $type);
    $singular = isset($data['singular']) ? $data['singular'] : $type;
    $plural = isset($data['plural']) ? $data['plural'] : $type . 's';
    $slug_plural = isset($data['plural']) ? $data['plural'] : $slug . 's';
    $menu_name = isset($data['menu_name']) ? $data['menu_name'] : $plural;
    $slug_base = isset($data['slug_base']) ? $data['slug_base'] : $slug;
    $taxonomies = isset($data['taxonomies']) ? $data['taxonomies'] : [];
    $supports = isset($data['supports']) ? $data['supports'] : [
      'title',
      'editor',
      'author',
      'thumbnail',
      'excerpt',
      'revisions',
      'custom-fields',
      'page-attributes'
    ];

    // Applies the defaults to the labels.
    $labels = [
      'name' => __( ucwords($plural), 'kesha' ),
      'menu_name' => __( ucwords($menu_name), 'kesha' ),
      'singular_name' => __( ucwords($plural), 'kesha' ),
      'add_new_item' => __( 'Add New ' . ucwords($singular), 'kesha' ),
      'edit_item' => __( 'Edit ' . ucwords($singular), 'kesha' ),
      'new_item' => __( 'New ' . ucwords($singular), 'kesha' ),
      'view_item' => __( 'View ' . ucwords($singular), 'kesha' ),
      'search_items' => __( 'Search ' . ucwords($plural), 'kesha' ),
      'not_found' => __( 'No ' . strtolower($plural) . ' found', 'kesha' ),
      'not_found_in_trash' => __( 'No ' . strtolower($plural) . ' found in Trash', 'kesha' ),
      'parent_item_colon' => __( 'Parent ' . ucwords($singular) . ':', 'kesha' ),
      'all_items' => __( 'All ' . ucwords($plural), 'kesha' ),
      'archives' => __( ucwords($singular) . ' Archives', 'kesha' ),
    ];

    $args = [
      'labels' => $labels,
      'description' => __( 'Sortable/filterable ' . $plural , 'kesha'),
      'public' => true,
      'has_archive' => isset($data['has_archive']) ? $data['has_archive'] : false,
      'show_ui' => isset($data['show']) ? $data['show'] : true,
      'show_in_nav_menus' => isset($data['show']) ? $data['show'] : true,
      'show_in_menu' => isset($data['show']) ? $data['show'] : true,
      'show_in_admin_bar' => isset($data['show']) ? $data['show'] : true,
      'menu_position' => isset($data['position']) ? $data['position'] : 20,
      'menu_icon' => $data['icon'],
      'hierarchical' => true,
      'rewrite' => [
        'slug' => __( $slug_base, 'kesha'),
        'with_front' => false,
        'feeds' => true,
      ],
      'query_var' => true,
      'show_in_rest' => true,
      'taxonomies'  => $taxonomies,
      'supports' => $supports,
    ];

    // Custom permissions.
    if (isset($data['caps']) && $data['caps']) {
      $args['map_meta_cap'] = true;
      $args['capability_type'] = $slug;
      $args['capabilities'] = [
        'create_posts' => 'create_' . $slug_plural,
        'delete_others_posts' => 'delete_others_' . $slug_plural,
        'delete_posts' => 'delete_' . $slug_plural,
        'delete_private_posts' => 'delete_private_' . $slug_plural,
        'delete_published_posts' => 'delete_published_' . $slug_plural,
        'edit_posts' => 'edit_' . $slug_plural,
        'edit_others_posts' => 'edit_others_' . $slug_plural,
        'edit_private_posts' => 'edit_private_' . $slug_plural,
        'edit_published_posts' => 'edit_published_' . $slug_plural,
        'publish_posts' => 'publish_' . $slug_plural,
        'read_private_posts' => 'read_private_' . $slug_plural,
        'read' => 'read',
      ];
    }
    register_post_type($slug, $args);
  }
}
add_action('init', 'register_cpts');

/**
 * Add CPT Members restriction capabilities.
 */
function register_cpt_members_caps() {
  $caps = [
    'create_',
    'delete_others_',
    'delete_',
    'delete_private_',
    'delete_published_',
    'edit_',
    'edit_others_',
    'edit_private_',
    'edit_published_',
    'publish_',
    'read_private_',
  ];

  $cpts = [
    'news',
  ];

  foreach ($cpts as $cpt) {
    foreach ($caps as $cap) {
      $slug = $cap . $cpt;
      $label = ucwords(str_replace("_", " ", $cap) . ' ' . str_replace("-", " ", $cpt));
      members_register_cap(
        $slug,
        [
          'label' => __( $label, 'kesha' ),
        ]
      );
    }
  }
}
add_action( 'members_register_caps', 'register_cpt_members_caps' );

/**
 * Turns off Gutenberg for custom post types.
 */
function turn_off_gutenberg($use_block_editor, $post_type) {
  switch ($post_type) {
    case 'news':
      return false;
      break;
  }
  return $use_block_editor;
}
add_filter('use_block_editor_for_post_type', 'turn_off_gutenberg', 10, 2);
