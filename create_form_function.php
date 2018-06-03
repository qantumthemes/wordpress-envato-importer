<?php
if(!function_exists('cd_meta_cb')){
function cd_meta_cb( $post ) 
{
	//include 'vars.php';
	include get_template_directory().'/custom-types/'.CUSTOM_TYPE_CHART.'/vars.php';	
	require_once get_template_directory().'/custom-types/form_creation.php';	
	$post_type = get_post_type( $post );
	wp_nonce_field( 'save_'.$post_type.'_meta', $post_type.'_nonce' );
	$n=0;
	foreach($fields as $f){
		$f[2] = get_post_meta( $post->ID,  $f[0], true );

		$n++;
	}
    echo '<div style="clear:both">&nbsp;</div>';
}


}