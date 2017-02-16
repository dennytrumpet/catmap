<?php

/*
Plugin Name: Cat Map
Plugin URI: http://voxmd.com
Description: 
Version: 1.00
Author: Dennis McGhee
Author URI: http://the3rdplace.co

	Copyright 2017  DENNIS MCGHEE 
	
	(email : dennis.mcghee@voxmd.com)

*/
/* changed to wp-options and transients */
function catmap_install() {
add_option('catmap_db_version', '1.00');
}

function catmap_select() { ?>
        <form action="<?php bloginfo('url'); ?>/" method="get">

        <div id="parent_cat_div"><?php wp_dropdown_categories("show_option_none=Select Subject&orderby=name&hide_empty=0&depth=1&hierarchical=1&id=parent_cat"); ?></div>

        <div id="sub_cat_div"><select name="sub_cat_disabled" id="sub_cat_disabled" disabled="disabled"><option>Select parent category first!</option></select></div>


        </form>
<?php }

function implement_ajax() {
    $parent_cat_ID = $_POST['parent_cat_ID'];
    if ( isset($parent_cat_ID) )
    {
        $has_children = get_categories("parent=$parent_cat_ID");
        if ( $has_children ) {
            wp_dropdown_categories("show_option_none=Select Course&orderby=name&id=child_cat&parent=$parent_cat_ID"); ?>
                <article <?php post_class(); ?>>
                    <header>
                        <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    </header>
                    <div class="entry-summary">
                        <?php the_excerpt(); ?>
                    </div>
                </article>
                <?php
        
        } else {
            ?><select name="sub_cat_disabled" id="sub_cat_disabled" disabled="disabled"><option>No child categories!</option></select><?php
        }
        die();
    } // end if
}
add_action('wp_ajax_category_select_action', 'implement_ajax');
add_action('wp_ajax_nopriv_category_select_action', 'implement_ajax');//for users that are not logged in.

//this is optional, only if you are not already using jQuery  
function load_jquery() {
    wp_enqueue_script('jquery');            
}     
add_action('init', 'load_jquery');
// register jquery and style on initialization
add_action('init', 'register_script');
function register_script() {
    wp_register_script( 'cat_script', plugins_url('/js/catmap.js', __FILE__), array('jquery'));
    wp_register_style( 'cat_style', plugins_url('/css/style.css', __FILE__));
}

// use the registered jquery and style above
add_action('wp_enqueue_scripts', 'enqueue_style');

function enqueue_style(){
   wp_enqueue_script('cat_script');
   wp_enqueue_style( 'cat_style' );
}

function catmap_uninstall() {
delete_option('catmap_db_version');
}

register_uninstall_hook(__FILE__, 'catmap_uninstall');

add_shortcode( 'catmap', 'catmap_select' );

register_activation_hook(__FILE__, 'catmapinstall');
?>