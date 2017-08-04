// When DOM is fully loaded
jQuery(document).ready(function($) {

/* change the stock on an individual product */
$(".stock-mod").click(change_stock);

$(".priority-mod").click(change_priority);

/* Toggle from live to not live on individual product */
$(".toggle-live").click(toggle_live);


function toggle_live()
{
	var _this = $(this);
	var this_id = _this.data("pid");
	var this_live = _this.data("islive");

	var vars = "id="+this_id+"&live="+this_live; 

	$.ajax({
		type: "POST",
		url: "/admin/inc/toggle_live_script.php",
		dataType: "json",
		data: vars,
		success: function(result){   
			if(result){
				_this.toggleClass("active");
				_this.data("islive", result.live);
			}
			else
			{
				$('#notification').html("No variables set");
			}
		}
	});
}


function change_priority()
{
	var this_id = $(this).data("pid");
	var priority_change = $(this).data("change");

	var vars = "id="+this_id+"&priority_change="+priority_change; 

	$.ajax({
		type: "POST",
		url: "/admin/inc/priority_script.php",
		dataType: "html",
		data: vars,
		success: function(result){
			if(result){
				$("#e-p-container").html(result);
				
				$(".stock-mod").click(change_stock);
				$(".priority-mod").click(change_priority);
				$(".toggle-live").click(toggle_live);
			}
			else
			{
				$('#notification').html("No variables set");
			}
		}
	});
}

function change_stock()
{
	var this_id = $(this).data("pid");
	var this_change = $(this).data("change");
	var this_input = $(this).siblings(".stock-value");

	var vars = "id="+this_id+"&change="+this_change; 

	$.ajax({
		type: "POST",
		url: "/admin/inc/stock_script.php",
		dataType: "json",
		data: vars,
		success: function(result){
			if(result)
			{
				this_input.val(result.stock);
			}
			else
			{
				$('#notification').html("No variables set");
			}
		}
	});
}


});
