<?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, API);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

$post_data = array(
    'object' => 'Widget',
    'action' => 'get_by_section',
    'section' => 'banner'
);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
$response = curl_exec($ch);
$banner_widgets = json_decode($response);

// if(count($banner_widgets)){
?>

<!--search overlay start-->
<div class="search-wrap">
    <div class="overlay">
        <form action="" class="search-form">
            <div class="container">
                <div class="row">
                    <div class="col-md-10 col-9">
                        <h3>Search Your keyword</h3>
                        <input type="text" class="form-control" placeholder="Search..." />
                    </div>
                    <div class="col-md-2 col-3 text-right">
                        <div class="search_toggle toggle-wrap d-inline-block">
                            <img class="search-close" src="<?php echo ASSETS; ?>/images/close.png" srcset="assets/images/close@2x.png 2x" alt="" />
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<section class="banner">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-8">
                <div class="banner-content center-heading">
                    <span class="subheading">Expert instruction</span>
                    <h1>For all your professional language solutions!</h1>
                    <a href="#" class="btn btn-main"><i class="fa fa-list-ul mr-2"></i>our Courses </a>
                    <a href="#" class="btn btn-tp ">get Started <i class="fa fa-angle-right ml-2"></i></a>
                </div>
            </div>
        </div> <!-- / .row -->
    </div> <!-- / .container -->
</section>

<?php
/**
?>
<section class="feature">
    <div class="container">
        <div class="row no-gutters">
            <div class="col-lg-3 col-md-6">
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fa fa-check"></i>
                    </div>
                    <div class="feature-text">
                        <h4>Professionalism</h4>
                        <!-- <p>Behind the word mountains, far from the countries Vokalia </p> -->
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fa fa-check-circle"></i>
                    </div>
                    <div class="feature-text">
                        <h4>Quality</h4>
                        <!-- <p>Behind the word mountains, far from the countries Vokalia </p> -->
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fa fa-check-circle"></i>
                    </div>
                    <div class="feature-text">
                        <h4>Integrity</h4>
                        <!-- <p>Behind the word mountains, far from the countries Vokalia </p> -->
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fa fa-check-circle"></i>
                    </div>
                    <div class="feature-text">
                        <h4>Consistency</h4>
                        <!-- <p>Behind the word mountains, far from the countries Vokalia </p> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
*/
?>
<section class="about-section section-padding about-2">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-12">
                <div class="about-img2">
                    <img src="https://pxelcode.com/tf-db/edutim/edutim/assets/images/bg/choose.png" alt="" class="img-fluid">
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="section-heading">
                    <span class="subheading">Who we are</span>
                    <h3>All about languages</h3>
                </div>

                <p>
                    We are a team of qualified professional linguists specializing in providing language services
                    particularly language teaching and translation services to individuals, groups and companies
                    across the world.
                </p>
                <p>
                    Our trainers are native speakers of the languages they teach, and very
                    experienced in content delivery using the state-of-art web conferencing technologies within
                    their reach. This ensures that learning is an enjoyable expedition worth remembering.
                </p>

                <a href="#" class="btn btn-main"><i class="fa fa-check mr-2"></i>Learn More</a>

            </div>
        </div>
    </div>
</section>