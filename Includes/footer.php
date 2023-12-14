<footer class="footer bg-dark text-center text-white mt-auto">
    <!-- Grid container -->
    <div class="container py-2 mt-auto">

        <section>
            <a class="btn text-light px-0 fs-5" href="https://thesun.my/">Home</a>
            <span class="text-secondary fs-5">|</span>
            <a class="btn text-light px-0 fs-5" href="https://thesun.my/services/contact-us">Contact Us</a>
            <span class="text-secondary fs-5">|</span>
            <a class="btn text-light px-0 fs-5" href="https://thesun.my/services/rss-the-sun">RSS</a>
            <span class="text-secondary fs-5">|</span>
            <a class="btn text-light px-0 fs-5" href="https://thesun.my/archive">Archive</a>
            <span class="text-secondary fs-5">|</span>
            <a class="btn text-light px-0 fs-5" href="https://thesun.my/services/advertise-with-us">Advertise With Us</a>
            <span class="text-secondary fs-5">|</span>
            <a class="btn text-light px-0 fs-5" href="https://thesun.my/services/privacy-policy">Privacy Policy</a>

        </section>

    </div>
    <!-- Grid container -->
    <div class="text-center p-1" style="background-color: rgba(0, 0, 0, 0.2);">
        <section>
            <!-- Facebook -->
            <a class="btn btn-outline-light btn-floating m-1" href="https://www.facebook.com/thesundaily" role="button"><i class="bi bi-facebook"></i></a>

            <!-- Twitter -->
            <a class="btn btn-outline-light btn-floating m-1" href="https://twitter.com/thesundaily" role="button"><i class="bi bi-twitter-x"></i></a>

            <!-- Google -->
            <a class="btn btn-outline-light btn-floating m-1" href="https://www.instagram.com/thesundaily/" role="button"><i class="bi bi-instagram"></i></a>

            <!-- Instagram -->
            <a class="btn btn-outline-light btn-floating m-1" href="https://www.youtube.com/channel/UCJNLiW1NkgyHeoijxH-a_Wg" role="button"><i class="bi bi-youtube"></i></a>

            <!-- Linkedin -->
            <a class="btn btn-outline-light btn-floating m-1" href="https://www.tiktok.com/@thesundaily?lang=en" role="button"><i class="bi bi-tiktok"></i></a>

            <!-- Github -->
            <a class="btn btn-outline-light btn-floating m-1" href="https://t.me/thesuntelegram" role="button"><i class="bi bi-telegram"></i></a>

            <a class="btn btn-outline-light btn-floating m-1" href="https://ipaper.thesundaily.my/epaper/viewer.aspx?publication=The%20Sun%20Daily" role="button">
                <img src="https://www.thesundaily.my/base-portlet/webrsrc/theme/5d54942b1f61e0b83545fbac4d992dab.png" class="bi" width="24" height="24" alt="Custom Image">
            </a>
        </section>

        <div class="w-50 m-auto">
            <br>
            SUN MEDIA CORPORATION SDN BHD (221220-K)
            Level 4, Lot 6 Jalan 51/217,46050 Petaling Jaya, Selangor,Malaysia
            <br><br>
            Tel: +603-7784 6688 Fax: +603-7785 2624 / +603-7785 2625
            <br>
            Copyright © 2023 Sun Media Corporation Sdn. Bhd. All rights reserved.
            <br>
            <span class=" " style="font-size:10px;">By Teoh & Ausca</span>

        </div>
    </div>
    <!-- Copyright -->
</footer>

<!--Footer-->



<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    var btn = $('#buttonUp');

    $(window).scroll(function() {
        if ($(window).scrollTop() > 300) {
            btn.addClass('show');
        } else {
            btn.removeClass('show');
        }
    });

    btn.on('click', function(e) {
        e.preventDefault();
        $('html, body').animate({
            scrollTop: 0
        }, '300');
    });
</script>


<?php
if (!empty($_GET['modalID'])) {
    $open = $_GET['modalID'];
?>

    <script>
        var myModal = new bootstrap.Modal(document.getElementById("<?= $open ?>"));
        myModal.show();
    </script>

<?php
}
?>


<script>
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
</script>

<script src="JS/loading.js"></script>
<script src="JS/request.js"></script>
<script src="JS/navbar.js"></script>




<!--Created by © Ausca Lai 2023 & © Teoh Yo Wen 2023 -->