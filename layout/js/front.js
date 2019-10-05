$(function(){
	"use strict";
//////////////switch betwwon login and signup//
	$('.login-page h1 span').click(function(){
		$(this).addClass('selected').siblings().removeClass('selected');
		$('.login-page form').hide();
		$('.'+ $(this).data('class')).fadeIn(100);
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
	
	/////////////// delete confermation//////////
	$('.confirm').click(function(){

		return confirm('Are you sure?');
	});
///////////////////add ads/////////////////////live-Description
$('.live-name').keyup(function(){
	$('.live-preview .caption h3').text($(this).val());
});

$('.live-Description').keyup(function(){
	$('.live-preview .caption p').text($(this).val());
});
$('.live-price').keyup(function(){
	$('.live-preview  .price-tag').text('$'+$(this).val());
});

});