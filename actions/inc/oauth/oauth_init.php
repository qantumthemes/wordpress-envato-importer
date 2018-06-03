<?php



/*
ini_set('display_errors','On'); 
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
*/

$key = get_option('beatport_api_key');
$secret = get_option('beatport_api_secret');

$baseurl = 'https://oauth-api.beatport.com/';
$accessurl = 'identity/1/oauth/direct-access-token';



//= CLIENT
//  ================================================================

$req_url = 'https://oauth-api.beatport.com/identity/1/oauth/request-token';
$authurl = 'https://oauth-api.beatport.com/identity/1/oauth/authorize';
$acc_url = 'https://oauth-api.beatport.com/identity/1/oauth/access-token';
$api_url = 'https://oauth-api.beatport.com';
$callbackurl = admin_url('tools.php?page=qtenvatoimp_settings');
$conskey = $key;



/* = inizializzazione base
=================================================*/

$oauthObject = new OAuthSimple();

?>