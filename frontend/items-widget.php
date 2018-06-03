<?php
/**
* Envato Items Widget
*/
add_action( 'widgets_init', 'qw_items_widget' );
function qw_items_widget() {
	register_widget( 'Qw_Items_Widget' );
}

class Qw_Items_Widget extends WP_Widget {
	function __construct() {
		$widget_ops = array( 'classname' => 'qwitemswidget', 'description' => __('A widget that displays items ', 'qwitemswidget') );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'qwitemswidget-widget' );
		parent::__construct( 'qwitemswidget-widget', __('QantumThemes Envato Items', 'qwitemswidget'), $widget_ops, $control_ops );
	}
	function widget( $args, $instance ) {
		extract( $args );
		echo $before_widget;
		echo $before_title.$instance['title'].$after_title; 
		$query = new WP_Query();

		//Send our widget options to the query
		
		$queryArray =  array(
			'post_type' => 'qw-product-item',
			'posts_per_page' => $instance['number'],
			'ignore_sticky_posts' => 1,
			'order' => 'ASC'
		   );
		
		if($instance['specificid'] != ''){
			$posts = explode(',',$instance['specificid']);
			$finalarr = array();
			foreach($posts as $p){
				if(is_numeric($p)){
					$finalarr[] = $p;
				}
			};
			$queryArray['post__in'] = $finalarr;
		}
		
		$queryArray['orderby'] = 'menu_order';
		if($instance['order'] == 'Random'){
			$queryArray['orderby'] = 'rand';
		}
		
		//echo get_query_var('posts_per_page');
		$query = new WP_Query($queryArray);
		 ?>
	         <ul class="qw-envato-items">
		         <?php
				if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); 
				global $post;
					?>
		            <li>
		                <a class="qw-blocklink" href="<?php the_permalink(); ?>">
		                	<?php
							if($instance['showcover']=='true'){ 
								?>
			                		<img src="<?php echo get_post_meta($post->ID,'qw_thumbnail',true); ?>" class="qw-widget-thumbnail">
			                	<?php
							}
		                	?>
		               		<span class="qw-widg-singleline"><?php the_title(); ?><br>

		               		</span>
		               		<span class="qw-widg-tags">
		               		<?php
		               		$terms = get_the_terms($post->ID, 'product-category');
		               		if(is_array($terms)){
		               		foreach($terms as $t){
		               			echo $t->name ;
		               			if (next($terms)==true) echo  " / ";
		               		}
		               		}
		               		?>
		               		</span>
		                    <div class="canc"></div>
		                    </a>
		            </li>
		        <?php endwhile; endif; 
		         if(isset($instance['archivelink']) && isset($instance['archivelink_text'])){
					if($instance['archivelink'] == 'show'){
						if($instance['archivelink_text']==''){$instance['archivelink_text'] = 'See all';};
				 	 	echo '<li class="bordertop QTreadmore">
				 	 	<a href="'.get_post_type_archive_link('qw-product-item').'"><i class="icon-chevron-right animated"></i> '.$instance['archivelink_text'].'</a>
				 	 	</li>';
				 	} 
				 }
				?>
	        </ul>
        <?php
        wp_reset_postdata();
		// L'OUTPUT ///////////////////////
		echo $after_widget;
	}




	/*
	*
	* Update the widget 
	*
	*/

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		//Strip tags from title and name to remove HTML 

		$attarray = array(
				'title',
				'showcover',
				'number',
				'specificid',
				'order',
				'archivelink',
				'archivelink_text',
				'itemcat_selector'
		);
		foreach ($attarray as $a){
			$instance[$a] = strip_tags( $new_instance[$a] );
		}
		return $instance;
	}

	function form( $instance ) {
		//Set up some default widget settings.
		$defaults = array( 'title' => __('Items', 'qwitemswidget'),
							'showcover'=> 'true',
							'number'=> '5',
							'specificid'=> '',
							'order'=> 'Random',
							'archivelink'=> 'show',
							'archivelink_text'=> 'See all',
							'itemcat_selector' => 0
							);

		if(!array_key_exists('itemcat_selector',$instance)){
			$instance['itemcat_selector'] = '';
		}

		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
	 	<h2>General options</h2>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', '_s'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
        <p>
			<label for="<?php echo $this->get_field_id( 'specificid' ); ?>"><?php _e('Add only specific items (by post ID, comma separated):', '_s'); ?></label>
			<input id="<?php echo $this->get_field_id( 'specificid' ); ?>" name="<?php echo $this->get_field_name( 'specificid' ); ?>" value="<?php echo $instance['specificid']; ?>" style="width:100%;" />
		</p>
        <p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e('Quantity:', '_s'); ?></label>
			<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" value="<?php echo $instance['number']; ?>" style="width:100%;" />
		</p>
      <p>
		<label for="<?php echo $this->get_field_id( 'showcover' ); ?>"><?php _e('Show cover', '_s'); ?></label><br />			
           True   <input type="radio" name="<?php echo $this->get_field_name( 'showcover' ); ?>" value="true" <?php if($instance['showcover'] == 'true'){ echo ' checked= "checked" '; } ?> />
           False  <input type="radio" name="<?php echo $this->get_field_name( 'showcover' ); ?>" value="false" <?php if($instance['showcover'] == 'false'){ echo ' checked= "checked" '; } ?> />  
		</p>  
      <p>
		<label for="<?php echo $this->get_field_id( 'showcover' ); ?>"><?php _e('Order', '_s'); ?></label><br />			
           Random   <input type="radio" name="<?php echo $this->get_field_name( 'order' ); ?>" value="Random" <?php if($instance['order'] == 'Random'){ echo ' checked= "checked" '; } ?> />  
           Page Order  <input type="radio" name="<?php echo $this->get_field_name( 'order' ); ?>" value="Page Order" <?php if($instance['order'] == 'Page Order'){ echo ' checked= "checked" '; } ?> />  
		</p>  
		<p>
			<label for="<?php echo $this->get_field_id( 'archivelink' ); ?>"><?php _e('Show link to archive', '_s'); ?></label><br />			
           Show   <input type="radio" name="<?php echo $this->get_field_name( 'archivelink' ); ?>" value="show" <?php if($instance['archivelink'] == 'show'){ echo ' checked= "checked" '; } ?> />  
           Hide  <input type="radio" name="<?php echo $this->get_field_name( 'archivelink' ); ?>" value="hide" <?php if($instance['archivelink'] == 'hide'){ echo ' checked= "checked" '; } ?> />  
		</p>
        <p>
			<label for="<?php echo $this->get_field_id( 'archivelink_text' ); ?>"><?php _e('Link text:', '_s'); ?></label>
			<input id="<?php echo $this->get_field_id( 'archivelink_text' ); ?>" name="<?php echo $this->get_field_name( 'archivelink_text' ); ?>" value="<?php echo $instance['archivelink_text']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'itemcat_selector' ); ?>"><?php _e('Category filter:', '_s'); ?></label>
			<?php 
			$args = array(
				'show_option_all'    => 'Any',
				'show_option_none' => __( 'Select category', '_s' ),
				'orderby'            => 'NAME', 
				'order'              => 'ASC',
				'show_count'         => 0,
				'hide_empty'         => 1, 
				'child_of'           => 0,
				'exclude'            => '',
				'echo'               => 1,
				'selected'           => (int)$instance['itemcat_selector'],
				'hierarchical'       => 0, 
				'name'               => $this->get_field_name( 'itemcat_selector' ),
				'id'                 => 'itemcat_selector',
				'class'              => 'postform',
				'depth'              => 0,
				'tab_index'          => 0,
				'taxonomy'           => 'product-category',
				'hide_if_empty'      => true
			); 
			?>
			<?php wp_dropdown_categories( $args ); ?> 
		</p>






	<?php

	}
}


?>