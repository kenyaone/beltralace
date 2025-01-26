<?php
if($page->header_image){
?>
<div class="breadcrumbs overlay" style="background-image: url(<?php echo UPLOAD_SERVER . '/' . $page->header_image;?>)">
<?php
}
else{
?>
<div class="breadcrumbs overlay">
<?php
}
?>
    <div class="container">
        <div class="bread-inner">
            <div class="row">
                <div class="col-12">
                    <h2>About Us</h2>
                    <ul class="bread-list">
                        <li><a href="/">Home</a></li>
                        <li><i class="icofont-simple-right"></i></li>
                        <li class="active">About Us</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="why-choose section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-12" data-aos="fade-left">
                <!-- Start Choose Left -->
                <div class="choose-left">
                    <h3 class="page-subtitle"></h3>
                    <div class="page-content text-reset"></div>
                </div>
                <!-- End Choose Left -->
            </div>
            <div class="col-lg-6 col-12" data-aos="fade-right">
                <!-- Start Choose Rights -->
                <div class="choose-right">
                    <div class="video-image">
                        <!-- <img src="<?php echo ASSETS; ?>/img/about-us.jpg"> -->
                        <img src="<?php echo $page->cover_image ? (UPLOAD_SERVER . '/' . $page->cover_image) : ASSETS . '/img/about-us.jpg' ; ?>">
                    </div>
                </div>
                <!-- End Choose Rights -->
            </div>
        </div>
    </div>
</section>

<!-- <style>
    .team .member {
        margin-bottom: 20px;
        overflow: hidden;
        text-align: center;
        border-radius: 5px;
        background: #fff;
        box-shadow: 0px 2px 15px rgba(65, 76, 100, 0.06);
    }

    .team .member .member-img {
        position: relative;
        overflow: hidden;
    }

    .team .member .social {
        position: absolute;
        left: 0;
        bottom: 0;
        right: 0;
        height: 40px;
        opacity: 0;
        transition: ease-in-out 0.3s;
        text-align: center;
        background: rgba(255, 255, 255, 0.85);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .team .member .social a {
        transition: color 0.3s;
        color: #414c64;
        margin: 0 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .team .member .social a i {
        line-height: 0;
    }

    .team .member .social a:hover {
        color: #ffc107;
    }

    .team .member .social i {
        font-size: 18px;
        margin: 0 2px;
    }

    .team .member .member-info {
        padding: 25px 15px;
    }

    .team .member .member-info h4 {
        font-weight: 700;
        margin-bottom: 5px;
        font-size: 18px;
        color: #414c64;
    }

    .team .member .member-info span {
        display: block;
        font-size: 13px;
        font-weight: 400;
        color: #aaaaaa;
    }

    .team .member .member-info p {
        font-style: italic;
        font-size: 14px;
        line-height: 26px;
        color: #777777;
    }

    .team .member:hover .social {
        opacity: 1;
    }
</style>
<section id="team" class="section team section-bg">
    <div class="container">
        <div class="section-title">
            <h3>Team</h3>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
                <div class="member">
                    <div class="member-img">
                        <img src="<?php echo ASSETS . '/img/wairimu.jpg'; ?>" class="img-fluid" alt="">
                        <div class="social">
                            <a href=""><i class="bi bi-twitter"></i></a>
                            <a href=""><i class="bi bi-facebook"></i></a>
                            <a href=""><i class="bi bi-instagram"></i></a>
                            <a href=""><i class="bi bi-linkedin"></i></a>
                        </div>
                    </div>
                    <div class="member-info">
                        <h4>Wairimu Kariuki</h4>
                        <span>Chairperson</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
                <div class="member">
                    <div class="member-img">
                        <img src="<?php echo ASSETS . '/img/ian.jpg'; ?>" class="img-fluid" alt="">
                        <div class="social">
                            <a href=""><i class="bi bi-twitter"></i></a>
                            <a href=""><i class="bi bi-facebook"></i></a>
                            <a href=""><i class="bi bi-instagram"></i></a>
                            <a href=""><i class="bi bi-linkedin"></i></a>
                        </div>
                    </div>
                    <div class="member-info">
                        <h4>Ian Mutevu</h4>
                        <span>Secretary</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
                <div class="member">
                    <div class="member-img">
                        <img src="<?php echo ASSETS . '/img/joan.jpg'; ?>" class="img-fluid" alt="">
                        <div class="social">
                            <a href=""><i class="bi bi-twitter"></i></a>
                            <a href=""><i class="bi bi-facebook"></i></a>
                            <a href=""><i class="bi bi-instagram"></i></a>
                            <a href=""><i class="bi bi-linkedin"></i></a>
                        </div>
                    </div>
                    <div class="member-info">
                        <h4>Joan Ndindi Eunice</h4>
                        <span>Treasurer</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
                <div class="member">
                    <div class="member-img">
                        <img src="<?php echo ASSETS . '/img/joyce.jpg'; ?>" class="img-fluid" alt="">
                        <div class="social">
                            <a href=""><i class="bi bi-twitter"></i></a>
                            <a href=""><i class="bi bi-facebook"></i></a>
                            <a href=""><i class="bi bi-instagram"></i></a>
                            <a href=""><i class="bi bi-linkedin"></i></a>
                        </div>
                    </div>
                    <div class="member-info">
                        <h4>Joyce Macharia</h4>
                        <span>Board Member</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
                <div class="member">
                    <div class="member-img">
                        <img src="<?php echo ASSETS . '/img/joseph.jpg'; ?>" class="img-fluid" alt="">
                        <div class="social">
                            <a href=""><i class="bi bi-twitter"></i></a>
                            <a href=""><i class="bi bi-facebook"></i></a>
                            <a href=""><i class="bi bi-instagram"></i></a>
                            <a href=""><i class="bi bi-linkedin"></i></a>
                        </div>
                    </div>
                    <div class="member-info">
                        <h4>Joseph Mwaura</h4>
                        <span>Board Member</span>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section> -->

<?php
include 'includes/section-cta.php';
?>

<section class="Feautes section mt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>Our Core Values</h2>
                    <p>These values are at the center of everything we do as an organization</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-12">
                <!-- Start Single features -->
                <div class="single-features">
                    <div class="signle-icon">
                        <i class="icofont icofont-ambulance-cross"></i>
                    </div>
                    <h3>Compassion</h3>
                    <!-- <p>Lorem ipsum sit, consectetur adipiscing elit. Maecenas mi quam vulputate.</p> -->
                </div>
                <!-- End Single features -->
            </div>
            <div class="col-lg-3 col-12">
                <!-- Start Single features -->
                <div class="single-features">
                    <div class="signle-icon">
                        <i class="icofont icofont-medical-sign-alt"></i>
                    </div>
                    <h3>Resilience</h3>
                    <!-- <p>Lorem ipsum sit, consectetur adipiscing elit. Maecenas mi quam vulputate.</p> -->
                </div>
                <!-- End Single features -->
            </div>
            <div class="col-lg-3 col-12">
                <!-- Start Single features -->
                <div class="single-features">
                    <div class="signle-icon">
                        <i class="icofont icofont-stethoscope"></i>
                    </div>
                    <h3>Support</h3>
                    <!-- <p>Lorem ipsum sit, consectetur adipiscing elit. Maecenas mi quam vulputate.</p> -->
                </div>
                <!-- End Single features -->
            </div>
            <div class="col-lg-3 col-12">
                <!-- Start Single features -->
                <div class="single-features last">
                    <div class="signle-icon">
                        <i class="icofont icofont-stethoscope"></i>
                    </div>
                    <h3>Collaboration</h3>
                    <!-- <p>Lorem ipsum sit, consectetur adipiscing elit. Maecenas mi quam vulputate.</p> -->
                </div>
                <!-- End Single features -->
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {
        loadPageContent();
    });

    function loadPageContent() {
        $.ajax({
            type: 'GET',
            url: '<?php echo API; ?>',
            data: {
                object: 'Page',
                action: 'get_by_slug',
                slug: 'about-us'
            },
            cache: false,
            dataType: 'JSON',
            success: function(response) {
                $('.page-subtitle').html(response.sub_title);
                $('.page-content').html(response.body);
            }
        });
    }
</script>