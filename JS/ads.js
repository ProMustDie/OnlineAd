var AdA = $('#AdContainerA');
var AdB = $('#AdContainerB');


var specificWidth = 608; // Set your specific width here


// Function to handle scroll and resize events
function handleResize() {

    if ($(window).width() > specificWidth) {
        AdA.addClass('bigAd');
        AdA.removeClass('smallAd');
        AdB.addClass('bigAd');
        AdB.removeClass('smallAd');
    }else{
        AdA.removeClass('bigAd');
        AdA.addClass('smallAd');
        AdB.removeClass('bigAd');
        AdB.addClass('smallAd');
        }

}

// Initial call on page load
handleResize();

// Scroll and Resize event handlers
$(window).on('scroll resize', function() {
    handleResize();
});
