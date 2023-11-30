var navtop = $('#topnav'); // Assuming you have a nav with the ID 'topnav'
var navImg = $('#topnav'); // Assuming you have a nav with the ID 'topnav'
var BtmImg = $('#BtmNavImg');
var BtmNav = $('#BtmNav');
var specificWidth = 768; // Set your specific width here


// Function to handle scroll and resize events
function handleScrollAndResize() {

    if ($(window).width() > specificWidth && $(window).scrollTop() < 100) {
        navtop.addClass('show');
        BtmImg.addClass('hide');
        BtmNav.removeClass('fixed-top');
    } else if ($(window).width() > specificWidth) {
        navtop.removeClass('show');
        BtmImg.removeClass('hide');
        BtmNav.addClass('fixed-top');
    } else {
        navtop.removeClass('show');
        BtmImg.removeClass('hide');
        BtmNav.addClass('fixed-top');
    }
}


// Initial call on page load
handleScrollAndResize();

// Scroll and Resize event handlers
$(window).on('scroll resize', function() {
    handleScrollAndResize();
});
