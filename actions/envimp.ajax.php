<?php

/* = Envato Importer Ajax Service
===================================================*/
include 'inc/_common.php';
if (!class_exists('OAuthSimpleException')) {
    require 'inc/oauth/OAuthSimple.php';
}



define ('ENVATOAPIBASE','http://marketplace.envato.com/api/edge/');
define ('INCLUSIONPATH',urldecode($_GET['secretpath']));
include(INCLUSIONPATH.'wp-load.php');


/* = FUNCTION TO GET THE CURRENT PAGE URL
======================================================*/

if(!function_exists('curPageURL')){
	function curPageURL() {
		 $pageURL = 'http';
		if(isset($_SERVER["HTTPS"])){
		    if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
		}
		 $pageURL .= "://";
		 if ($_SERVER["SERVER_PORT"] != "80") {
		  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		 } else {
		  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		 }
		 return $pageURL;
	}
}


/* = GRAB Envato CONTENT USING OAUTH PROTOCOL
======================================================*/

if(!function_exists('obtainEnvatoDataOAuth')){
	function obtainEnvatoDataOAuth ($requestString = '',$parameters = array()){
			//echo $requestString;
			$defaults = array(
			 'method' => 'GET',
			 'timeout' => 5,
			 'redirection' => 5,
			 'httpversion' => '1.0',
			 'user-agent' => 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36',
			 'reject_unsafe_urls' => false,
			 'blocking' => true,
			 'headers' => array(),
			 'cookies' => array(),
			 'body' => null,
			 'compress' => false,
			 'decompress' => true,
			 'sslverify' => true,
			 'stream' => false,
			 'filename' => null,
			 'limit_response_size' => null,
			);

	        $response = wp_remote_get(
	            ENVATOAPIBASE.$requestString, 
	            $defaults
			);	        
			if ( is_wp_error( $response ) ) {
			   $error_message = $response->get_error_message();
			   return "Something went wrong: $error_message";
			} else {
			   return $response['body'];//$response ;
			}
	}
}

/* get envato stuff by url */
if(!function_exists('qwGetEnvData')){
	function qwGetEnvData ($url){
		//echo $requestString;
		$defaults = array(
		 'method' => 'GET',
		 'timeout' => 10,
		 'redirection' => 5,
		 'httpversion' => '1.0',
		 'user-agent' => 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36',
		 'reject_unsafe_urls' => false,
		 'blocking' => true,
		 'headers' => array(),
		 'cookies' => array(),
		 'body' => null,
		 'compress' => false,
		 'decompress' => true,
		 'sslverify' => true,
		 'stream' => false,
		 'filename' => null,
		 'limit_response_size' => null,
		);

        $response = wp_remote_get(
            $url, 
            $defaults
		);	        
		if ( is_wp_error( $response ) ) {
		   $error_message = $response->get_error_message();
		   return "Something went wrong: $error_message";
		} else {
		   return $response['body'];//$response ;
		}
	}
}



if(isset($_GET['action']))
{
	if($_GET['action']=='getItemId'){
		require 'inc/getReleasesId.ajax.php';
		echo qw_return_items_array($_GET['Url'],$_GET['marketplace']);
	}
	if($_GET['action']=='urlToRequest'){
		require 'inc/urlToRequest.php';
		echo qw_urlToRequest($_GET['Url'],$_GET['marketplace']);
	}
	if($_GET['action']=='ImportItem'){		
		require 'inc/urlToRequest.php';
		$apiRequest = qw_urlToRequest($_GET['Url'],$_GET['marketplace']);
		$data =  obtainEnvatoDataOAuth ($apiRequest,$parameters = array());
		echo $data;
	}
	if($_GET['action']=='ImportArchive'){

		require 'inc/urlToRequest.php';
		$apiRequest = qw_urlToRequest($_GET['Url'],$_GET['marketplace']);
		if($data =  obtainEnvatoDataOAuth ($apiRequest,$parameters = array())){
			echo $data;
		}else{
			//echo 'X';
		}
	}
	if($_GET['action']=='getPrivateData'){
		if(isset($_GET['url'])){
			$data =  qwGetEnvData ($_GET['url']);
		}
		echo $data;
	}


	if($_GET['action']=='getPageContent'){
		if(isset($_POST['url'])){
			$defaults = array(
			 'method' => 'GET',
			 'timeout' => 5,
			 'redirection' => 5,
			 'httpversion' => '1.0',
			 'user-agent' => 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36',
			 'reject_unsafe_urls' => false,
			 'blocking' => true,
			 'headers' => array(),
			 'cookies' => array(),
			 'body' => null,
			 'compress' => false,
			 'decompress' => true,
			 'sslverify' => true,
			 'stream' => false,
			 'filename' => null,
			 'limit_response_size' => null,
			);
			$response = wp_remote_get(
		            $_POST['url'], 
		            $defaults
				);	        
				if ( is_wp_error( $response ) ) {
				   $error_message = $response->get_error_message();
				   echo  "Something went wrong: $error_message";
				} else {
				   echo $response['body'];//$response ;
				}
		}else{
			echo 'Missing the URL';
		}
	}



	if($_GET['action']=='createProduct'){

		$postexixts = 0;
		$id = $_POST['id'];
		$title = $_POST['item'];

		//echo $_POST['pagecontent'];
		//print_r($_POST['pagecontent']);
		//return;


		/*
		*
		*	Check if the product is already created
		*
		*/
		global $wpdb;
		$return = $wpdb->get_row( "SELECT ID FROM wp_posts WHERE post_title = '" . $title . "' && post_status = 'publish' && post_type = 'qw-product-item' ", 'ARRAY_N' );
		//print_r($return);
		if( empty( $return ) ) {
			$postexixts = false;
		} else {
			//die ("already existing");
			$post_id = $return[0];
			$postexixts = true;
		}

		// End of the check

		$apiRequest = 'item:'.$id.'.json';
		$data =  obtainEnvatoDataOAuth ($apiRequest,$parameters = array());
		$data = json_decode($data,true);
		$item = $data['item'];
		$fields=array('id','item','url','user','thumbnail','sales','rating','cost','preview_type','preview_url','live_preview_video_url');
		$result = '';
		

		/*
		*
		*	Create the post
		*
		*/
		if($postexixts == false){
			$new_post = array(
			 'post_title' => $item['item'],		 
			 'post_status' => 'publish',
			 'post_date' => date('Y-m-d H:i:s'),
			 'post_content' =>strip_tags($_POST['pagecontent'],'<p><img><strong><h1><h2><h3><code><pre>'),
			 'post_type' => 'qw-product-item',
			 'tax_input' => array('product-tag' => explode(",",$item['tags']),
			                      'product-category' => explode("/",$item['category']),
			                      ),
			 'filter' => true
			);
			
			kses_remove_filters();			
			if(!$post_id = wp_insert_post($new_post)){
				$result .= 'Impossible to create the content. Maybe a database error or wp privileges.<bt>';
			}else{		
				if(array_key_exists('live_preview_url', $item)	){	
					if(!set_featuredimage_by_url($item['live_preview_url'],$post_id)){
						$result .= 'Impossible to create the featured images. Seems a folder chmod block.<bt>';
					}
				}				
				foreach($fields as $field){
					if(array_key_exists($field, $item)	){	
						//echo 'Creating meta field: '.$field.': '.$item[$field].'<br>';
						if(!update_post_meta( $post_id,"qw_".$field,$item[$field])){
							$result .= 'Error updating post meta '.$field.'.<bt>';
						}
					}
				}
				$result .= '<p class="responseOk">Item created<br>
							<a href="'.get_permalink($post_id).'" target="_blank">Click here to see</a><br />
							<a href="post.php?post='.$post_id.'&action=edit" >Edit</a></p>';
			}			
			
		} else {
			/*
			*
			*
			*	Is already created with the same title, i'm just updating pics and ratings
			*
			*/
			$result .= 'Post already existing, updating image and ratings<br>';
			if(array_key_exists('live_preview_url', $item)	){	
				if(!set_featuredimage_by_url($item['live_preview_url'],$post_id)){
					$result .= 'Impossible to create the featured images. Seems a folder chmod block.<bt>';
				}
			}
			$fieldsUpdate = array('id','item','url','user','thumbnail','sales','rating','cost','preview_type','preview_url','live_preview_video_url');
			foreach($fieldsUpdate as $field){
				//echo "updating post meta: ".$post_id.' - '."qw_".$field.' - '.$item[$field].'<br><br>';
				if(array_key_exists($field, $item)	){	
					//echo 'Updating: '.$field.': '.$item[$field].'<br>';
					update_post_meta( $post_id,"qw_".$field, $item[$field]);
				}
			}
			$result .= '<p class="responseOk">Item Updated<br>
							<a href="'.get_permalink($post_id).'" target="_blank">Click here to see</a><br />
							<a href="post.php?post='.$post_id.'&action=edit" >Edit</a></p>';

		}
		echo $result;
	}
	if(!isset($_GET['action'])){
		echo 'No action set';
	}
}	else{
	echo 'no action';
}






	

?>