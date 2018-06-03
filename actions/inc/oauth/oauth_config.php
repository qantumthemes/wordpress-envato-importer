<?php

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

if(!function_exists('saveBeatpostApiKey')){
	function saveBeatpostApiKey(){

		if(isset($_POST['resetbeatportapikey'])){
			delete_option('beatport_api_key');
			delete_option('beatport_api_secret');
			
			//header("location: ".admin_url('tools.php?page=qtenvatoimp_settings') );

		}
		
		if(isset($_POST['beatportapikey']) && isset($_POST['beatportapisecret'])){
			
			if($_POST['beatportapikey']!=''){
				update_option('beatport_api_key',$_POST['beatportapikey']);
			}
			if($_POST['beatportapisecret']!=''){
				update_option('beatport_api_secret',$_POST['beatportapisecret']);
			}
			header("location: ".admin_url('tools.php?page=qtenvatoimp_settings') );
		}
	}
}
if(is_admin() && current_user_can( 'manage_options' ) ){
	//add_action('admin_init','saveBeatpostApiKey');
	add_action( 'admin_init', 'saveBeatpostApiKey', 1 );

}







?>