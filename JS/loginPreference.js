
    function setCookie(name, value, days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + value + expires + "; path=/";
    }

    // Get the checkbox and the login section
    const chk = document.getElementById("chk");
    const loginSection = document.querySelector(".login");

    // Check if there's a saved preference in cookies
    function getCookie(name) {
        var nameEQ = name + "=";
        var cookies = document.cookie.split(";");
        for (var i = 0; i < cookies.length; i++) {
            var cookie = cookies[i];
            while (cookie.charAt(0) == " ") {
                cookie = cookie.substring(1, cookie.length);
            }
            if (cookie.indexOf(nameEQ) == 0) {
                return cookie.substring(nameEQ.length, cookie.length);
            }
        }
        return null;
    }

    var loginPreference = getCookie("loginPreference");
    if (loginPreference === "true") {
        chk.checked = true;
        loginSection.style.transform = "translateY(-500px)";
    }

    // Listen for changes in the checkbox state
    chk.addEventListener("change", function () {
        if (chk.checked) {
            // User prefers login section
            loginSection.style.transform = "translateY(-500px)";
            setCookie("loginPreference", "true", 30); // Set the cookie to expire in 30 days
        } else {
            // User prefers signup section
            loginSection.style.transform = "translateY(-180px)";
            setCookie("loginPreference", "false", 30);
        }
    });