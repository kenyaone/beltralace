<?php
// $ch = curl_init();
// curl_setopt($ch, CURLOPT_URL, API);
// curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

// $post_data = array(
//     'object' => 'Widget',
//     'action' => 'get_by_section',
//     'section' => 'banner'
// );

// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_POST, true);
// curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
// $response = curl_exec($ch);
// $banner_widgets = json_decode($response);

// if(count($banner_widgets)){
?>

<style>
    .language-container {
        text-align: center;
        margin: 10px;
    }

    .language-container img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #ddd;
    }

    .language-container p {
        margin-top: 5px;
        font-size: 14px;
        font-weight: bold;
    }
</style>

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

<section id="bannerCarousel" class="carousel slide banner" data-ride="carousel">
    <div class="carousel-inner">
        <!-- Slide 1 -->
        <div class="carousel-item active">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12 col-lg-8">
                        <div class="banner-content center-heading">
                            <span class="subheading">Expert instruction</span>
                            <h1>For all your professional language solutions!</h1>
                            <a href="/pricing#our-courses" class="btn btn-main"><i class="fa fa-list-ul mr-2"></i>Our Courses</a>
                            <a href="#" class="btn btn-tp" data-toggle="modal" data-target="#modal-form">Get Started <i class="fa fa-angle-right ml-2"></i></a>
                        </div>
                    </div>
                </div> <!-- / .row -->
            </div> <!-- / .container -->
        </div>

        <!-- Slide 2 -->
        <div class="carousel-item">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12 col-lg-8">
                        <div class="banner-content center-heading">
                            <span class="subheading">Tailored Language Courses</span>
                            <h1>Learn at your own pace with expert trainers</h1>
                            <a href="/pricing#our-courses" class="btn btn-main"><i class="fa fa-list-ul mr-2"></i>Our Courses</a>
                            <a href="#" class="btn btn-tp" data-toggle="modal" data-target="#modal-form">Get Started <i class="fa fa-angle-right ml-2"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Slide 3 -->
        <div class="carousel-item">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12 col-lg-8">
                        <div class="banner-content center-heading">
                            <span class="subheading">Certified Translation Services</span>
                            <h1>Accurate & Reliable Translation for Your Business</h1>
                            <a href="/pricing#our-courses" class="btn btn-main"><i class="fa fa-list-ul mr-2"></i>Our Services</a>
                            <a href="#" class="btn btn-tp" data-toggle="modal" data-target="#modal-form">Get Started <i class="fa fa-angle-right ml-2"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Controls -->
    <a class="carousel-control-prev" href="#bannerCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#bannerCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</section>


<section class="section-padding course-grid">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-7">
                <div class="section-heading center-heading">
                    <!-- <span class="subheading">Pick your language of choice</span> -->
                    <h3>I want to learn:</h3>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-auto language-container">
                <a href="/languages/swahili">
                    <img src="https://flagcdn.com/w160/ke.png" alt="English">
                    <p>Swahili</p>
                </a>
            </div>
            <div class="col-auto language-container">
                <a href="/languages/english">
                    <img src="https://flagcdn.com/w160/gb.png" alt="English">
                    <p>English</p>
                </a>
            </div>
            <div class="col-auto language-container">
                <a href="/languages/spanish">
                    <img src="https://flagcdn.com/w160/es.png" alt="Spanish">
                    <p>Spanish</p>
                </a>
            </div>
            <div class="col-auto language-container">
                <a href="/languages/french">
                    <img src="https://flagcdn.com/w160/fr.png" alt="French">
                    <p>French</p>
                </a>
            </div>
            <div class="col-auto language-container">
                <a href="/languages/german">
                    <img src="https://flagcdn.com/w160/de.png" alt="German">
                    <p>German</p>
                </a>
            </div>
            <div class="col-auto language-container">
                <a href="/languages/portuguese">
                    <img src="https://flagcdn.com/w160/br.png" alt="Portuguese">
                    <p>Portuguese</p>
                </a>
            </div>
            <div class="col-auto language-container">
                <a href="/languages/italian">
                    <img src="https://flagcdn.com/w160/it.png" alt="Italian">
                    <p>Italian</p>
                </a>
            </div>
            <div class="col-auto language-container">
                <a href="/languages/mandarin">
                    <img src="https://flagcdn.com/w160/cn.png" alt="Mandarin Chinese">
                    <p>Mandarin Chinese</p>
                </a>
            </div>
        </div>
    </div>
</section>
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

                <a href="/about-us" class="btn btn-main"><i class="fa fa-check mr-2"></i>Learn More</a>

            </div>
        </div>
    </div>
</section>

<section class="team section-padding bg-grey">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="section-heading">
                    <span class="subheading">Best Expert Trainers</span>
                    <h3>Our Team</h3>
                </div>
            </div>

            <div class="col-lg-6">
                <!-- <div class="course-btn text-lg-right"><a href="#" class="btn btn-main"><i class="fa fa-user mr-2"></i>Join With us</a></div> -->
            </div>
        </div>


        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="team-item">
                    <div style="height: 200px; overflow: hidden;">
                        <img src="<?php echo ASSETS; ?>/images/bilha.jpeg" alt="" class="img-fluid" style="object-fit: cover;">
                    </div>
                    <div class="team-info">
                        <h4>Belha</h4>
                        <p>Swahili trainer/expert</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-6">
                <div class="team-item">
                    <p class="text-left">
                        A university of Nairobi graduate in Bachelor of Education Specializing in Swahili and
                        Geography, Belha is not only a qualified and professional Swahili teacher but also an
                        experienced Swahili native speaker. She speaks fluent English and intermediate Chinese
                        Mandarin too.
                    </p>
                    <p class="text-left">
                        Belha has over 10 years of teaching experience in schools across Africa and has previous
                        extensive experience as a Swahili trainer and translator for large organizations and NGO’s in
                        Nairobi such as Nairobi Institute of Swahili and Helen Keller international, (Nairobi branch).
                    </p>
                    <p class="text-left">
                        She has also enjoyed the experience of working with International Language companies such
                        as Language trainers, London Swahili and Listen and Learn, giving her a broad experience in
                        teaching people across borders and from difference cultures.
                    </p>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-lg-9 col-md-6">
                <div class="team-item">
                    <p class="text-left">
                        How about learning Swahili in a fun, interactive and practical way? I am kavulani, a language
                        specialist who has a vast experience in teaching swahili as a first language and also as a
                        foreign language.
                    </p>
                    <p class="text-left">
                        Having worked for cactus language center and Nairobi institute of Swahili and east African culture
                        among other language schools, all I can assure my clients is that it can only get better.
                    </p>
                    <p class="text-left">
                        Having graduated from the University of Nairobi with a major in Swahili language, I enjoy imparting
                        my language skills knowledge and culture to diverse individuals, in the process, learning theirs too.
                        The beauty of a language is sharing it for others to learn.
                    </p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="team-item">
                    <div style="height: 200px; overflow: hidden;">
                        <img src="<?php echo ASSETS; ?>/images/pascalliah.png" alt="" class="img-fluid" style="object-fit: cover;">
                    </div>
                    <div class="team-info">
                        <h4>Pascalliah</h4>
                        <p>Swahili trainer/expert</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="pb-5">
    <div class="py-5 bg-light c2a1"
        style="background-image:url(../frontend/views/assets/images/cta.jpg)">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 text-center">
                    <h2 class="mb-3 text-white font-weight-medium">Take free test</h2>
                    <p class="font-weight-light text-white op-8">
                        Challenge yourself with our online courses in more than 100 languages! Reach out to us and we will prepare a fun and interactive programme just for you.
                    </p>
                    <a class="btn btn-main btn-md border-0 text-white mt-3 take-test-btn" href="#">
                        <span>Take test today</span>
                    </a>
                </div>
            </div>
            <!-- Row -->
        </div>
    </div>
</section>

<section class="testimonial section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section-heading center-heading text-center">
                    <span class="subheading">Testimonials</span>
                    <h3>What our clients say about us</h3>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="testimonials-slides owl-carousel owl-theme">
                    <div class="review-item">
                        <div class="client-info">
                            <i class="fa fa-quote-left"></i>
                            <p>
                                Learning swahili was life-changing for me. It helped me enjoy my trip to East Africa
                            </p>
                            <div class="rating">
                                <a href="#"><i class="fa fa-star"></i></a>
                                <a href="#"><i class="fa fa-star"></i></a>
                                <a href="#"><i class="fa fa-star"></i></a>
                                <a href="#"><i class="fa fa-star"></i></a>
                                <a href="#"><i class="fa fa-star"></i></a>
                            </div>
                        </div>
                        <div class="client-desc">
                            <div class="client-img">
                                <img src="assets/images/clients/test-1.jpg" alt="" class="img-fluid">
                            </div>
                            <div class="client-text">
                                <h4>Jean Annika</h4>
                                <span class="designation">Student</span>
                            </div>
                        </div>
                    </div>

                    <div class="review-item">
                        <div class="client-info">
                            <i class="fa fa-quote-left"></i>
                            <p>
                                Having our materials translated by Betralace has been awesome. Their service is top-notch.
                                Highly recommend.
                            </p>
                            <div class="rating">
                                <a href="#"><i class="fa fa-star"></i></a>
                                <a href="#"><i class="fa fa-star"></i></a>
                                <a href="#"><i class="fa fa-star"></i></a>
                                <a href="#"><i class="fa fa-star"></i></a>
                                <a href="#"><i class="fa fa-star"></i></a>
                            </div>
                        </div>
                        <div class="client-desc">
                            <div class="client-img">
                                <img src="assets/images/clients/test-2.jpg" alt="" class="img-fluid">
                            </div>
                            <div class="client-text">
                                <h4>Howard Mason</h4>
                                <span class="designation">Finance Manager</span>
                            </div>
                        </div>
                    </div>


                    <div class="review-item">
                        <div class="client-info">
                            <i class="fa fa-quote-left"></i>
                            <p>
                                I am happy I learnt spanish. Super grateful to Betralace because they made the experience
                                easy and enjoyable.
                            </p>
                            <div class="rating">
                                <a href="#"><i class="fa fa-star"></i></a>
                                <a href="#"><i class="fa fa-star"></i></a>
                                <a href="#"><i class="fa fa-star"></i></a>
                                <a href="#"><i class="fa fa-star"></i></a>
                                <a href="#"><i class="fa fa-star"></i></a>
                            </div>
                        </div>
                        <div class="client-desc">
                            <div class="client-img">
                                <img src="assets/images/clients/test-3.jpg" alt="" class="img-fluid">
                            </div>
                            <div class="client-text">
                                <h4>Sasha Mwanzo</h4>
                                <span class="designation">Project Manager</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="testimonial section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section-heading center-heading text-center">
                    <span class="subheading">Language Tips!</span>
                    <h3>How can you learn a new language easily?</h3>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="">
                    <ul class="list-group">
                        <li class="list-group-item">1. Consistency- Be consistent in taking the classes, long breaks in between sessions have I counter effect on the progress of the learner</li>
                        <li class="list-group-item">2. Practice- Use the language in conversations with other speakers apart from your teacher.</li>
                        <li class="list-group-item">3. Study & Follow-up   - Spare personal study time (at least 30 mins daily) to review the work you covered with your trainer</li>
                        <li class="list-group-item">4. Flexibility-Be flexible and willing to take some homework, it enhances assimilation of content covered</li>
                        <li class="list-group-item">5. Learning Aids-Make flash cards, word charts, crosswords and games that will enhance your understanding.</li>
                        <li class="list-group-item">6. Assessment and Evaluation-Sit for a language exam, to measure milestones covered in the Language</li>
                </div>
            </div>
        </div>
    </div>
</section>