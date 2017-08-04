function submit_form(){	
		$('.hidden').hide();
		var title=$("input#ptitle").val();
			if(title==""){
				$("#title_error").show();
				$("input#ptitle").focus();
				return false;
			}
			
		$('.hidden').hide();
		var price=$("input#pprice").val();
			if(price==""){
				$("#price_error").show();
				$("input#pprice").focus();
				return false;
			}
			
		$('.hidden').hide();
		var weight=$("input#weight").val();
			if(weight==""){
				$("#weight_error").show();
				$("input#weight").focus();
				return false;
			}
			
		$('.hidden').hide();
		var allergy=$("input#allergy").val();
			if(allergy==""){
				$("#allergy_error").show();
				$("input#allergy").focus();
				return false;
			}
			
		$('.hidden').hide();
		var desc=$("input#description").val();
			if(desc==""){
				$("#desc_error").show();
				$("input#description").focus();
				return false;
			}
			
		$('.hidden').hide();
		var fileField=$("input#fileField").val();
			if(fileField==""){
				$("#img_error").show();
				$("input#fileField").focus();
				return false;
			}	
		return true;	
}

function submit_calendar_form(){
	$('.hidden').hide();
		var title=$("input#event_title").val();
			if(title==""){
				$("#title_error").show();
				$("input#event_title").focus();
				return false;
			}
			
	$('.hidden').hide();
		var desc=$("input#event_desc").val();
			if(desc==""){
				$("#desc_error").show();
				$("input#event_desc").focus();
				return false;
			}
	
	$('.hidden').hide();
		var date=$("input#event_date").val();
			if(date==""){
				$("#date_error").show();
				$("input#event_date").focus();
				return false;
			}
	
	$('.hidden').hide();
		var address=$("input#event_address").val();
			if(address==""){
				$("#address_error").show();
				$("input#event_address").focus();
				return false;
			}
		return true;
}

function edit_submit_form(){	
		$('.hidden').hide();
		var title=$("input#ptitle").val();
			if(title==""){
				$("#title_error").show();
				$("input#ptitle").focus();
				return false;
			}
			
		$('.hidden').hide();
		var price=$("input#pprice").val();
			if(price==""){
				$("#price_error").show();
				$("input#pprice").focus();
				return false;
			}
			
		$('.hidden').hide();
		var weight=$("input#weight").val();
			if(weight==""){
				$("#weight_error").show();
				$("input#weight").focus();
				return false;
			}
			
		$('.hidden').hide();
		var allergy=$("input#allergy").val();
			if(allergy==""){
				$("#allergy_error").show();
				$("input#allergy").focus();
				return false;
			}
			
		$('.hidden').hide();
		var desc=$("input#description").val();
			if(desc==""){
				$("#desc_error").show();
				$("input#description").focus();
				return false;
			}
			
		return true;	
}