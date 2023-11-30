var nav = $('#topnav'); // Assuming you have a nav with the ID 'topnav'
var navImg = $('#topnav'); // Assuming you have a nav with the ID 'topnav'
var BtmImg = $('#BtmNavImg')
var BtmNav = $('#BtmNav')
var specificWidth = 768; // Set your specific width here




    function checkScreenWidth() {
        if ($(window).width() > specificWidth) {
            nav.addClass('show');
            BtmImg.addClass('hide');
        } else {
            nav.removeClass('show');
            BtmImg.removeClass('hide');
        }
    }

    // Call the function on page load
    checkScreenWidth();

    // Check the screen width on window resize
    $(window).resize(function() {
        checkScreenWidth();
    });


    
    $(window).scroll(function() {
        if ($(window).scrollTop() > 100) {
            BtmNav.addClass('fixed-top');
            BtmImg.removeClass('hide');
        } else {
            BtmNav.removeClass('fixed-top');
            
        }
    });

