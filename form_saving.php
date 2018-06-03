<?php


if(!function_exists('qantumpro_save_form_row')){

function qantumpro_save_form_row($name,$type,$value,$label,$id){

		
		if( isset( $_POST[$name] ) ){

			switch ($type){

				case 'text':

					$val =  esc_attr( strip_tags( $_POST[$name] ) );

				break;

				case 'link':

					$val =  esc_attr( strip_tags( $_POST[$name] ) );

				break;

				case 'medialink':

					$val =  esc_attr( strip_tags( $_POST[$name] ) );

				break;

				case 'textarea':

					$val =  wp_kses( strip_tags( $_POST[$name] ), $allowed );

				break;

				case 'file':

					$val =  esc_url( strip_tags( $_POST[$name] ) , array( 'http' )  );

				break;

				case 'img':

					$val =  esc_url( strip_tags( $_POST[$name] ) , array( 'http' )  );

				break;

			}

			update_post_meta( $id,$name,$val  );

		}

}}



	

?>