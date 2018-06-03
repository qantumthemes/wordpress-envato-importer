<?php
if(!function_exists('qw_qantumpro_create_form_row')){
function qw_qantumpro_create_form_row($name,$type,$value,$label){
		switch ($type){
					
					case "section":
						return '
							<h1>'.$label.'</h1>';
					break;
					case "text":
						return '
							<p>
								<label for="'.$name.'">'.$label.'</label><br />
								<input type="text" style="width:98%" value="'.$value.'" id="id'.$name.'" name="'.$name.'" />
							</p>
						';
					break;
					case "link":
						return '
							<p>
								<label for="'.$name.'">'.$label.'</label><br />
								<input type="text" style="width:98%" value="'.$value.'" id="id'.$name.'" name="'.$name.'" />
							</p>
						';
					break;
					case "medialink":
						return '
							<p>
								<label for="'.$name.'">'.$label.'</label><br />
								<input type="text" style="width:98%" value="'.$value.'" id="id'.$name.'" name="'.$name.'" />
							</p>
						';
					break;
					case "textarea":
						return '
							<p>
								<label for="'.$name.'">'.$label.'</label>
								<textarea class="widefat" id="id'.$name.'" name="'.$name.'" style="height:80px">'.$value.'</textarea>
							
							</p>
						';
					break;
					
					case 'img':
						return '<p> 
									<label for="'.$name.'">'.$label.'</label><br /> 
									
									<img src="'.$value.'" id="img'.$name.'" style="float:left;width:250px;" />
									<input type="text" id="'.$name.'" style="width:300px" class="uploader_field" name="'.$name.'" value="'.esc_url($value).'" /> 
									<input type="button" class="uploader_element" id="cdog-thickbox'.$name.'" name="'.$name.'"  value="Upload '.$label.'" /><br/> 
									
								</p> <p style="clear:both">&nbsp;</p>';
					;
					case 'file':
						return '<p> 
									<label for="'.$name.'">'.$label.'</label><br /> 
									
									
									<input type="text" id="'.$name.'" style="width:300px" class="uploader_field" name="'.$name.'" value="'.esc_url($value).'" /> 
									<input type="button" class="uploader_element" id="cdog-thickbox'.$name.'" name="'.$name.'"  value="Upload '.$label.'" /><br/> 
									
								</p> ';
					;
					
				}
}}








?>