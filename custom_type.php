<?php


/*==========================================================================
*
*
*
*
*
*
*
*                                                              CUSTOM POST TYPE
*
*
*
*
*
*
==========================================================================*/


/*
* custom post type ProductItem
*/

define ('CUSTOM_TYPE_QWPRODUCTITEM','Product item');
add_action('init', 'qw_proditem_register_type');  

if(!function_exists('qw_proditem_register_type')){
function qw_proditem_register_type() {
    $labels = array(
    'name' => __(ucfirst(CUSTOM_TYPE_QWPRODUCTITEM)).'s',
    'singular_name' => __(ucfirst(CUSTOM_TYPE_QWPRODUCTITEM)),
    'add_new' => 'Add New ',
    'add_new_item' => 'Add New '.__(ucfirst(CUSTOM_TYPE_QWPRODUCTITEM)),
    'edit_item' => 'Edit '.__(ucfirst(CUSTOM_TYPE_QWPRODUCTITEM)),
    'new_item' => 'New '.__(ucfirst(CUSTOM_TYPE_QWPRODUCTITEM)),
    'all_items' => 'All '.__(ucfirst(CUSTOM_TYPE_QWPRODUCTITEM)).'s',
    'view_item' => 'View '.__(ucfirst(CUSTOM_TYPE_QWPRODUCTITEM)),
    'search_items' => 'Search '.__(ucfirst(CUSTOM_TYPE_QWPRODUCTITEM)).'s',
    'not_found' =>  'No '.CUSTOM_TYPE_QWPRODUCTITEM.' found',
    'not_found_in_trash' => 'No '.CUSTOM_TYPE_QWPRODUCTITEM.'s found in Trash', 
    'parent_item_colon' => '',
    'menu_name' => __(ucfirst(CUSTOM_TYPE_QWPRODUCTITEM)).'s'
  );

  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'page',
    'has_archive' => true,
    'hierarchical' => false,
    'menu_position' => true,
    'page-attributes' => true,
    'show_in_nav_menus' => true,
    'show_in_admin_bar' => true,
    'show_in_menu' => true,
    'supports' => array('title', 'thumbnail','editor', 'page-attributes')
  ); 

    register_post_type( 'qw-product-item' , $args );

    /* ============= create custom taxonomy for the podcasts ==========================*/

     $labels = array(
    'name' => __( 'Product Tag','_s' ),
    'singular_name' => __( 'Product Tag','_s' ),
    'search_items' =>  __( 'Search by Product Tag','_s' ),
    'popular_items' => __( 'Popular Product Tag','_s' ),
    'all_items' => __( 'All Product Tag','_s' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __( 'Edit Product Tag','_s' ), 
    'update_item' => __( 'Update Product Tag','_s' ),
    'add_new_item' => __( 'Add New Product Tag','_s' ),
    'new_item_name' => __( 'New Product Tag Name','_s' ),
    'separate_items_with_commas' => __( 'Separate Product Tag with commas','_s' ),
    'add_or_remove_items' => __( 'Add or remove Product Tag','_s' ),
    'choose_from_most_used' => __( 'Choose from the most used Product Tag','_s' ),
    'menu_name' => __( 'Product Tags','_s' ),
  ); 

  register_taxonomy('product-tag','qw-product-item',array(
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' => array( 'slug' => 'product-tag' ),
  ));


    $labelscat = array(
    'name' => __( 'Product Category','_s' ),
    'singular_name' => __( 'Product Category','_s' ),
    'search_items' =>  __( 'Search by Product Category','_s' ),
    'popular_items' => __( 'Popular Product Category','_s' ),
    'all_items' => __( 'All Product Category','_s' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __( 'Edit Product Category','_s' ), 
    'update_item' => __( 'Update Product Category','_s' ),
    'add_new_item' => __( 'Add New Product Category','_s' ),
    'new_item_name' => __( 'New Product Category Name','_s' ),
    'separate_items_with_commas' => __( 'Separate Product Category with commas','_s' ),
    'add_or_remove_items' => __( 'Add or remove Product Category','_s' ),
    'choose_from_most_used' => __( 'Choose from the most used Product Categories','_s' ),
    'menu_name' => __( 'Product Categories','_s' ),
  ); 

  register_taxonomy('product-category','qw-product-item',array(
    'hierarchical' => false,
    'labels' => $labelscat,
    'show_ui' => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' => array( 'slug' => 'product-category' ),
  ));

}}





include 'create_form_function.php';
include 'form_creation.php';
include 'form_saving.php';


/* = meta box 
========================================================================*/
$current_post_type = CUSTOM_TYPE_QWPRODUCTITEM;

// ======================== create form ====================== 
function cd_qwproditem_meta_cb( $post ){
    include 'vars.php';
    //require_once get_template_directory().'/custom-types/form_creation.php';  
    $post_type = "qw-product-item";
    wp_nonce_field( 'save_'.$post_type.'_meta', $post_type.'_nonce' );
    foreach($fields as $f){
        $f[2] = get_post_meta( $post->ID,  $f[0], true );
        echo qw_qantumpro_create_form_row( $f[0], $f[1], $f[2], $f[3]);
    }
    echo '<div style="clear:both">&nbsp;</div>';
}

// dynamic function to call on every custom post type
add_action( 'add_meta_boxes', 'cd_qwproditem_meta_cbf' );
function cd_qwproditem_meta_cbf(){
    add_meta_box( 'qw-product-item-meta', 'Details' , 'cd_qwproditem_meta_cb', 'qw-product-item', 'normal', 'high' );
}


// ======================== save ====================== 
add_action( 'save_post', 'cd_qwproditem_meta_save' );
function cd_qwproditem_meta_save( $id )
{
   // die("ok salvo");
    $typename = "qw-product-item";
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if( !isset( $_POST[$typename.'_nonce'] ) || !wp_verify_nonce( $_POST[$typename.'_nonce'], 'save_'.$typename.'_meta' ) ) 
        return;
    if( !current_user_can( 'edit_post',$id ) ) 
        return;
    include 'vars.php';
    include 'form_saving.php';
    $tosave = array();
    foreach($fields as $f){
        if(isset($f[0]) && isset($_POST[$f[0]])){
            //$tosave[] =array ($f[0], $f[1], $_POST[$f[0]], $f[3],$id);
            qantumpro_save_form_row($f[0], $f[1], $_POST[$f[0]], $f[3],$id);
        }
    }
  //  print_r($tosave);
}


