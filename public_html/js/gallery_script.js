function preload(arrayOfImages) {
    $(arrayOfImages).each(function(){
        $('<img/>')[0].src = this;
        // Alternatively you could use:
        // (new Image()).src = this;
    });
}
preload([
    '/images/chocolates/large/1.jpg',
    '/images/chocolates/large/2.jpg',
    '/images/chocolates/large/3.jpg',
    '/images/chocolates/large/4.jpg',
    '/images/chocolates/large/5.jpg',
    '/images/chocolates/large/6.jpg',
    '/images/chocolates/large/7.jpg',
    '/images/chocolates/large/8.jpg',
    '/images/chocolates/large/9.jpg',
    '/images/chocolates/large/10.jpg',
    '/images/chocolates/large/11.jpg',
    '/images/chocolates/large/12.jpg',
    '/images/chocolates/large/13.jpg',
    '/images/chocolates/large/14.jpg',
    '/images/chocolates/large/15.jpg',
    '/images/chocolates/large/16.jpg',
    '/images/chocolates/large/17.jpg',
    '/images/chocolates/large/18.jpg',
    '/images/chocolates/large/19.jpg',
    '/images/chocolates/large/20.jpg',
    '/images/chocolates/large/21.jpg',
    '/images/chocolates/large/22.jpg',
    '/images/chocolates/large/23.jpg'
]);

$(function(){
	$('.thumbnail-image').click(function(){
	var source = '/images/chocolates/large/';
	var imageID = $(this).attr('id');
	var imageURL = source + imageID + '.jpg';
	var largeImageURL = $('#large-image').attr("src");
	if(largeImageURL == imageURL){
		return;
	}else{
		$('#large-image').fadeOut(200);
		setTimeout(function(){
		  $('#large-image').attr("src", imageURL);
		  $('#singleimg').attr("href", imageURL);
		}, 200);
		$('#large-image').fadeIn(200);
	}
	});
});