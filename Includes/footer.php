<footer class="footer bg-dark text-center text-white mt-auto">
    <!-- Grid container -->
    <div class="container py-2 mt-auto">
        <!-- Section: Social media -->
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
        <!-- Section: Social media -->
    </div>
    <!-- Grid container -->

    <!-- Copyright -->
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
        © 2020 Copyright:
        <a class="text-white" href="https://mdbootstrap.com/">MDBootstrap.com</a>
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