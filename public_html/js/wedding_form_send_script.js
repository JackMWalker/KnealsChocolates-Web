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

	var comment=$("input#comments").val(); 
	var dataString = {"type":type, "name":name, "email":email, "form_postcode":postcode, "phone":phone, "doe":doe, "comments":comment};
if(ValidateEmail(email)){
	$.ajax({  
  type: "POST",  
  url: "/js/wedding_email.php",  
  data: dataString,  
  success: function(html) {  
    $('#form').html(html);
  }  
});  
return false; 
}
}	