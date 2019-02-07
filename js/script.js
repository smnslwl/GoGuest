$(window).scroll(function () {
    if ($(window).scrollTop() >= 50) {
        $('.navbar').css('background','#022244');
    } else {
        $('.navbar').css('background','#123456');
    }
});
