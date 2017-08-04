	function initialCalendar(){
    var currentTime = new Date();
	var month = currentTime.getMonth() + 1;
    var year = currentTime.getFullYear();
	showmonth = month;
	showyear = year;
    var vars = "showmonth="+showmonth+"&showyear="+showyear;
    
    $.ajax({
		type: "POST",
		url: "/news/calendar_start.php",
		data: vars,
		success: function(html){
			$("#showCalendar").hide().html(html).fadeIn(500);
		}
		
	});

	}	
	
	function next_month(){
    var nextmonth = showmonth + 1;
	if(nextmonth > 12) {
		nextmonth = 1;
		showyear = showyear + 1;
	}
	showmonth = nextmonth;
	
    var vars = "showmonth="+showmonth+"&showyear="+showyear;
	$.ajax({
		type: "POST",
		url: "/news/calendar_start.php",
		data: vars,
		success: function(html){
			$("#showCalendar").fadeOut(250,function(){
				$(this).html(html).fadeIn(250);
			})
		}
		
	});
	}	

	function last_month(){
    var lastmonth = showmonth - 1;
	if(lastmonth < 1) {
		lastmonth = 12;
		showyear = showyear - 1;
	}
	showmonth = lastmonth;
	
    var vars = "showmonth="+showmonth+"&showyear="+showyear;
    $.ajax({
		type: "POST",
		url: "/news/calendar_start.php",
		data: vars,
		success: function(html){
			$("#showCalendar").fadeOut(250,function(){
				$(this).html(html).fadeIn(250);
			})
		}
		
	});
	}	

	function show_details(theId, today){
	var deets = theId;
	var date = today;
	var vars = "deets="+deets+"&date="+date;
    $.ajax({
		type: "POST",
		url: "/news/event.php",
		data: vars,
		success: function(html){
			$("#event").fadeOut(250,function(){
				$(this).html(html).fadeIn(250);
			})
		}
		
	});
	}