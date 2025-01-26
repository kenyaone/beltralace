    <!-- Footer Area -->
    <footer id="footer" class="footer ">
        <!-- Footer Top -->
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="single-footer">
                            <h2>HPEW</h2>
                            <p>
                                Supporting the well-being of healthcare professionals through education, resources, and community
                            </p>
                            <!-- Social -->
                            <ul class="social">
                                <li><a href="#"><i class="icofont-facebook"></i></a></li>
                                <li><a href="#"><i class="icofont-google-plus"></i></a></li>
                                <li><a href="#"><i class="icofont-twitter"></i></a></li>
                            </ul>
                            <!-- End Social -->
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="single-footer f-link">
                            <h2>Quick Links</h2>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-12">
                                    <ul>
                                        <li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>Home</a>
                                        </li>
                                        <li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>About Us</a>
                                        </li>
                                        <li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>Services</a>
                                        </li>
                                        <li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>Blog</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <ul>
                                        <li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>Privacy</a>
                                        </li>
                                        <li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>Terms and Conditions</a>
                                        </li>
                                        <li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>FAQs</a>
                                        </li>
                                        <li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>Contact Us</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="single-footer">
                            <h2>Newsletter</h2>
                            <p>Subscribe to our newsletter to get updates</p>
                            <form action="mail/mail.php" method="get" target="_blank" class="newsletter-inner">
                                <input name="email" placeholder="Email Address" class="common-input"
                                    onfocus="this.placeholder = ''" onblur="this.placeholder = 'Your email address'"
                                    required="" type="email">
                                <button class="button"><i class="icofont icofont-paper-plane"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ End Footer Top -->
        <!-- Copyright -->
        <div class="copyright">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="copyright-content">
                            <p>
                                © Copyright <?php echo date('Y'); ?> | HPEW
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ End Copyright -->
    </footer>
    <!--/ End Footer Area -->

    <!-- jquery Min JS -->
    <script data-cfasync="false" src="<?php echo ASSETS; ?>/js/email-decode.min.js"></script>

    <script src="<?php echo ASSETS; ?>/js/jquery.min.js"></script>
    <!-- jquery Migrate JS -->
    <script src="<?php echo ASSETS; ?>/js/jquery-migrate-3.0.0.js"></script>
    <!-- jquery Ui JS -->
    <script src="<?php echo ASSETS; ?>/js/jquery-ui.min.js"></script>
    <!-- Easing JS -->
    <script src="<?php echo ASSETS; ?>/js/easing.js"></script>
    <!-- Color JS -->
    <script src="<?php echo ASSETS; ?>/js/colors.js"></script>
    <!-- Popper JS -->
    <script src="<?php echo ASSETS; ?>/js/popper.min.js"></script>
    <!-- Bootstrap Datepicker JS -->
    <script src="<?php echo ASSETS; ?>/js/bootstrap-datepicker.js"></script>
    <!-- Jquery Nav JS -->
    <script src="<?php echo ASSETS; ?>/js/jquery.nav.js"></script>
    <!-- Slicknav JS -->
    <script src="<?php echo ASSETS; ?>/js/slicknav.min.js"></script>
    <!-- ScrollUp JS -->
    <script src="<?php echo ASSETS; ?>/js/jquery.scrollUp.min.js"></script>
    <!-- Niceselect JS -->
    <script src="<?php echo ASSETS; ?>/js/niceselect.js"></script>
    <!-- Tilt Jquery JS -->
    <script src="<?php echo ASSETS; ?>/js/tilt.jquery.min.js"></script>
    <!-- Owl Carousel JS -->
    <script src="<?php echo ASSETS; ?>/js/owl-carousel.js"></script>
    <!-- counterup JS -->
    <script src="<?php echo ASSETS; ?>/js/jquery.counterup.min.js"></script>
    <!-- Steller JS -->
    <script src="<?php echo ASSETS; ?>/js/steller.js"></script>
    <!-- Wow JS -->
    <script src="<?php echo ASSETS; ?>/js/wow.min.js"></script>
    <!-- Magnific Popup JS -->
    <script src="<?php echo ASSETS; ?>/js/jquery.magnific-popup.min.js"></script>
    <!-- Counter Up CDN JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="<?php echo ASSETS; ?>/js/bootstrap.min.js"></script>
    <!-- Main JS -->
    <script src="<?php echo ASSETS; ?>/js/main.js"></script>

    <script>
        $(document).ready(function(){
            AOS.init();
        })
    </script>
    <script src="<?php echo ASSETS; ?>/node_modules/aos/dist/aos.js"></script>

    <!-- <script>(function () { function c() { var b = a.contentDocument || a.contentWindow.document; if (b) { var d = b.createElement('script'); d.innerHTML = "window.__CF$cv$params={r:'8c0d7aa86ec295fb',t:'MTcyNTk1MDk3OC4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='<?php echo ASSETS; ?>/js/cdn-main.js';document.getElementsByTagName('head')[0].appendChild(a);"; b.getElementsByTagName('head')[0].appendChild(d) } } if (document.body) { var a = document.createElement('iframe'); a.height = 1; a.width = 1; a.style.position = 'absolute'; a.style.top = 0; a.style.left = 0; a.style.border = 'none'; a.style.visibility = 'hidden'; document.body.appendChild(a); if ('loading' !== document.readyState) c(); else if (window.addEventListener) document.addEventListener('DOMContentLoaded', c); else { var e = document.onreadystatechange || function () { }; document.onreadystatechange = function (b) { e(b); 'loading' !== document.readyState && (document.onreadystatechange = e, c()) } } } })();</script> -->
    </body>

    </html>