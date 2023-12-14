var navtop = $('#topnav'); // Assuming you have a nav with the ID 'topnav'
var navImg = $('#topnav'); // Assuming you have a nav with the ID 'topnav'
var BtmImg = $('#BtmNavImg');
var BtmNav = $('#BtmNav');
var Space = $('#space');
var AdA = $('#AdContainerA');
var specificWidth = 768; // Set your specific width here
var specificWidthAds = 608; // Set your specific width here

// Function to handle scroll and resize events
function handleScrollAndResize() {

    if ($(window).width() > specificWidth && $(window).scrollTop() < 80) {
        navtop.addClass('show');
        BtmImg.addClass('hide');
        BtmNav.removeClass('fixed-top');
        Space.removeClass('d-block');
        Space.addClass('d-none');
        Space.addClass('big');
        Space.removeClass('small');
    }else{
        navtop.removeClass('show');
        BtmImg.removeClass('hide');
        BtmNav.addClass('fixed-top');
        Space.addClass('d-block');
        Space.removeClass('d-none');

            if($(window).width() > specificWidth && $(window).scrollTop() > 80){
                    Space.addClass('big');
                    Space.removeClass('small');
            }else{
                Space.addClass('small');
                Space.removeClass('big');
            }
        }

        if ($(window).width() > specificWidthAds) {
            AdA.addClass('bigAd');
            AdA.removeClass('smallAd');
    
        }else{
            AdA.removeClass('bigAd');
            AdA.addClass('smallAd');
    
            }

}

// Initial call on page load
handleScrollAndResize();

// Scroll and Resize event handlers
$(window).on('scroll resize', function() {
    handleScrollAndResize();
});
