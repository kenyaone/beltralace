<style>
/* ===== FORCE LIGHTER HERO OVERLAY ===== */
.banner::before,
.banner .carousel-item::before {
    background: rgba(10,10,60,0.28) !important;
}
.banner::after,
.banner .carousel-item::after {
    display: none !important;
}
.banner,
.banner .carousel-item {
    position: relative;
}
.banner .container,
.banner-content {
    position: relative;
    z-index: 10;
}

/* ===== LOGO COLOURS: Navy #1a1a6e | Sky blue #4db8e8 | Gold #f5c518 | Red #cc2020 ===== */

/* ===== STICKY TOP BAR ===== */
.top-promo-bar {
    background: linear-gradient(135deg, #4db8e8, #1a1a6e);
    color: #fff;
    text-align: center;
    padding: 10px 20px;
    font-size: 14px;
    font-weight: 600;
    position: relative;
    z-index: 1000;
}
.top-promo-bar a {
    color: #f5c518;
    font-weight: 800;
    text-decoration: underline;
    margin-left: 8px;
}
.top-promo-bar a:hover { color: #fff; }

/* ===== HERO OVERLAY LIGHTENER ===== */
.banner::after, .banner .carousel-item::after {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(26,26,110,0.35) !important;
    z-index: 0;
}
.banner .carousel-item { position: relative; }
.banner .container { position: relative; z-index: 2; }
.banner-content { position: relative; z-index: 2; }

/* ===== HERO EXTRAS ===== */
.hero-urgency {
    display: inline-block;
    background: #f5c518;
    border: 2px solid #f5c518;
    border-radius: 20px;
    padding: 8px 20px;
    font-size: 13px;
    color: #1a1a6e;
    font-weight: 800;
    margin-bottom: 16px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.3);
}
.btn-whatsapp {
    background: #25d366;
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 12px 24px;
    font-size: 14px;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin: 8px 4px;
    transition: all 0.3s;
    text-decoration: none;
}
.btn-whatsapp:hover { background: #128c7e; color: #fff; transform: translateY(-2px); }

/* ===== STATS BAR ===== */
.stats-bar { background: linear-gradient(135deg, #1a1a6e, #2a2a9e); padding: 28px 0; }
.stat-item { text-align: center; padding: 10px; }
.stat-number { font-size: 40px; font-weight: 900; color: #f5c518; display: block; line-height: 1; }
.stat-label { font-size: 12px; color: rgba(255,255,255,0.8); margin-top: 6px; display: block; text-transform: uppercase; letter-spacing: 0.08em; font-weight: 600; }

/* ===== LANGUAGE FLAGS ===== */
.language-container { text-align: center; margin: 10px; transition: transform 0.2s; }
.language-container:hover { transform: translateY(-5px); }
.language-container img { width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 3px solid #ddd; transition: all 0.2s; }
.language-container:hover img { border-color: #4db8e8; box-shadow: 0 6px 20px rgba(77,184,232,0.4); }
.language-container p { margin-top: 8px; font-size: 13px; font-weight: 700; color: #1a1a6e; }

/* ===== WHY CHOOSE US ===== */
.why-us-card { background: #fff; border-radius: 16px; padding: 30px 22px; text-align: center; box-shadow: 0 4px 20px rgba(0,0,0,0.06); transition: transform 0.25s, box-shadow 0.25s; height: 100%; border-top: 4px solid transparent; }
.why-us-card:hover { transform: translateY(-8px); box-shadow: 0 12px 40px rgba(0,0,0,0.12); }
.why-us-card.c1 { border-top-color: #4db8e8; }
.why-us-card.c2 { border-top-color: #f5c518; }
.why-us-card.c3 { border-top-color: #cc2020; }
.why-us-card.c4 { border-top-color: #1a1a6e; }
.why-us-icon { width: 64px; height: 64px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; }
.i1 { background: #edf8fd; } .i1 i { color: #4db8e8; font-size: 26px; }
.i2 { background: #fefae6; } .i2 i { color: #c9a000; font-size: 26px; }
.i3 { background: #fdeaea; } .i3 i { color: #cc2020; font-size: 26px; }
.i4 { background: #eaeaf8; } .i4 i { color: #1a1a6e; font-size: 26px; }
.why-us-card h5 { font-size: 16px; font-weight: 700; color: #1a1a6e; margin-bottom: 10px; }
.why-us-card p { font-size: 13px; color: #666; margin: 0; line-height: 1.7; }

/* ===== MEMBERSHIP ===== */
.membership-badge { display: inline-flex; align-items: center; gap: 8px; background: #edf8fd; border: 2px solid #4db8e8; border-radius: 30px; padding: 8px 18px; margin: 6px; font-size: 13px; font-weight: 700; color: #1a1a6e; }
.membership-badge i { color: #4db8e8; }

/* ===== CLIENTS ===== */
.clients-bar { background: #fff; padding: 40px 0; border-top: 2px solid #f0f9ff; border-bottom: 2px solid #f0f9ff; }
.client-logo-text { background: #f5faff; border: 2px solid #c8eaf8; border-radius: 12px; font-weight: 700; color: #1a1a6e; text-align: center; padding: 14px 16px; font-size: 13px; transition: all 0.3s; }
.client-logo-text:hover { background: #1a1a6e; color: #fff; border-color: #1a1a6e; transform: translateY(-3px); box-shadow: 0 6px 20px rgba(26,26,110,0.2); }
.client-logo-item { padding: 8px; }

/* ===== HOW IT WORKS ===== */
.step-number { width: 58px; height: 58px; border-radius: 50%; background: linear-gradient(135deg, #4db8e8, #1a1a6e); color: #fff; font-size: 24px; font-weight: 900; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; box-shadow: 0 6px 20px rgba(77,184,232,0.35); }
.step-card { text-align: center; padding: 28px 20px; background: #fff; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.06); margin: 8px; height: 100%; }
.step-card h5 { font-size: 16px; font-weight: 700; color: #1a1a6e; margin-bottom: 8px; }
.step-card p { font-size: 13px; color: #666; }

/* ===== PRICING ===== */
.pricing-teaser { background: linear-gradient(135deg, #1a1a6e, #2a2a9e); padding: 60px 0; }
.price-pill { display: inline-block; background: rgba(255,255,255,0.1); border: 2px solid rgba(255,255,255,0.3); border-radius: 50px; padding: 12px 24px; margin: 8px; font-size: 14px; color: #fff; transition: all 0.3s; }
.price-pill:hover { background: rgba(255,255,255,0.2); transform: translateY(-2px); }
.price-pill span { color: #f5c518; font-weight: 900; font-size: 18px; }

/* ===== PACKAGES ===== */
.pkg-card { background: #fff; border-radius: 16px; border: 2px solid #eee; padding: 30px 22px; text-align: center; height: 100%; transition: transform 0.2s, box-shadow 0.2s; }
.pkg-card:hover { transform: translateY(-6px); box-shadow: 0 12px 35px rgba(0,0,0,0.1); }
.pkg-card.featured { border-color: #1a1a6e; box-shadow: 0 8px 30px rgba(26,26,110,0.15); }
.pkg-badge { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; padding: 5px 14px; border-radius: 20px; display: inline-block; margin-bottom: 14px; }
.pkg-badge.beginner { background: #edf8fd; color: #2a9fd4; }
.pkg-badge.intermediate { background: #eaeaf8; color: #1a1a6e; }
.pkg-badge.advanced { background: #fdeaea; color: #cc2020; }
.pkg-card h5 { font-size: 15px; font-weight: 700; color: #1a1a6e; margin-bottom: 10px; line-height: 1.4; }
.pkg-card p { font-size: 13px; color: #666; margin-bottom: 18px; }
.pkg-price { font-size: 30px; font-weight: 900; color: #4db8e8; }
.pkg-duration { font-size: 12px; color: #999; margin-bottom: 20px; }
.urgency-bar { background: #fefae6; border: 1px solid #f5c518; border-radius: 8px; padding: 10px 16px; font-size: 13px; color: #7a5000; margin-bottom: 24px; font-weight: 600; }

/* ===== FAQ ===== */
.faq-item { border-bottom: 2px solid #f0f9ff; padding: 18px 0; }
.faq-question { font-size: 15px; font-weight: 700; color: #1a1a6e; cursor: pointer; display: flex; justify-content: space-between; align-items: center; }
.faq-question i { color: #4db8e8; font-size: 16px; transition: transform 0.3s; }
.faq-answer { font-size: 14px; color: #555; padding-top: 12px; display: none; line-height: 1.8; }
.faq-item.active .faq-answer { display: block; }
.faq-item.active .faq-question i { transform: rotate(180deg); }
.faq-item.active .faq-question { color: #4db8e8; }

/* ===== FINAL CTA ===== */
.final-cta { background: linear-gradient(135deg, #4db8e8, #1a1a6e); padding: 60px 0; text-align: center; }
.final-cta h2 { font-size: 32px; font-weight: 900; color: #fff; margin-bottom: 12px; }
.final-cta p { font-size: 16px; color: rgba(255,255,255,0.9); margin-bottom: 28px; }
.btn-white { background: #fff; color: #1a1a6e; border: none; font-weight: 800; padding: 14px 32px; border-radius: 8px; font-size: 15px; transition: all 0.3s; display: inline-block; text-decoration: none; }
.btn-white:hover { background: #f5c518; color: #1a1a6e; transform: translateY(-2px); text-decoration: none; }
.btn-outline-white { background: transparent; color: #fff; border: 2px solid #fff; font-weight: 700; padding: 13px 30px; border-radius: 8px; font-size: 15px; transition: all 0.3s; display: inline-block; text-decoration: none; margin-left: 12px; }
.btn-outline-white:hover { background: #fff; color: #1a1a6e; text-decoration: none; }

/* ===== LEARNING TIPS ===== */
.learning-tips { padding: 10px 0; }
.list-group-item { align-items: center; border: none; padding: 12px 8px; border-radius: 8px !important; margin-bottom: 4px; }
.list-group-item:hover { background: #f0f9ff; }
.bullet-point { font-size: 20px; color: #4db8e8; margin-right: 10px; }
.tip { font-weight: 700; color: #1a1a6e; padding-right: 6px; }

/* ===== TESTIMONIAL POPUP ===== */
.testimonial-popup {
    position: fixed;
    bottom: 30px;
    left: 30px;
    width: 340px;
    background: linear-gradient(135deg, #1a1a6e 0%, #2a2aae 100%);
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(26,26,110,0.5), 0 0 0 3px #f5c518;
    padding: 24px;
    z-index: 99999;
    transform: translateX(-420px);
    transition: transform 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
    border-left: 6px solid #f5c518;
}
.testimonial-popup.show { transform: translateX(0); }
.testimonial-popup .close-popup { position: absolute; top: 12px; right: 14px; font-size: 22px; cursor: pointer; color: rgba(255,255,255,0.6); background: none; border: none; line-height: 1; transition: color 0.2s; }
.testimonial-popup .close-popup:hover { color: #fff; }
.testimonial-popup .popup-header { display: flex; align-items: center; gap: 12px; margin-bottom: 14px; }
.testimonial-popup .popup-avatar { width: 56px; height: 56px; border-radius: 50%; background: linear-gradient(135deg, #f5c518, #f5a623); display: flex; align-items: center; justify-content: center; color: #1a1a6e; font-size: 22px; font-weight: 900; flex-shrink: 0; box-shadow: 0 4px 15px rgba(245,197,24,0.5); }
.testimonial-popup .popup-name { font-weight: 800; font-size: 15px; color: #fff; margin: 0; }
.testimonial-popup .popup-role { font-size: 12px; color: rgba(255,255,255,0.65); margin: 0; }
.testimonial-popup .popup-stars { color: #f5c518; font-size: 16px; margin-bottom: 10px; letter-spacing: 3px; }
.testimonial-popup .popup-text { font-size: 14px; color: rgba(255,255,255,0.9); line-height: 1.7; margin: 0; font-style: italic; }
.popup-verified { display: inline-flex; align-items: center; gap: 4px; background: #edf8fd; color: #4db8e8; font-size: 11px; font-weight: 600; padding: 3px 8px; border-radius: 10px; float: right; margin-top: 10px; }

/* ===== SECTION HELPERS ===== */
.sec-white { background: #fff; padding: 60px 0; }
.sec-light { background: #f7fbff; padding: 60px 0; }
.sec-tag { font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: #4db8e8; display: block; margin-bottom: 8px; }
.sec-h { font-size: 28px; font-weight: 800; color: #1a1a6e; margin-top: 0; margin-bottom: 6px; }
.sec-h.white { color: #fff; }
</style>

<!-- Top Promo Bar -->
<div class="top-promo-bar">
    🎁 <strong>New students get a FREE 30-minute taster lesson!</strong>
    <a href="#" data-toggle="modal" data-target="#modal-form">Book Now →</a>
</div>

<!-- Search Overlay -->
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
                            <img class="search-close" src="<?php echo ASSETS; ?>/images/close.png" srcset="<?php echo ASSETS; ?>/images/close@2x.png 2x" alt="Close search" />
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Hero Banner -->
<section id="bannerCarousel" class="carousel slide banner" data-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12 col-lg-8">
                        <div class="banner-content center-heading">
                            <div class="hero-urgency">⚡ Next intake: May 5th · Limited slots available</div>
                            <span class="subheading">Expert instruction</span>
                            <h1>Online Language Courses with Native-Speaking Trainers — Worldwide</h1>
                            <div style="margin-top:20px;">
                                <a href="/pricing" class="btn btn-main"><i class="fa fa-list mr-2"></i>Our Courses</a>
                                <a href="#" class="btn btn-tp" data-toggle="modal" data-target="#modal-form">Get Started <i class="fa fa-angle-right ml-2"></i></a>
                                <a href="https://wa.me/254724736255" class="btn-whatsapp" target="_blank" rel="noopener noreferrer"><i class="fa fa-whatsapp"></i> Chat on WhatsApp</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12 col-lg-8">
                        <div class="banner-content center-heading">
                            <div class="hero-urgency">🎁 Free 30-min taster lesson for new students</div>
                            <span class="subheading">Tailored Language Courses</span>
                            <p class="banner-title">Learn at your own pace with expert native-speaking trainers</p>
                            <div style="margin-top:20px;">
                                <a href="/pricing" class="btn btn-main"><i class="fa fa-list mr-2"></i>Our Courses</a>
                                <a href="#" class="btn btn-tp" data-toggle="modal" data-target="#modal-form">Get Started <i class="fa fa-angle-right ml-2"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12 col-lg-8">
                        <div class="banner-content center-heading">
                            <div class="hero-urgency">✅ Registered member of Proz.com &amp; EAITA</div>
                            <span class="subheading">Certified Translation Services</span>
                            <p class="banner-title">Accurate &amp; Reliable Translation for Your Business</p>
                            <div style="margin-top:20px;">
                                <a href="/pricing" class="btn btn-main"><i class="fa fa-list mr-2"></i>Our Services</a>
                                <a href="#" class="btn btn-tp" data-toggle="modal" data-target="#modal-form">Get Started <i class="fa fa-angle-right ml-2"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a class="carousel-control-prev" href="#bannerCarousel" role="button" data-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="sr-only">Previous</span></a>
    <a class="carousel-control-next" href="#bannerCarousel" role="button" data-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="sr-only">Next</span></a>
</section>

<!-- Stats Bar -->
<section class="stats-bar">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-6 col-md-3 stat-item"><span class="stat-number">100+</span><span class="stat-label">Languages Offered</span></div>
            <div class="col-6 col-md-3 stat-item"><span class="stat-number">500+</span><span class="stat-label">Students Trained</span></div>
            <div class="col-6 col-md-3 stat-item"><span class="stat-number">2012</span><span class="stat-label">Founded</span></div>
            <div class="col-6 col-md-3 stat-item"><span class="stat-number">100%</span><span class="stat-label">Native Speakers</span></div>
        </div>
    </div>
</section>

<!-- Language Selector - White -->
<section class="sec-white">
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-lg-7 text-center">
                <span class="sec-tag">Pick Your Language</span>
                <h3 class="sec-h">I want to learn:</h3>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-auto language-container"><a href="/languages/swahili"><img src="https://flagcdn.com/w160/ke.png" alt="Kenya - Swahili" width="80" height="80" loading="lazy"><p>Swahili</p></a></div>
            <div class="col-auto language-container"><a href="/languages/english"><img src="https://flagcdn.com/w160/gb.png" alt="UK - English" width="80" height="80" loading="lazy"><p>English</p></a></div>
            <div class="col-auto language-container"><a href="/languages/spanish"><img src="https://flagcdn.com/w160/es.png" alt="Spain - Spanish" width="80" height="80" loading="lazy"><p>Spanish</p></a></div>
            <div class="col-auto language-container"><a href="/languages/french"><img src="https://flagcdn.com/w160/fr.png" alt="France - French" width="80" height="80" loading="lazy"><p>French</p></a></div>
            <div class="col-auto language-container"><a href="/languages/german"><img src="https://flagcdn.com/w160/de.png" alt="Germany - German" width="80" height="80" loading="lazy"><p>German</p></a></div>
            <div class="col-auto language-container"><a href="/languages/portuguese"><img src="https://flagcdn.com/w160/br.png" alt="Brazil - Portuguese" width="80" height="80" loading="lazy"><p>Portuguese</p></a></div>
            <div class="col-auto language-container"><a href="/languages/italian"><img src="https://flagcdn.com/w160/it.png" alt="Italy - Italian" width="80" height="80" loading="lazy"><p>Italian</p></a></div>
            <div class="col-auto language-container"><a href="/languages/mandarin"><img src="https://flagcdn.com/w160/cn.png" alt="China - Mandarin" width="80" height="80" loading="lazy"><p>Mandarin</p></a></div>
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-12 text-center">
                <p style="color:#999;font-size:14px;">And 90+ more languages available — <a href="#" data-toggle="modal" data-target="#modal-form" style="color:#4db8e8;font-weight:700;">enquire now</a></p>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us - Light -->
<section class="sec-light">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-7 text-center">
                <span class="sec-tag">Why BELTRALACE</span>
                <h3 class="sec-h">The smarter way to learn a language</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4"><div class="why-us-card c1"><div class="why-us-icon i1"><i class="fa fa-user"></i></div><h5>Native-Speaking Trainers</h5><p>Every trainer is a native speaker — authentic pronunciation and real cultural context from day one.</p></div></div>
            <div class="col-lg-3 col-md-6 mb-4"><div class="why-us-card c2"><div class="why-us-icon i2"><i class="fa fa-calendar"></i></div><h5>Flexible Scheduling</h5><p>Book lessons at times that suit you — mornings, evenings or weekends. Online 7 days a week.</p></div></div>
            <div class="col-lg-3 col-md-6 mb-4"><div class="why-us-card c3"><div class="why-us-icon i3"><i class="fa fa-sliders"></i></div><h5>Personalised Learning</h5><p>Tailored to your level, goals and schedule — for travel, business, family or personal enrichment.</p></div></div>
            <div class="col-lg-3 col-md-6 mb-4"><div class="why-us-card c4"><div class="why-us-icon i4"><i class="fa fa-shield"></i></div><h5>Certified &amp; Registered</h5><p>Member of Proz.com and the East Africa Interpreters and Translators Association (EAITA) since 2012.</p></div></div>
        </div>
        <div class="row justify-content-center mt-2">
            <div class="col-12 text-center">
                <span class="membership-badge"><i class="fa fa-check"></i> Proz.com Member</span>
                <span class="membership-badge"><i class="fa fa-check"></i> EAITA Member</span>
                <span class="membership-badge"><i class="fa fa-check"></i> Since 2012</span>
            </div>
        </div>
    </div>
</section>

<!-- Clients - White -->
<section class="clients-bar">
    <div class="container">
        </div>
        <p style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#bbb;text-align:center;margin-bottom:28px;">Trusted by organisations worldwide</p>
        <div class="row align-items-center justify-content-center">
            <div class="col-6 col-md-2 client-logo-item text-center p-3">
                <img src="<?php echo ASSETS; ?>/images/partners/language-hub.jpeg" alt="OJ Language Hub" class="img-fluid" style="max-height:60px;transition:all 0.3s;">
            </div>
            <div class="col-6 col-md-2 client-logo-item text-center p-3">
                <img src="<?php echo ASSETS; ?>/images/partners/language-trainers.jpeg" alt="Language Trainers" class="img-fluid" style="max-height:60px;transition:all 0.3s;">
            </div>
            <div class="col-6 col-md-2 client-logo-item text-center p-3">
                <img src="<?php echo ASSETS; ?>/images/partners/smart-healthcare.jpeg" alt="Smart HealthCare Solutions" class="img-fluid" style="max-height:60px;transition:all 0.3s;">
            </div>
            <div class="col-6 col-md-2 client-logo-item text-center p-3">
                <img src="<?php echo ASSETS; ?>/images/partners/london swahili.jpeg" alt="London Swahili" class="img-fluid" style="max-height:60px;transition:all 0.3s;">
            </div>
            <div class="col-6 col-md-2 client-logo-item text-center p-3">
                <img src="<?php echo ASSETS; ?>/images/partners/Rhumba tribe.jpeg" alt="The Rhumba Tribe" class="img-fluid" style="max-height:60px;transition:all 0.3s;">
            </div>
            <div class="col-6 col-md-2 client-logo-item text-center p-3">
                <div class="client-logo-text">Helen Keller<br>International</div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works - Light -->
<section class="sec-light">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-7 text-center">
                <span class="sec-tag">Simple Process</span>
                <h3 class="sec-h">Start learning in 3 easy steps</h3>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-4 mb-4"><div class="step-card"><div class="step-number">1</div><h5>Choose Your Language</h5><p>Select from 100+ languages and tell us your current level and learning goals.</p></div></div>
            <div class="col-lg-4 col-md-4 mb-4"><div class="step-card"><div class="step-number">2</div><h5>Get Matched with a Trainer</h5><p>We pair you with a qualified native-speaking trainer perfectly suited to your needs.</p></div></div>
            <div class="col-lg-4 col-md-4 mb-4"><div class="step-card"><div class="step-number">3</div><h5>Start Your First Lesson</h5><p>Begin learning online via video call — flexible, convenient and effective from day one.</p></div></div>
        </div>
        <div class="row justify-content-center mt-2">
            <div class="col-auto"><a href="#" class="btn btn-main" data-toggle="modal" data-target="#modal-form"><i class="fa fa-paper-plane mr-2"></i>Get Started Today — It's Free</a></div>
        </div>
    </div>
</section>

<!-- About - White -->
<section class="sec-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-12 mb-4">
                <img src="<?php echo ASSETS; ?>/images/home.jpg" alt="BELTRALACE trainers" class="img-fluid" style="border-radius:16px;box-shadow:0 8px 40px rgba(26,26,110,0.1);" loading="lazy">
            </div>
            <div class="col-lg-6 col-md-12">
                <span class="sec-tag">Who we are</span>
                <h3 class="sec-h">All about languages</h3>
                <p style="color:#555;margin-top:16px;line-height:1.8;">We are a team of qualified professional linguists specializing in language teaching and translation services for individuals, groups and companies across the world.</p>
                <p style="color:#555;line-height:1.8;"><strong style="color:#1a1a6e;">Translation experience:</strong> We have translated documents for <strong>Helen Keller International</strong>, <strong>Smart HealthCare Solution (Perth, Australia)</strong>, and collaborated with <strong>OJ Language Hub</strong> on various translation projects.</p>
                <p style="color:#555;line-height:1.8;"><strong style="color:#1a1a6e;">Teaching partnerships:</strong> We have handled clients for <strong>Language Trainers</strong> (UK) and <strong>Listen &amp; Learn</strong>, connecting our native-speaking trainers with learners worldwide.</p>
                <a href="/about-us" class="btn btn-main mt-2"><i class="fa fa-check mr-2"></i>Learn More About Us</a>
            </div>
        </div>
    </div>
</section>

<!-- Pricing - Navy -->
<section class="pricing-teaser">
    <div class="container text-center">
        <span class="sec-tag" style="color:#f5c518;">Affordable Pricing</span>
        <h2 class="sec-h white" style="margin-top:8px;margin-bottom:10px;">Transparent, No-Hidden-Fee Pricing</h2>
        <p style="color:rgba(255,255,255,0.7);margin-bottom:30px;">Choose the format that works best for you</p>
        <div class="mb-4">
            <div class="price-pill">Group lessons from <span>$8/hr</span></div>
            <div class="price-pill">Private lessons from <span>$40/hr</span></div>
            <div class="price-pill">Crash course from <span>$55/hr</span></div>
        </div>
        <a href="/pricing" class="btn btn-main" style="background:#f5c518;border-color:#f5c518;color:#1a1a6e;font-weight:800;"><i class="fa fa-tag mr-2"></i>See Full Pricing</a>
    </div>
</section>

<!-- Swahili Packages - Light -->
<section class="sec-light">
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-lg-8 text-center">
                <span class="sec-tag">New</span>
                <h3 class="sec-h">Swahili Language Packages</h3>
                <p style="color:#666;">Fixed-price programs — pay once, learn fully. No per-lesson billing.</p>
                <div class="urgency-bar"><i class="fa fa-clock-o mr-2"></i><strong>Intake ongoing</strong> — Start date <strong>May 5th</strong> &nbsp;|&nbsp; <strong style="color:#cc2020;">Limited slots available!</strong></div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-4 mb-4"><div class="pkg-card"><span class="pkg-badge beginner">Beginner · 4 weeks</span><h5>Speak Swahili in 4 Weeks</h5><p>Build core conversational skills from scratch with our beginner's program.</p><div class="pkg-price">KSh 25,000</div><div class="pkg-duration">4-week program</div><a href="/contact-us" class="btn btn-outline-primary btn-block mt-2" style="border-radius:8px;">Enroll Now</a></div></div>
            <div class="col-lg-4 col-md-4 mb-4"><div class="pkg-card featured"><span class="pkg-badge intermediate">Intermediate · 6 weeks</span><br><span style="background:#eaeaf8;color:#1a1a6e;font-size:11px;font-weight:700;padding:4px 12px;border-radius:4px;display:inline-block;margin-bottom:10px;">Most Popular</span><h5>Become a Confident Swahili Speaker in 6 Weeks</h5><p>Intermediate boot camp — gain real-world fluency and confidence.</p><div class="pkg-price">KSh 35,000</div><div class="pkg-duration">6-week boot camp</div><a href="/contact-us" class="btn btn-main btn-block mt-2" style="border-radius:8px;">Enroll Now</a></div></div>
            <div class="col-lg-4 col-md-4 mb-4"><div class="pkg-card"><span class="pkg-badge advanced">Advanced · 10 weeks</span><h5>Advance Your Swahili Skills in 10 Weeks</h5><p>Intensive crash program — master advanced grammar and professional Swahili.</p><div class="pkg-price">KSh 55,000</div><div class="pkg-duration">10-week crash program</div><a href="/contact-us" class="btn btn-outline-primary btn-block mt-2" style="border-radius:8px;">Enroll Now</a></div></div>
        </div>
    </div>
</section>

<!-- Team - White -->
<section class="sec-white">
    <div class="container">
        <div class="row mb-5"><div class="col-12 text-center"><span class="sec-tag">Best Expert Trainers</span><h3 class="sec-h">Meet Our Team</h3></div></div>
        <div class="row align-items-center mb-5">
            <div class="col-lg-3 col-md-4 text-center mb-4">
                <img src="<?php echo ASSETS; ?>/images/bilha.jpeg" alt="Belha" class="img-fluid" style="width:160px;height:160px;border-radius:50%;object-fit:cover;border:5px solid #4db8e8;box-shadow:0 6px 25px rgba(77,184,232,0.25);" loading="lazy">
                <h5 style="margin-top:14px;color:#1a1a6e;font-weight:800;">Belha</h5>
                <p style="color:#4db8e8;font-size:13px;font-weight:700;">Swahili Trainer/Expert</p>
            </div>
            <div class="col-lg-9 col-md-8">
                <p style="color:#444;line-height:1.8;">A University of Nairobi graduate specializing in Swahili and Geography, Belha is a qualified professional Swahili teacher and native speaker. She speaks fluent English and intermediate Mandarin Chinese.</p>
                <p style="color:#444;line-height:1.8;">With over 10 years of experience, she has worked with <strong>Helen Keller International</strong>, <strong>Nairobi Institute of Swahili</strong>, <strong>Language Trainers</strong> (London), and <strong>Listen and Learn</strong>.</p>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-9 col-md-8 order-md-1 order-2">
                <p style="color:#444;line-height:1.8;">Kavulani is a language specialist with vast experience teaching Swahili as both a first and foreign language in a fun, interactive and practical way.</p>
                <p style="color:#444;line-height:1.8;">Having worked for <strong>Cactus Language Center</strong> and <strong>Nairobi Institute of Swahili</strong>, she brings rich cross-cultural teaching experience to every lesson.</p>
            </div>
            <div class="col-lg-3 col-md-4 text-center mb-4 order-md-2 order-1">
                <img src="<?php echo ASSETS; ?>/images/pascalliah.png" alt="Pascalliah" class="img-fluid" style="width:160px;height:160px;border-radius:50%;object-fit:cover;border:5px solid #4db8e8;box-shadow:0 6px 25px rgba(77,184,232,0.25);" loading="lazy">
                <h5 style="margin-top:14px;color:#1a1a6e;font-weight:800;">Pascalliah</h5>
                <p style="color:#4db8e8;font-size:13px;font-weight:700;">Swahili Trainer/Expert</p>
            </div>
        </div>
    </div>
</section>

<!-- Free Taster CTA -->
<section class="pb-0">
    <div class="py-5 c2a1" style="background-image:url(<?php echo ASSETS; ?>/images/cta.jpg);">
        <div class="container"><div class="row justify-content-center"><div class="col-md-7 text-center">
            <h2 class="mb-3 text-white font-weight-medium">Take a free 30-min taster lesson</h2>
            <p class="text-white op-8">Not sure which language or level? Book a free taster and our trainers will guide you.</p>
            <a class="btn btn-main btn-md border-0 text-white mt-3 take-test-btn" href="#"><span>Book Free Taster</span></a>
        </div></div></div>
    </div>
</section>

<!-- Testimonials - Light -->
<section class="sec-light">
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-lg-6 text-center"><span class="sec-tag">Student Reviews</span><h3 class="sec-h">What our clients say</h3></div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-12"><div class="testimonials-slides owl-carousel owl-theme" id="testimonials-slides"></div></div>
        </div>
    </div>
</section>

<!-- FAQ - White -->
<section class="sec-white">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-7 text-center"><span class="sec-tag">Got Questions?</span><h3 class="sec-h">Frequently Asked Questions</h3></div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="faq-item"><div class="faq-question">How do I get started? <i class="fa fa-angle-down"></i></div><div class="faq-answer">Click "Get Started" and fill in our enquiry form. Tell us which language you want to learn and your current level. Our team responds within 24 hours to match you with the right trainer.</div></div>
                <div class="faq-item"><div class="faq-question">Do you offer a free trial lesson? <i class="fa fa-angle-down"></i></div><div class="faq-answer">Yes! New students get a FREE 30-minute taster lesson to meet their trainer and experience our teaching style before committing. No payment required. Click "Book Free Taster" to claim yours.</div></div>
                <div class="faq-item"><div class="faq-question">Are all your trainers native speakers? <i class="fa fa-angle-down"></i></div><div class="faq-answer">Yes — 100% of our trainers are native speakers of the language they teach. This ensures authentic pronunciation, natural expressions, and real cultural context from your very first lesson.</div></div>
                <div class="faq-item"><div class="faq-question">How are lessons delivered? <i class="fa fa-angle-down"></i></div><div class="faq-answer">All lessons are delivered online via Zoom, Google Meet, or Skype. You can learn from anywhere in the world at a time that suits you — no travel required.</div></div>
                <div class="faq-item"><div class="faq-question">What languages do you teach? <i class="fa fa-angle-down"></i></div><div class="faq-answer">We offer lessons in over 100 languages including Swahili, English, French, Spanish, German, Portuguese, Italian, Mandarin, Arabic, Japanese, Korean, Russian and many more. Contact us if you don't see your language listed.</div></div>
                <div class="faq-item"><div class="faq-question">What is the difference between group and private lessons? <i class="fa fa-angle-down"></i></div><div class="faq-answer">Private lessons (from $40/hr) are one-on-one, fully tailored to your pace. Group lessons (from $8/hr per student) are more affordable and great for social learners. Semi-private (2-4 students) at $10/hr offers a middle ground.</div></div>
                <div class="faq-item"><div class="faq-question">What are the Swahili language packages? <i class="fa fa-angle-down"></i></div><div class="faq-answer">Fixed-price structured programs: Beginner (4 weeks, KSh 25,000), Intermediate boot camp (6 weeks, KSh 35,000), and Advanced crash program (10 weeks, KSh 55,000). Next intake starts May 5th — limited slots!</div></div>
                <div class="faq-item"><div class="faq-question">Do you offer weekend lessons? <i class="fa fa-angle-down"></i></div><div class="faq-answer">Yes — we offer lessons 7 days a week including weekends. Our online format means you can book a lesson at any time that suits your schedule, whether early morning or evening.</div></div>
                <div class="faq-item"><div class="faq-question">What is the minimum age for lessons? <i class="fa fa-angle-down"></i></div><div class="faq-answer">We offer language lessons for learners of all ages from young children to adults. Our trainers adapt their teaching style to suit the learner's age and level. Contact us to discuss a suitable programme for your child.</div></div>
                <div class="faq-item"><div class="faq-question">Can I learn a language for a specific purpose? <i class="fa fa-angle-down"></i></div><div class="faq-answer">Absolutely — we specialise in purpose-driven learning: business language, travel preparation, exam preparation (DELF, DALF, Goethe), family connections, and academic purposes. Tell us your goal and we will build a programme around it.</div></div>
                <div class="faq-item"><div class="faq-question">Can I learn multiple languages simultaneously? <i class="fa fa-angle-down"></i></div><div class="faq-answer">Yes — many of our students learn two languages at the same time. We recommend spacing lessons on different days to avoid confusion. Our team can help you build an effective multi-language schedule.</div></div>
                <div class="faq-item"><div class="faq-question">What if I miss a lesson? <i class="fa fa-angle-down"></i></div><div class="faq-answer">Life happens — we understand. If you need to cancel or reschedule, please notify us at least 24 hours in advance and we will rearrange your lesson at no extra cost. Late cancellations may be charged.</div></div>
                <div class="faq-item"><div class="faq-question">Do you provide lesson materials? <i class="fa fa-angle-down"></i></div><div class="faq-answer">Yes — your trainer will provide lesson materials, exercises, and resources tailored to your level and goals. Materials are typically shared digitally before or during the lesson.</div></div>
                <div class="faq-item"><div class="faq-question">Do you offer group discounts? <i class="fa fa-angle-down"></i></div><div class="faq-answer">Yes — our group and semi-private lessons are already priced at a discount ($8/hr and $10/hr respectively). For corporate groups of 5 or more, contact us for a custom package quote.</div></div>
                <div class="faq-item"><div class="faq-question">Can I switch trainers if I'm not happy? <i class="fa fa-angle-down"></i></div><div class="faq-answer">Absolutely. Student satisfaction is our priority. If you feel your trainer is not the right fit, simply contact us and we will match you with another trainer at no extra cost.</div></div>
                <div class="faq-item"><div class="faq-question">How do I pay? <i class="fa fa-angle-down"></i></div><div class="faq-answer">We accept M-Pesa, bank transfer (Kenya and international), and other payment methods. Contact us when enrolling and we will advise on the best payment option for your location.</div></div>
                <div class="faq-item"><div class="faq-question">Do you offer translation services? <i class="fa fa-angle-down"></i></div><div class="faq-answer">Yes — certified translation and interpretation services are available. We have translated documents for Helen Keller International, Smart HealthCare Solution (Perth, Australia), and collaborated with OJ Language Hub. Contact us for a quote.</div></div>
                <div class="faq-item"><div class="faq-question">Is BELTRALACE a registered professional organisation? <i class="fa fa-angle-down"></i></div><div class="faq-answer">Yes. BELTRALACE is a registered member of Proz.com and the East Africa Interpreters and Translators Association (EAITA). We have operated professionally since 2012.</div></div>
                <div class="text-center mt-4"><a href="/faqs" class="btn btn-outline-primary">See All FAQs <i class="fa fa-angle-right ml-1"></i></a></div>
            </div>
        </div>
    </div>
</section>

<!-- Language Tips - Light -->
<section class="sec-light">
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-lg-6 text-center"><span class="sec-tag">Pro Tips</span><h3 class="sec-h">How to learn a language faster</h3></div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <ul class="list-group learning-tips">
                    <li class="list-group-item"><span class="bullet-point">•</span> <span class="tip">Consistency:</span> Regular practice beats long sessions once a week. Even 15 minutes daily makes a huge difference.</li>
                    <li class="list-group-item"><span class="bullet-point">•</span> <span class="tip">Speak from Day One:</span> Don't wait until you're "ready" — start speaking with your trainer from lesson one.</li>
                    <li class="list-group-item"><span class="bullet-point">•</span> <span class="tip">Study and Review:</span> Set aside 30 minutes daily to go over what you've learned. Repetition reinforces memory.</li>
                    <li class="list-group-item"><span class="bullet-point">•</span> <span class="tip">Immerse Yourself:</span> Watch films, listen to music and podcasts in your target language every day.</li>
                    <li class="list-group-item"><span class="bullet-point">•</span> <span class="tip">Set Clear Goals:</span> Know why you are learning — travel, business or family. Goals keep you motivated through difficult moments.</li>
                    <li class="list-group-item"><span class="bullet-point">•</span> <span class="tip">Don't Fear Mistakes:</span> Every mistake is a step forward. Native speakers appreciate the effort — just keep speaking!</li>
                    <li class="list-group-item"><span class="bullet-point">•</span> <span class="tip">Use Learning Aids:</span> Flashcards, language apps, and crosswords make learning fun and reinforce vocabulary.</li>
                    <li class="list-group-item"><span class="bullet-point">•</span> <span class="tip">Test Yourself:</span> Take periodic tests to track your progress. Seeing improvement is the best motivation.</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Final CTA -->
<section class="final-cta">
    <div class="container">
        <h2>Ready to start your language journey?</h2>
        <p>Join 500+ students who have learned a new language with BELTRALACE native-speaking trainers.<br>Your first lesson is FREE — no commitment required.</p>
        <a href="#" class="btn-white" data-toggle="modal" data-target="#modal-form"><i class="fa fa-paper-plane mr-2"></i>Get Started — It's Free</a>
        <a href="/pricing" class="btn-outline-white"><i class="fa fa-tag mr-2"></i>View Pricing</a>
    </div>
</section>

<script>
$(document).ready(function() {

    // ===== 10 ROTATING TESTIMONIAL POPUPS =====
    var testimonials = [
        { name: "Kennedy Kaunda", role: "Korean Student", text: "BELTRALACE matched me with a fantastic native Korean trainer. Within 3 months I could hold basic conversations!" },
        { name: "Beverly Wafula", role: "German Student", text: "The flexible scheduling is amazing — I book lessons around my busy work schedule. My German has improved so much." },
        { name: "Elliye Yare", role: "Swahili Student", text: "As a foreigner learning Swahili, having a native speaker made all the difference. Lessons are fun and very practical." },
        { name: "Abdikadir Hussein", role: "Swahili Student", text: "Professional trainers who truly care about your progress. I started from zero and now speak with confidence." },
        { name: "Sarah Mitchell", role: "French Student", text: "I needed French for a work assignment in Paris. BELTRALACE got me conversational in just 2 months — incredible!" },
        { name: "James Omondi", role: "Spanish Student", text: "The personalised approach is what sets BELTRALACE apart. My trainer adapted every lesson to my learning style." },
        { name: "Fatuma Abubakar", role: "English Student", text: "My English has improved dramatically. My trainer is patient, professional and makes every lesson enjoyable." },
        { name: "David Kimani", role: "Mandarin Student", text: "Learning Mandarin seemed impossible but my BELTRALACE trainer made it approachable step by step." },
        { name: "Maria Santos", role: "Swahili Student", text: "I learned Swahili to connect with my Kenyan colleagues. Within 6 weeks I was greeting them in their language!" },
        { name: "Ahmed Hassan", role: "Portuguese Student", text: "Excellent service from start to finish. Easy booking, superb trainer, and results came quickly." }
    ];

    var currentIndex = 0;

    function showPopup(index) {
        $('#testimonialPopup').remove();
        var t = testimonials[index];
        var html = '<div class="testimonial-popup" id="testimonialPopup">' +
            '<button class="close-popup" id="closePopup">&times;</button>' +
            '<div class="popup-header">' +
            '<div class="popup-avatar">' + t.name.charAt(0) + '</div>' +
            '<div><p class="popup-name">' + t.name + '</p><p class="popup-role">' + t.role + '</p></div></div>' +
            '<div class="popup-stars"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>' +
            '<p class="popup-text">"' + t.text + '"</p>' +
            '<span class="popup-verified"><i class="fa fa-check"></i> Verified Review</span></div>';
        $('body').append(html);
        setTimeout(function() { $('#testimonialPopup').addClass('show'); }, 300);
        $(document).on('click', '#closePopup', function() {
            $('#testimonialPopup').removeClass('show');
            setTimeout(function() { $('#testimonialPopup').remove(); }, 600);
        });
    }

    setTimeout(function() {
        showPopup(currentIndex);
        setInterval(function() {
            $('#testimonialPopup').removeClass('show');
            setTimeout(function() {
                currentIndex = (currentIndex + 1) % testimonials.length;
                showPopup(currentIndex);
            }, 700);
        }, 20000);
    }, 1500);

    // ===== FAQ =====
    $('.faq-question').on('click', function() {
        var parent = $(this).closest('.faq-item');
        $('.faq-item').not(parent).removeClass('active');
        parent.toggleClass('active');
    });

    // ===== TASTER =====
    $(document).on('click', '.take-test-btn', function(e) {
        e.preventDefault();
        $('.cta-title').text('Book a Free 30-Min Taster');
        $('.cta-subtitle').addClass('d-none');
        $('#modal-form').modal('show');
    });

    // ===== TESTIMONIALS CAROUSEL =====
    loadTestimonials();
});

function loadTestimonials() {
    var reviews = [
        { body: "BELTRALACE matched me with a fantastic native Korean trainer. Within 3 months I could hold basic conversations. Highly recommend!", name: "Kennedy Kaunda", role: "Korean Student" },
        { body: "The flexible scheduling is amazing — I book lessons around my busy work schedule. My German has improved tremendously.", name: "Beverly Wafula", role: "German Student" },
        { body: "As a foreigner learning Swahili, having a native speaker made all the difference. The lessons are fun and very practical.", name: "Elliye Yare", role: "Swahili Student" },
        { body: "Professional trainers who truly care about your progress. I started from zero and can now speak with confidence.", name: "Abdikadir Hussein", role: "Swahili Student" },
        { body: "I needed French for a work assignment in Paris. BELTRALACE got me conversational in just 2 months — incredible!", name: "Sarah Mitchell", role: "French Student" },
        { body: "The personalised approach is what sets BELTRALACE apart. My trainer adapted every lesson to my learning style.", name: "James Omondi", role: "Spanish Student" },
        { body: "My English has improved dramatically since starting with BELTRALACE. Patient, professional and fun trainer.", name: "Fatuma Abubakar", role: "English Student" },
        { body: "Learning Mandarin seemed impossible but my BELTRALACE trainer made it approachable step by step. Amazing!", name: "David Kimani", role: "Mandarin Student" },
        { body: "I learned Swahili to connect with my Kenyan colleagues. Within 6 weeks I was greeting them in their language!", name: "Maria Santos", role: "Swahili Student" },
        { body: "Excellent service from start to finish. Easy booking, superb trainer, and results came quickly.", name: "Ahmed Hassan", role: "Portuguese Student" }
    ];
    var html = "";
    reviews.forEach(function(v) {
        var initials = v.name.split(' ').map(function(n) { return n[0]; }).join('');
        html += '<div class="review-item"><div class="client-info"><i class="fa fa-quote-left"></i><p>' + v.body + '</p>' +
            '<div class="rating"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div></div>' +
            '<div class="client-desc"><div class="client-img"><div style="width:60px;height:60px;border-radius:50%;background:linear-gradient(135deg,#1a1a6e,#4db8e8);display:flex;align-items:center;justify-content:center;color:#fff;font-size:16px;font-weight:800;border:3px solid #f5c518;">' + initials + '</div></div>' +
            '<div class="client-text"><h4>' + v.name + '</h4><span class="designation">' + v.role + '</span></div></div></div>';
    });
    $("#testimonials-slides").html(html);
    $('#testimonials-slides').owlCarousel({
        loop: true, margin: 20, nav: true, dots: true, autoplay: true, autoplayTimeout: 5000,
        responsive: { 0: { items: 1 }, 600: { items: 2 }, 1000: { items: 3 } }
    });
}
</script>
