<?php
$fields=array(
		array('','section','','Details','hide'),
		array('qw_id','text','','Product ID','show'),
		array('qw_item','text','','Product Name','show'),
		array('qw_url','text','','Product Url','hide'),
		array('qw_user','text','','User','hide'),
		array('qw_thumbnail','text','','Image','hide'),
		array('qw_live_preview_video_url','text','','Live Preview Video Url','hide'),
		array('qw_preview_type','text','','Preview type','hide'),
		array('qw_preview_url','text','','Preview url','show'),	
		array('qw_sales','text','','Sales','show'),
		array('qw_rating','text','','Rating','show'),
		array('qw_cost','text','','Cost','show')
	);

global $qw_fieldsItem;
$qw_fieldsItem = $fields;
?>