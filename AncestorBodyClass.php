<?php
/**
 * @package AncestorBodyClass
 * @version 1.0
 */
/*
Plugin Name: Ancestor Bodyclass
Plugin URI: https://github.com/cfenzo/wordpress-plugin-AncestorBodyClass
Description: A small util to add "ancestor-[slug]" as class on the body
Author: Jens Anders Bakke
Version: 1.0
Author URI: https://github.com/cfenzo/
*/

function add_top_ancestor($classes) {

       global $post;
       global $sitepress;

       if ($post->post_parent) {
              $ancestors=get_post_ancestors($post->ID);
              $root=count($ancestors)-1;
              $parent = $ancestors[$root];

       } else {
              $parent = $post->ID;
       }
       
       // support for WPML
       if(function_exists('icl_object_id')) {
              $main_language = $sitepress->get_default_language();
              $parent = icl_object_id($parent, 'page', false, $main_language);
       }

       $parentpost = get_post($parent);
       $parentslug = $parentpost->post_name;

       $classes[] = 'ancestor-'. $parentslug;

       return $classes;
}
add_filter('body_class', 'add_top_ancestor');
