<?php



function qw_urlToRequest($url,$marketplace){

	$urlarray = explode("?",$url);
	$url = $url[0];

	//http://themeforest.net/collections/4551957-free-files-of-the-month
	$markets = array("http://themeforest.net/",
	                 "http://codecanyon.net/",
	                 "http://videohive.net/",
	                 "http://audiojungle.net/",
	                 "http://graphicriver.net/",
	                 "http://photodune.net/",
	                 "http://3docean.net/",
	                 "http://activeden.net/"

	                 );


	
	$url = str_replace($markets,'',trim($_GET['Url']));
	$url_array	= explode('/', $url);

	$type 		= $url_array[0];

	$id_dirty 		= $url_array[1];
	$idArray = explode("-",$id_dirty);
	$id = $idArray[0];



	$data = false;//just in case 

	$parameters = array();
	switch ($type){
		case "collections":
			/*$parameters = array(
	             'id'=>$id
	         );*/
			$requestString = 'collection:'.$id.'.json';
			break;

		case "item":
			/*$parameters = array(
	             'facets'=>'performerId:'.$id,
	             'perPage'=>'1000'
	         );*/
			$requestString = 'item:'.$url_array[2].'.json';
			break;
		case "user":

		/*	$parameters = array(
	             'facets'=>'labelId:'.$id,
	             'perPage'=>'500'
	        );*/
	        $requestString = 'new-files-from-user:'.$id.','.$marketplace.'.json';
			
			break;
		break;
			default:
			return false;
	}
	return $requestString;
}

?>