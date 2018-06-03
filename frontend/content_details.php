<?php
if(!function_exists('qw_envitem_details')){
	function qw_envitem_details($content){
		$html = '';
		wp_reset_postdata();
		wp_reset_query();


		$qwim_displayrating = get_option("qwim_displayrating");
		$qwim_displaylink = get_option("qwim_displaylink");
		$qwim_displayprice = get_option("qwim_displayprice");
		$qwim_displaysales = get_option("qwim_displaysales");
		$qwim_displayname = get_option("qwim_displayname");
		$qwim_displayid = get_option("qwim_displayid");



		if ( is_single() ){
			global $post;
			$id = $post->ID;
	       	if(get_post_type($id) == 'qw-product-item'){
	       		//echo get_post_type( $post -> ID);
	       		global $qw_fieldsItem;

	       		

	       		$type = get_post_meta($id, 'qw_preview_type', true);
	       		$values = array();
	       		foreach ($qw_fieldsItem as $f){
	       			$value = get_post_meta($id, $f[0], true);
	       			if($f[0] != '' && $f[4] == 'show' && $value != ''){
	       				$values[$f[0]] = array('type' => $type,
	       				                       'name' => $f[3],
	       										'value' => $value);
	       			}
	       		}


	       		$html = '';

	       		foreach ($values as $fieldId => $val){
	       		
	       				if($fieldId == 'qw_preview_url') {
							switch ($val['type']){
								case 'audio':
									$val['value'] = '[audio src="'.$val['value'].'"]';
								break;

							}
						}


						if($fieldId == 'qw_cost') {
							if($qwim_displayprice != 'on'){
								continue;
							}
							$val['value'] = $val['value'].'$';
						}

						if($fieldId == 'qw_rating') {
							if($qwim_displayrating != 'on'){
								continue;
							}
						}


						if($fieldId == 'qw_id') {
							if($qwim_displayid != 'on'){
								continue;
							}
						}

						if($fieldId == 'qw_item') {
							if($qwim_displayname != 'on'){
								continue;
							}
						}

						if($fieldId == 'qw_sales') {
							if($qwim_displaysales != 'on'){
								continue;
							}
						}


	       				
       					$html .= '	<tr>
       									<th>'.$val['name'].'</th>
       									<td>'.$val['value'].'</td>
       								</tr>';
	       				
	       			
	       		}

	       		if($qwim_displaylink == 'on'){
	       			$html .= '	
	       			<tr>
						<th>Download</th>
						<td><a href="'.get_post_meta($id, 'qw_url', true).'?ref='.get_option('qwim_envatousername').'" target="_blank" rel="external nofollow">Download '.get_post_meta($id, 'qw_item', true).'</a></td>
					</tr>';
				}

	       	}
	       	 
	    


	    // Returns the content.


	    if($qwim_displaylink == 'on'){
	    	$html .= '<a href="'.get_post_meta($id, 'qw_url', true).'?ref='.get_option('qwim_envatousername').'" target="_blank" class="qw-buy-button btn btn-primary btn-xl" rel="external nofollow">Buy this product</a>';
	    }


	    $html = '
	    		<table class="qw-item-details">'.$html.'</table>'
	    		.'<img src="'.get_post_meta($id, 'qw_thumbnail', true).'" class="qw_itemthumb" align="left" alt="'.get_post_meta($id, 'qw_item', true).'">';

	    }
	    return $html.$content;
	    wp_reset_postdata();
		wp_reset_query();
	}
}
add_filter( 'the_content', 'qw_envitem_details' );

?>
