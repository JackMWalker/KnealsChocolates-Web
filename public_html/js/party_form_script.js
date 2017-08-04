function displayAmount(){
var cboxes = document.getElementsByName('gift[]');
var num = document.getElementsByClassName('amount[]');

	for(var i=0; i<cboxes.length; i++){
		if(cboxes[i].checked){
			num[i].style.display = "block";
		}else if(!cboxes[i].checked){
			num[i].style.display = "none";
		}
	}
}
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
function check_postcode(){
	var pc = $("#postcode").val();
	var vars = "fromPC="+pc;
	$.ajax({
		type: "POST",
		url: "/inc/uk_postcodes.php",
		data: vars,
		success: function(html){
			$("#result").hide().html(html).fadeIn(150);
		}
		
		});
}

function ValidateEmail(inputText)  
{  
	var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;  
	if(inputText.match(mailformat))  
	{   
		return true;  
	}  
	else  
	{  
		alert("You have entered an invalid email address.");  
		$("input#email").focus(); 
		return false;  
	}  
}  

function submit_form(){	
		$('.hidden').hide();
		var name=$("input#name").val();
			if(name==""){
				$("#name_error").show();
				$("input#name").focus();
				return false;
			}
			
		$('.hidden').hide();
		var email=$("input#email").val();
			if(email==""){
				$("#email_error").show();
				$("input#email").focus();
				return false;
			}
			
		$('.hidden').hide();
		var postcode=$("input#form_postcode").val();
			if(postcode==""){
				$("#postcode_error").show();
				$("input#form_postcode").focus();
				return false;
			}
			
		$('.hidden').hide();
		var phone=$("input#phone").val();
			if(phone==""){
				$("#phone_error").show();
				$("input#phone").focus();
				return false;
			}	
		
		$('.hidden').hide();
		var doe=$("input#doe").val();
			if(doe==""){
				$("#date_error").show();
				$("input#doe").focus();
				return false;
			}	
		
		$('.hidden').hide();
		var address1=$("input#address1").val();
			if(address1==""){
				$("#address1_error").show();
				$("input#address1").focus();
				return false;
			}	
		
		$('.hidden').hide();
		var city=$("input#city").val();
			if(city==""){
				$("#city_error").show();
				$("input#city").focus();
				return false;
			}	

	var comment=$("input#comments").val(); 
	var address2=$("input#address2").val();
	var dataString = {"name":name, "email":email, "form_postcode":postcode, "phone":phone, "doe":doe, "address1":address1, "address2":address2, "city":city, "comments":comment};
	if(ValidateEmail(email)) {
		$.ajax({  
		  type: "POST",  
		  url: "/js/party_email.php",  
		  data: dataString,  
		  success: function(html) {  
		    $('#form').html(html);
		  }
		});  
		return false; 
	}
}	