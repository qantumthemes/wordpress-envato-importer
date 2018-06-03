<?php
/*
Plugin Name: QantumThemes Envato Importer
*
*
*
*/

$resp_messages		= '';
if(!function_exists('qt_make_link_relative')){
function qt_make_link_relative( $link ) {
    $link = preg_replace( '|https?://[^/]+(/.*)|i', '$1', $link );
    return $link;
}}

include ('custom_type.php');
include ('vars.php');

/* = Definition Of The Ajax Service
==========================================================================*/

define('THISPLUGINURLENVI',qt_make_link_relative(plugin_dir_url(__FILE__).'actions/envimp.ajax.php')) ;
$toreplace = array(THISPLUGINURLENVI,'wp-admin');
$incPath =   urlencode(str_replace($toreplace,"",getcwd()));


define ('LOADURLENVI',THISPLUGINURLENVI.'?secretpath='.$incPath);



/* = import CSS and JS
==========================================================================*/

add_action( 'admin_enqueue_scripts', 'enqueue_qtEnvatoImporter_scripts',9900 );
function enqueue_qtEnvatoImporter_scripts() {		
	wp_register_style( 'qtEnvImpstyle', plugins_url( 'lib/style.css', __FILE__ ) , false, '1.0.0' );
	wp_enqueue_style( 'qtEnvImpstyle' );
    wp_enqueue_script("jquerycookies", plugins_url( 'lib/jquerycookie.js', __FILE__ ) , 'jquery', '',true);
	wp_enqueue_script( 'qtEnvImpscript', plugins_url( 'lib/main.js', __FILE__ ),'jquery' , '1.0.0',true);
    wp_enqueue_script( 'qtEnvImpscript', plugins_url( 'lib/thickbox-hijack.js', __FILE__ ),'jquery' , '1.0.0',true);
    wp_localize_script( 'qtEnvImpscript', 'qtEnvImpscript', array(
        'ajaxurl' =>  plugins_url( 'lib/main.js', __FILE__ ),
        'nonce' => wp_create_nonce( 'qtEnvImpscript-nonce' )
    ) );
     echo '<script type="text/javascript">
        window.QTBPIserviceUrl   = "'.LOADURLENVI.'"; 
    </script>';  
}



/* = Create the admin page
==========================================================================*/

add_action('admin_menu', 'qtEnvImp_create_optionspage');
function qtEnvImp_create_optionspage() {
	add_management_page('QT Envato Importer', 'QT Envato Importer', 'manage_options', 'qtenvatoimp_settings', 'qtenvatoimp_options');
}

function qtenvatoimp_options(){
    
    if(!isset($_GET['tab'])){
        $_GET['tab'] = 'import';
    }
    qw_admin_tabs($_GET['tab']);

    echo '<div class="qw_importer_container">';
    switch ($_GET['tab']){
        case "settings" :
            include ('settings-form.php');
        break;
        case "stats" :
            include ('user_stats.php');
        break;
        case "verify_purchase" :
            include ('verify_purchase.php');
        break;
        case "import" :
        default:
            include ('action-form.php');
        
    }
    echo '</div>';

}

/* = Create the admin tabs
==========================================================================*/

function qw_admin_tabs( $current) {
    $tabs = array( 'import' => 'Import Envato Items', 
                  'settings' => 'Settings',
                  'stats' => 'Stats',
                  'verify_purchase' => 'Verify Purchase');

    echo '<div id="icon-themes" class="icon32"><br></div>';
    echo '<h2 class="nav-tab-wrapper">';
    foreach( $tabs as $tab => $name ){
        $class = ( $tab == $current ) ? ' nav-tab-active' : '';
        echo "<a class='nav-tab$class' href='?page=qtenvatoimp_settings&tab=$tab'>$name</a>";

    }
    echo '</h2>';
}

/* = Create the widget
==========================================================================*/
include 'frontend/items-widget.php';
if(!function_exists('qw_envatoitem_scripts')){
    function qw_envatoitem_scripts(){
        wp_register_style( 'qt-envitem-style', plugins_url( 'frontend/qw_envatoitems.css', __FILE__ ) , false, '1.0.0' );
        wp_enqueue_style( 'qt-envitem-style' );
    }
}
add_action("wp_enqueue_scripts","qw_envatoitem_scripts");



/* = Create content details
==========================================================================*/
include 'frontend/content_details.php';

