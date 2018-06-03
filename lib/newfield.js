// JavaScript Document
jQuery(document).ready(function()  
{  
	
	
	jQuery('a.repeatable-add').click(function(e) {
		
		e.preventDefault();

		var fieltToRepeat = jQuery(this).prev('div');
		
		var newfield = fieltToRepeat.clone(true);

		
		jQuery.each(newfield.find('input'), function(i, val) {
		  
		  var that =  jQuery(this);
		  var name 		= that.attr("name");
		  var count 	= name.replace(/\D+/, '');
		  var newCount 	= count++;
		  
		  that.attr('id',that.attr('id')+i);
		  console.log(that.attr('id'));
		  
		});
		
		
		
		//jQuery().val('');
		
		/*.val('').attr('name', function(index, name) {
			return name.replace(/(\d+)/, function(fullMatch, n) {
				return Number(n) + 1;
			});
		})*/
		
		
		fieltToRepeat.after(newfield);
		
		
		console.log (fieltToRepeat.attr('data-name'));
		
		/*
		
		field.insertAfter(fieldLocation, jQuery(this).closest('td'))
		*/
		//return false;
	});
	jQuery('.repeatable-remove').click(function(){
		jQuery(this).parent().remove();
		return false;
	});
	jQuery('.custom_repeatable').sortable({
		opacity: 0.6,
		revert: true,
		cursor: 'move',
		handle: '.sort'
	});
});