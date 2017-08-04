// When DOM is fully loaded
jQuery(document).ready(function($) {

	initialise();

	/*---------------------------------------------*/
	/*        Shows the burger style menu          */
	/*---------------------------------------------*/
	(function() {
		$('.navbar-toggle').click(function(e) {
			e.stopPropagation();
			var burger_menu = $('.navbar-nav');

			if(burger_menu.hasClass('collapse'))
			{
				burger_menu.slideDown(300);
				burger_menu.addClass('active');
				burger_menu.removeClass('collapse');
			}
			else
			{
				if($('.dropdown-menu.active').length)
				{
					$('.dropdown-menu.active').slideUp(200, function() {
						$('.dropdown-menu').removeClass('active');
						burger_menu.slideUp(300, function(){
							burger_menu.addClass('collapse');
							burger_menu.removeClass('active');
							burger_menu.removeAttr("style");
						});
					});
				}
				else
				{
					burger_menu.slideUp(300, function() {
						burger_menu.addClass('collapse');
						burger_menu.removeClass('active');
						burger_menu.removeAttr("style");
					});
				}
			}	
		});
	})();

	// Fancy Script
	$(function() {
		$("a[rel=gallery]").fancybox({
						'transitionIn'		: 'elastic',
						'transitionOut'		: 'elastic',
						'titlePosition' 	: 'over',
						'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
							return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
						}
		});
					
		$("a#singleimg").fancybox({
						//'overlayShow'	: false,
						'transitionIn'	: 'elastic',
						'transitionOut'	: 'elastic'
		});
	});

	/*---------------------------------------------*/
	/*            Cart Functionality               */
	/*---------------------------------------------*/

	    /* Add to Cart button */
	$("button[name='add-to-cart']").click(function(e) { 
		var selection = "";
		//var pId = $("input[name='product_id']").val();
		var pId = $(this).data('product_id');

		if($(".bar-menu").length)
		{
			$(".bar-menu").each(function() {
				selection += $(this).val() + ",";
			});
			selection = selection.slice(0, -1);
		}
		
		var vars = "pid="+pId+"&qty=1&slct="+selection;

	    $.ajax({
			type: "POST",
			url: "../basket/inc/cart_header.php",
			data: vars,
			dataType: "json", 
			success: function(result){    
				$(".cart-num").html(result.count);
			}
		});
	});

}); /* End of the ready function */

/*------------------------------------------*/
/*              Cart Functions              */
/*------------------------------------------*/

/* Used to initially load the cart with no parameters sent */
function loadCart() {
$.ajax({
	type: "POST",
	url: "../basket/inc/cart_display.php",
	dataType: "json",
	success: function(result){   
		$("#update-form").html(result.table);
		$(".cart-num").html(result.count);
		$("#payment_form").html(result.paypal);
		initialise(); // this initalises all of the mouse and keyboard listeners created below
	}
});
}

/* This sets the update (quantity) buttons' visibility */
function setUpdateVisible() {
	$("input[name='update-qty']").each(function() {
		if($(this).data("visible") == "yes"){
			$(this).css("display","block");
		}else{
			$(this).css("display","none");
		}
	});
}

/* sets the params ready show visible when setUpdateVisible is called */
function setUpdateReadyForVisible(cid) {
	var updateID = $("table").find("[data-updatecartid='" + cid + "']");
	updateID.data("visible", "yes");
	setUpdateVisible();
}

/* Update the quantity shown within the cart for each product individually */
function updateQuantity(cid) {
	var qtyinput = $("table").find("[data-qtycartid='" + cid + "']");
	if(qtyinput.val() == ""){
		$(".enter-number-warning").css("display","inline-block");
		return;
	}
	var visible = [];
	$("input[name='update-qty']").each(function() {
		var thisID = $(this).data("updatecartid"); 
		visible[thisID] = ($(this).data("visible"));
	});
	var quantArr = [];
	$("input[name='quantity[]']").each(function() {
		var thisID = $(this).data("qtycartid"); 
		quantArr[thisID] = $(this).val();
	});
	var origqty = qtyinput.data("origqty");
	var qty = qtyinput.val() - origqty;


	var vars = {'cid':cid, 'qty':qty, 'visible': visible, 'quantArr':quantArr};

    $.ajax({
		type: "POST",
		url: "../basket/inc/cart_display.php",
		data: vars,
		dataType: "json",
		success: function(result){   
			$("#update-form").html(result.table);
			$(".cart-num").html(result.count);
			$("#payment_form").html(result.paypal);

			setUpdateVisible();
			initialise(); // calling initialise means that the .click(function(){ listeners are in place again
		}
	});
}

/* Removes the particular item out of the cart */
function removeItem(pid, cid) {
	var vars = "productID="+pid+"&cartID="+cid;

	$.ajax({
		type: "POST",
		url: "../basket/inc/cart_display.php",
		data: vars,
		dataType: "json",
		success: function(result){   
			$("#update-form").html(result.table);
			$(".cart-num").html(result.count);
			$("#payment_form").html(result.paypal);
			initialise();// calling initialise means that the .click(function(){ listeners are in place again
		}
	});
}

/*--------------------------------------------------------------------------*/
/*    Initialise the click event listeners which call the cart functions    */
/*--------------------------------------------------------------------------*/

function initialise() {

	$("input[name='quantity[]']").click(function(e) {
		var cid = $(this).data("qtycartid");
		setUpdateReadyForVisible(cid);
	});

	$("input[name='quantity[]']").keypress(function(e) {
		var pid = $(this).data("qtyproductid"); 
		var cid = $(this).data("qtycartid");
		if(e.which == 13){ //shows what will happen when the user presses the enter button
			e.preventDefault();
			updateQuantity(cid);
		}
		setUpdateReadyForVisible(cid);
	});

	$("input[name='update-qty']").click(function(e) { 
		e.preventDefault();
		var cid = $(this).data("updatecartid"); 
		updateQuantity(cid);
	});

	$("input[name='remove-item']").click(function(e) {
		e.preventDefault();
		var pid = $(this).data("removeproductid");
		var cid = $(this).data("cartid");
		removeItem(pid, cid);
	});

	$("#show-vat-button").click(function(e) {
		showVat();
	});
}