<?php

if(isset($_POST['action']) && isset($_POST['option_page'])){
	if ( 
	    ! isset( $_POST['qwim_settingsform'] ) 
	    || ! wp_verify_nonce( $_POST['qwim_settingsform'], 'qwim_settingsform_update' ) 
	) {

	   print 'Sorry, your nonce did not verify.';
	   exit;

	} else {
		$fields = array("qwim_envatousername",
		                "qwim_apikey",
		                "qwim_pagetemplate",
		                "qwim_displayprice",
		                "qwim_displayrating",
		                "qwim_displaylink",
		                "qwim_displaysales",
		                "qwim_displayname",
		                "qwim_displayid"
		                );

		foreach ( $fields as $a ) {
			if(isset($_POST[$a])){
				update_option($a, sanitize_text_field($_POST[$a]));
			}else{
				update_option($a, "");
			}
		}
	}
}
?>
<h1>QantumThemes Envato Importer Settings</h1>
<form method="post" action="tools.php?page=qtenvatoimp_settings&tab=settings" novalidate="novalidate">


	<input type="hidden" name="option_page" value="QWIM_OPTION">
	<input type="hidden" name="action" value="update">
	<?php wp_referer_field() ?>
	<?php wp_nonce_field('qwim_settingsform_update','qwim_settingsform'); ?>

	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row"><label for="qwim_envatousername">Envato Username</label></th>
				<td><input name="qwim_envatousername" type="text" id="qwim_envatousername" value="<?php echo get_option("qwim_envatousername"); ?>" class="regular-text"></td>
			</tr>
			<tr>
				<th scope="row"><label for="qwim_apikey">Api Key</label></th>
				<td><input name="qwim_apikey" type="text" id="qwim_apikey" value="<?php echo get_option("qwim_apikey"); ?>" class="regular-text"></td>
			</tr>



			<tr>
				<th scope="row"><label for="blogname">Page Template</label></th>
				<td>
					<?php
					$templates = get_page_templates();

		/*			echo '<pre>';
					print_r($templates);
					echo '</pre>';
					echo get_option("qwim_pagetemplate");*/

					?>
					<select name="qwim_pagetemplate" id="qwim_pagetemplate">
						<option name="default">Default</option>
						<?php

							
						   	foreach ( $templates as $template_name => $template_filename ) {
						   		$selected = '';
						   		if(get_option("qwim_pagetemplate") == $template_filename ) {
						   			$selected = ' selected="selected"';
						   		}
						      	echo ' <option value="'.$template_filename.'" '.$selected.'>'.$template_name.'</option>';
						   	}
						?>
					</select>
				</td>
			</tr>

			<tr>
				<th scope="row"><label for="qwim_displayname">Display item name</label></th>
				<td><input name="qwim_displayname" type="checkbox" id="qwim_displayname" <?php echo ((get_option("qwim_displayname")=='on')? 'checked="checked"':''); ?> class="regular-checkbox"></td>
			</tr>

			<tr>
				<th scope="row"><label for="qwim_displayid">Display item ID</label></th>
				<td><input name="qwim_displayid" type="checkbox" id="qwim_displayid" <?php echo ((get_option("qwim_displayid")=='on')? 'checked="checked"':''); ?> class="regular-checkbox"></td>
			</tr>

			<tr>
				<th scope="row"><label for="qwim_displayprice">Display item price</label></th>
				<td><input name="qwim_displayprice" type="checkbox" id="qwim_displayprice" <?php echo ((get_option("qwim_displayprice")=='on')? 'checked="checked"':''); ?> class="regular-checkbox"></td>
			</tr>
			

			<tr>
				<th scope="row"><label for="qwim_displaysales">Display actual sales count</label></th>
				<td><input name="qwim_displaysales" type="checkbox" id="qwim_displaysales" <?php echo ((get_option("qwim_displaysales")=='on')? 'checked="checked"':''); ?> class="regular-checkbox"></td>
			</tr>

			<tr>
				<th scope="row"><label for="qwim_displayrating">Display rating</label></th>
				<td><input name="qwim_displayrating" type="checkbox" id="qwim_displayrating" <?php echo ((get_option("qwim_displayrating")=='on')? 'checked="checked"':''); ?> class="regular-checkbox"></td>
			</tr>
			<tr>
				<th scope="row"><label for="qwim_displaylink">Display link</label></th>
				<td><input name="qwim_displaylink" type="checkbox" id="qwim_displaylink" <?php echo ((get_option("qwim_displaylink")=='on')? 'checked="checked"':''); ?> class="regular-checkbox"></td>
			</tr>
		</tbody>
	</table>


	<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>
</form>