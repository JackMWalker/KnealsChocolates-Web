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