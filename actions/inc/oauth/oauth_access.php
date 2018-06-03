<?php
function checkBPOauthAccess(){
    if(!function_exists('wp_remote_post')){
        return 'Error: wp remote post is not existing';
    }
    $ReturnResult = '';
    $time = date('H:i', time()); 
    include 'oauth_init.php';
    if(!isset($_COOKIE['access_token']) || !isset($_COOKIE['access_token_secret'])){
      //  echo 'caso 1';
        if (!isset($_GET['oauth_verifier']) || !isset($_COOKIE['oauth_token_secret']) && !isset($_COOKIE['access_token'])) {

           // echo 'caso 1.1 ';

            $signatures = array( 
                'request_token_uri' => $req_url,
                'authorize_uri' => $authurl, 
                'access_token_uri' => $callbackurl,

                'consumer_key'     => $key,
                'shared_secret'    => $secret
            );
             $result = $oauthObject->sign(
                array(
                    'path'      =>$req_url,
                    'oauth_callback_confirmed' => true,
                    'parameters'=> array(
                        
                      //  'oauth_timestamp' => time(),
                        //'oauth_nonce' => "UOQfDH7CyuS",
                        'oauth_callback'=> $callbackurl
                    ),
                    'signatures'=> $signatures
                )
             );

              // return date("H:i",1409362039).'<br>'.$result['signed_url'];//test


            $response = wp_remote_post($result['signed_url'], array(
                'method' => 'POST'
            ));
            if (is_wp_error($response)) {return 'Invalid response 001';}
       
            parse_str($response['body'], $returned_items);

            if(isset($returned_items['oauth_token'])){
                $request_token = $returned_items['oauth_token'];
                $request_token_secret = $returned_items['oauth_token_secret'];
                // setcookie("oauth_token_secret", $request_token_secret, time()-3600); old. Changed in SLAM 3.1
                if(!isset($secure)){$secure = '';}
                setcookie( "oauth_token_secret", $request_token_secret, time() + YEAR_IN_SECONDS, SITECOOKIEPATH, null, $secure );


                $result = $oauthObject->sign(array(
                    'path'      =>$acc_url,// edit 2013 10 11
                    'parameters'=> array(
                        'oauth_token' => $request_token

                        ),
                    'signatures'=> $signatures)
                );
                parse_str($result['signed_url'], $output);
              
                if(isset($output['oauth_token'])){
                    return '
                    <p>You are not logged. Login to Beatport to import your tracks. You will be redirected here after the login.<br /> </p>
                    <p><a class="button button-primary button-large" href="'.$authurl."?oauth_token=". $output['oauth_token'].'">LOGIN TO BEATPORT</a></p>';
                }
            }else{
                

                return '
                <br>Invalid Beatport Api Key and Secret. <br>Maybe is a metter of server time, is this your correct time now? '.$time.' - Offset: '.get_option( 'gmt_offset' ).'<br>
                <pre>'.stripslashes($response['body']).'</pre><br>
                '.$result['signed_url'];
            }

        }else{
           // echo 'caso 1.2 ';
           // return 'asd';

            if(!isset($_COOKIE['oauth_token_secret'])){
                return('Missing oauth_token_secret');
            }
            if(!isset($_COOKIE['access_token']) || !isset($_COOKIE['access_token_secret'])){
                $signatures = array( 
                    'request_token_uri' => $req_url,
                    'authorize_uri' => $authurl, 
                    'access_token_uri' => $acc_url,

                    'consumer_key'     => $key,
                    'shared_secret'    => $secret,
                    'oauth_secret' => $_COOKIE['oauth_token_secret'],
                    'oauth_token' => $_GET['oauth_token']
                );
                $result = $oauthObject->sign(array(
                    'path'      => $acc_url,
                    'parameters'=> array(
                        'oauth_verifier' => $_GET['oauth_verifier'],
                        'oauth_token'    => $_GET['oauth_token']
                        ),
                    'signatures'=> $signatures
                    )
                );
               $response = wp_remote_post($result['signed_url'], array(
                    'method' => 'POST'
                ));

                if (is_wp_error($response)) {return 'Invalid response 001';}
                parse_str($response['body'], $returned_items);

                if(isset($returned_items['oauth_token']) && isset($returned_items['oauth_token_secret'])){
                    $access_token = $returned_items['oauth_token'];
                    
                    $access_token_secret = $returned_items['oauth_token_secret'];
                    setcookie("access_token", $access_token, time() + YEAR_IN_SECONDS, SITECOOKIEPATH, null, $secure );
                    setcookie("access_token_secret", $access_token_secret, time() + YEAR_IN_SECONDS, SITECOOKIEPATH, null, $secure );

                    return  '
                    <h2>Allright sparky! Access granted!</h2>
                    <p><a class="button button-primary button-large" href="'.$callbackurl.'">PROCEED TO IMPORT</a></p>';
                }else{
                    return 'Login failed.';
                }
            }

        }
      //  echo 'Login to access Beatport data';
    }else{
        return 'Invalid Beatport Api Key and Secret, sorry. You must probably ask for a new API key';
        //return 'There is already a started access token. Clean your cookies,and login again please.';
    }

   // return 'Something is not working properly. You are not supposed to see this error. Contact support email. PLEASE NOTE THAT NOW BEATPORT REQUIRES PERMISSION TO USE THEIR API visit api.beatport.com for more info'
    //.$_COOKIE['access_token']
    //.$_COOKIE['access_token_secret']
    ;
}//function
?>