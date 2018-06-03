<?php

// common useful functz
function get_inclusion_url($s=3){
	$u='';
	for($n=0; $n<$s ; $n++){
		$u.= '../';
	}
	return $u;
}


/////////////////////////////////// get_mid_by_key
function get_mid_by_key( $post_id, $meta_key ) {
	  global $wpdb;
	  $mid = $wpdb->get_var( $wpdb->prepare("SELECT meta_id FROM $wpdb->postmeta WHERE post_id = %d AND meta_key = %s", $post_id, $meta_key) );
	  if( $mid != '' )
		return (int)$mid;
	  return false;
}

	

//==================== SET FEATURED IMAGE BY URL ==========================================================
if(!function_exists('set_featuredimage_by_url')){
function set_featuredimage_by_url($image_url,$post_id){
	if ($image_url == '' || $post_id == ''){
		return false;	
	}
	$errors = 0;
	$upload_dir = wp_upload_dir();
	// Updated from issue with godaddy hosting on 2013 07 10
	if(function_exists('file_get_contents')){ // requests allow_url_fopen = On on php.ini
		$image_data = file_get_contents($image_url);
	}else {
		if (!function_exists('curl_init')){ 
			return false;
		}else{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $Url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			if($output = curl_exec($ch)){
				curl_close($ch);
				$image_data = $output;
			}else{
				return false;
			}
		}
	}
	$filename = basename($image_url);
	if(wp_mkdir_p($upload_dir['path']))
		$file = $upload_dir['path'] . '/' . $filename;
	else
		$file = $upload_dir['basedir'] . '/' . $filename;
	if(!file_put_contents($file, $image_data)){
		return false;	
	};
	$wp_filetype = wp_check_filetype($filename, null );
	$attachment = array(
		'post_mime_type' => $wp_filetype['type'],
		'post_title' => sanitize_file_name($filename),
		'post_content' => '',
		'post_status' => 'inherit'
	);
	$attach_id = wp_insert_attachment( $attachment, $file, $post_id );
	require_once(ABSPATH . 'wp-admin/includes/image.php');
	$attach_data = wp_generate_attachment_metadata( $attach_id, $file );
	if(!wp_update_attachment_metadata( $attach_id, $attach_data )){
		return false;	
	}
	if(!set_post_thumbnail( $post_id, $attach_id )){
		$errors++;
	}
	if ($errors == 0){
		return true;	
	}
}
}



?>