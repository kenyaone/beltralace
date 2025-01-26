<?php
if ($page->header_image) {
?>
    <div class="breadcrumbs overlay" style="background-image: url(<?php echo UPLOAD_SERVER . '/' . $page->header_image; ?>)">
    <?php
} else {
    ?>
        <div class="breadcrumbs overlay">
        <?php
    }
        ?>
        <div class="container">
            <div class="bread-inner">
                <div class="row">
                    <div class="col-12">
                        <h2>Contact Us</h2>
                        <ul class="bread-list">
                            <li><a href="/">Home</a></li>
                            <li><i class="icofont-simple-right"></i></li>
                            <li class="active">Contact Us</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <section class="contact-us section">
            <div class="container">
                <div class="inner">
                    <div class="row">
                        <div class="col-lg-6 order-2">
                            <div class="contact-us-left">
                                <!--Start Google-map -->
                                <div id="myMap">
                                <iframe style="height:100%;width:100%;border:0;" frameborder="0" src="https://www.google.com/maps/embed/v1/place?q=quickmart+thome&key=AIzaSyBFw0Qbyq9zTFTd-tUY6dZWTgaQzuU17R8"></iframe>

                                </div>
                                <!--/End Google-map -->
                            </div>
                        </div>
                        <div class="col-lg-6 order-1">
                            <div class="contact-us-form">
                                <h2><?php echo $page->sub_title ? $page->sub_title : "Talk to us"; ?></h2>
                                <p>If you have any questions please fell free to talk to us.</p>
                                <!-- Form -->
                                <form class="form">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <input type="text" name="name" placeholder="Name" required="">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <input type="email" name="email" placeholder="Email" required="">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <input type="text" name="phone" placeholder="Phone" required="">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <input type="text" name="subject" placeholder="Subject" required="">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <textarea name="message" placeholder="Your Message" required=""></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group login-btn">
                                                <button class="btn" type="submit">Send</button>
                                            </div>
                                            <div class="checkbox">
                                                <label class="checkbox-inline" for="2"><input name="news" id="2" type="checkbox">Do you want to subscribe to our newsletter ?</label>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!--/ End Form -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="contact-info">
                    <div class="row">
                        <!-- single-info -->
                        <div class="col-lg-4 col-12 ">
                            <div class="single-info">
                                <i class="icofont icofont-ui-call"></i>
                                <div class="content">
                                    <h3>+254 727 758 360</h3>
                                    <!-- <p><a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="046d6a626b44676b6974656a7d2a676b69">[email&#160;protected]</a></p> -->
                                    <p>info@hpew.org</p>
                                </div>
                            </div>
                        </div>
                        <!--/End single-info -->
                        <!-- single-info -->
                        <div class="col-lg-4 col-12 ">
                            <div class="single-info">
                                <i class="icofont-google-map"></i>
                                <div class="content">
                                    <h3>Nairobi</h3>
                                    <p>Nairobi, Kenya</p>
                                </div>
                            </div>
                        </div>
                        <!--/End single-info -->
                        <!-- single-info -->
                        <div class="col-lg-4 col-12 ">
                            <div class="single-info">
                                <i class="icofont icofont-wall-clock"></i>
                                <div class="content">
                                    <h3>Mon - Sat</h3>
                                    <p>8am - 5pm</p>
                                </div>
                            </div>
                        </div>
                        <!--/End single-info -->
                    </div>
                </div>
            </div>
        </section>
        <!--/ End Contact Us -->