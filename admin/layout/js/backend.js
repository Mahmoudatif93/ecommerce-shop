$(function(){
	"use strict";

	///////////Dashboard
	$('.toggle-info').click(function(){
		$(this).toggleClass('selected').parent().next('.card-body').fadeToggle(200);
		if ($(this).hasClass('selected')) {
			$(this).html('<i class="fa fa-minus fa-lg"></i>');
		}else{
			$(this).html('<i class="fa fa-plus fa-lg"></i>');}
		

	});
	///////////////Trigger the selectboxit//////////////
	$("select").selectBoxIt({
		autoWidth: false

	});
	//hide placeholder on form focus
	$('[placeholder]').focus(function(){

		$(this).attr('data-text',$(this).attr('placeholder'));
		$(this).attr('placeholder','');
	}).blur(function(){
		$(this).attr('placeholder',$(this).attr('data-text'));

	});



	//add asterix on required field
		$('input').each(function(){
		if ($(this).attr('required')==='required') {
			$(this).after('<span class="asterix" >*</span>');
		}

		
	});
	////////////////////////convert pass field to text on hover/////
		var passField=$('.password');
	$('.show-pass').hover(function(){
		passField.attr('type','text');


	},function(){
	passField.attr('type','password');
	});

	/////////////// delete confermation//////////
	$('.confirm').click(function(){

		return confirm('Are you sure?');
	});

////////////category show options
$('.cat h3').click(function(){
	$(this).next('.full-view').fadeToggle(200);
});
$('.option span').click(function(){
	$(this).addClass('active').siblings('span').removeClass('active');
	if ($(this).data('view')=='Full') {
		$('.cat .full-view').fadeIn(200);
	}else{

				$('.cat .full-view').fadeOut(200);

	}
});




/////////show delete button on child category
$('.child-cat').hover(function(){

	$(this).find('.show-delete').fadeIn(400);
},function(){
	$(this).find('.show-delete').fadeOut(300);

});


/////////////////


});






