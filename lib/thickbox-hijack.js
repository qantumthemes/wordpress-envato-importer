jQuery(document).ready(function()  
{  

    var ogfield = null;  
    jQuery( '.uploader_element' ).click(function()  
    {  
		ogfield = jQuery( this ).prev().attr( 'name' );  
		
		tb_show( '', 'media-upload.php?type=image&TB_iframe=true' );  
    });  

	
		
	window.send_to_editor_old = window.send_to_editor;  
	window.send_to_editor = function( html )
	{  
		if( ogfield != null )  
		{ 
				var fileurl = jQuery(html);
				var filename = jQuery(fileurl).attr('href');
				var extension = filename.substr( (filename.lastIndexOf('.') +1) );
				
				switch(extension) {
					case 'JPEG':
					case 'jpeg':
					case 'JPG':
						case 'jpg':
						case 'png':
						case 'gif':
					case 'GIF':
						jQuery( 'img#img'+ogfield ).attr('src',filename);
						break; 
					case 'zip':
					case 'rar':
					case 'pdf':
						break;
					default:
				}
			
				jQuery( 'input#'+ogfield ).val( filename );  
				ogfield = null;
				tb_remove(); 
		}else{
			window.send_to_editor_old( html );  
		}
	} 
	
	return false;  
	
}); 