<style>
.faq-hero { background: linear-gradient(135deg, #1a1a6e, #2a2aae); padding: 80px 0; text-align: center; color: #fff; }
.faq-hero h1 { font-size: 36px; font-weight: 900; color: #fff; margin-bottom: 10px; }
.faq-hero p { color: rgba(255,255,255,0.8); font-size: 16px; }
.faq-category-title { font-size: 20px; font-weight: 800; color: #1a1a6e; margin: 40px 0 16px; padding-bottom: 10px; border-bottom: 3px solid #4db8e8; display: flex; align-items: center; gap: 10px; }
.faq-category-title i { color: #4db8e8; font-size: 18px; }
.faq-card { border: none; border-bottom: 1px solid #e8f0fe; margin-bottom: 0; border-radius: 0 !important; }
.faq-card-header { background: #fff; padding: 0; }
.faq-btn { width: 100%; text-align: left; background: none; border: none; padding: 18px 20px 18px 0; font-size: 15px; font-weight: 700; color: #1a1a6e; cursor: pointer; display: flex; justify-content: space-between; align-items: center; transition: color 0.2s; }
.faq-btn:not(.collapsed) { color: #4db8e8; }
.faq-btn::after { content: '\f107'; font-family: 'FontAwesome'; font-size: 16px; color: #4db8e8; transition: transform 0.3s; flex-shrink: 0; }
.faq-btn.collapsed::after { transform: rotate(0deg); }
.faq-btn:not(.collapsed)::after { transform: rotate(180deg); }
.faq-card-body { padding: 0 0 18px 0; font-size: 14px; color: #555; line-height: 1.8; }
.faq-cta { background: linear-gradient(135deg, #4db8e8, #1a1a6e); padding: 60px 0; text-align: center; color: #fff; margin-top: 40px; }
.faq-cta h3 { font-size: 28px; font-weight: 800; color: #fff; margin-bottom: 10px; }
.faq-cta p { color: rgba(255,255,255,0.85); margin-bottom: 24px; }
.faq-search { max-width: 500px; margin: 0 auto 40px; position: relative; }
.faq-search input { width: 100%; padding: 14px 50px 14px 20px; border: 2px solid #e0e8f8; border-radius: 50px; font-size: 15px; outline: none; }
.faq-search input:focus { border-color: #4db8e8; }
.faq-search i { position: absolute; right: 18px; top: 16px; color: #4db8e8; font-size: 16px; }
</style>

<!-- Hero -->
<section class="faq-hero">
    <div class="container">
        <h1>Frequently Asked Questions</h1>
        <p>Everything you need to know about BELTRALACE language courses and services</p>
        <nav aria-label="breadcrumb" style="margin-top:16px;">
            <ol class="breadcrumb justify-content-center" style="background:transparent;">
                <li class="breadcrumb-item"><a href="/" style="color:#f5c518;">Home</a></li>
                <li class="breadcrumb-item active" style="color:rgba(255,255,255,0.7);">FAQs</li>
            </ol>
        </nav>
    </div>
</section>

<section class="section-padding">
    <div class="container">

        <!-- Search -->
        <div class="faq-search">
            <input type="text" id="faqSearch" placeholder="Search questions..." onkeyup="filterFAQs()">
            <i class="fa fa-search"></i>
        </div>

        <div id="faqContainer">

        <!-- GETTING STARTED -->
        <div class="faq-category-title"><i class="fa fa-play-circle"></i> Getting Started</div>
        <div class="faq-accordion" id="faqStart">
            <div class="faq-card">
                <div class="faq-card-header"><h5 class="mb-0"><button class="faq-btn" data-toggle="collapse" data-target="#s1">How do I get started with BELTRALACE? <span></span></button></h5></div>
                <div id="s1" class="collapse show" data-parent="#faqStart"><div class="faq-card-body">Click "Get Started" on our homepage and fill in the enquiry form. Tell us which language you want to learn and your current level. Our team will respond within 24 hours to match you with the right trainer and schedule your first lesson.</div></div>
            </div>
            <div class="faq-card">
                <div class="faq-card-header"><h5 class="mb-0"><button class="faq-btn collapsed" data-toggle="collapse" data-target="#s2">Do you offer a free trial lesson? <span></span></button></h5></div>
                <div id="s2" class="collapse" data-parent="#faqStart"><div class="faq-card-body">Yes! New students get a FREE 30-minute taster lesson to meet their trainer and experience our teaching style before committing to a full programme. No payment is required. Simply click "Book Free Taster" on our homepage.</div></div>
            </div>
            <div class="faq-card">
                <div class="faq-card-header"><h5 class="mb-0"><button class="faq-btn collapsed" data-toggle="collapse" data-target="#s3">How quickly can I start lessons? <span></span></button></h5></div>
                <div id="s3" class="collapse" data-parent="#faqStart"><div class="faq-card-body">In most cases you can start within 24–48 hours of enquiring. Once you submit the form, our team will contact you to confirm your trainer, schedule and first lesson date.</div></div>
            </div>
            <div class="faq-card">
                <div class="faq-card-header"><h5 class="mb-0"><button class="faq-btn collapsed" data-toggle="collapse" data-target="#s4">Do I need to create an account? <span></span></button></h5></div>
                <div id="s4" class="collapse" data-parent="#faqStart"><div class="faq-card-body">No account creation is needed to enquire. Simply fill in our contact form and our team will take care of everything from there — trainer matching, scheduling, and onboarding.</div></div>
            </div>
        </div>

        <!-- LESSONS & DELIVERY -->
        <div class="faq-category-title"><i class="fa fa-video-camera"></i> Lessons & Delivery</div>
        <div class="faq-accordion" id="faqLessons">
            <div class="faq-card">
                <div class="faq-card-header"><h5 class="mb-0"><button class="faq-btn collapsed" data-toggle="collapse" data-target="#l1">How are lessons delivered? <span></span></button></h5></div>
                <div id="l1" class="collapse" data-parent="#faqLessons"><div class="faq-card-body">All lessons are delivered online via video conferencing platforms such as Zoom, Google Meet, or Skype. This means you can learn from anywhere in the world at a time that suits you — no travel required.</div></div>
            </div>
            <div class="faq-card">
                <div class="faq-card-header"><h5 class="mb-0"><button class="faq-btn collapsed" data-toggle="collapse" data-target="#l2">Do you offer face-to-face lessons? <span></span></button></h5></div>
                <div id="l2" class="collapse" data-parent="#faqLessons"><div class="faq-card-body">Yes — face-to-face lessons are available for students based in Nairobi, Kenya. Our private lesson package table on the Pricing page shows both virtual (worldwide) and face-to-face (Nairobi) rates.</div></div>
            </div>
            <div class="faq-card">
                <div class="faq-card-header"><h5 class="mb-0"><button class="faq-btn collapsed" data-toggle="collapse" data-target="#l3">What is the difference between group, semi-private, and private lessons? <span></span></button></h5></div>
                <div id="l3" class="collapse" data-parent="#faqLessons"><div class="faq-card-body">Private lessons ($40/hr) are one-on-one with a trainer, fully tailored to your pace and goals. Semi-private lessons ($10/hr per student) are for 2–4 students sharing a session. Group lessons ($8/hr per student) are for 5 or more students. Group lessons are more affordable; private lessons offer maximum personalisation.</div></div>
            </div>
            <div class="faq-card">
                <div class="faq-card-header"><h5 class="mb-0"><button class="faq-btn collapsed" data-toggle="collapse" data-target="#l4">How long is each lesson? <span></span></button></h5></div>
                <div id="l4" class="collapse" data-parent="#faqLessons"><div class="faq-card-body">Standard lessons are 60 minutes. Crash course sessions can run up to 90 minutes for students who wish to cover more content in less time. Lesson duration can be discussed with your trainer during onboarding.</div></div>
            </div>
            <div class="faq-card">
                <div class="faq-card-header"><h5 class="mb-0"><button class="faq-btn collapsed" data-toggle="collapse" data-target="#l5">Do you offer weekend lessons? <span></span></button></h5></div>
                <div id="l5" class="collapse" data-parent="#faqLessons"><div class="faq-card-body">Yes — we offer lessons 7 days a week including weekends. Our online format means you can book a lesson at any time that fits your schedule, whether early morning or evening.</div></div>
            </div>
            <div class="faq-card">
                <div class="faq-card-header"><h5 class="mb-0"><button class="faq-btn collapsed" data-toggle="collapse" data-target="#l6">What if I miss a lesson? <span></span></button></h5></div>
                <div id="l6" class="collapse" data-parent="#faqLessons"><div class="faq-card-body">Life happens — we understand. If you need to cancel or reschedule, please notify us at least 24 hours in advance and we will rearrange your lesson at no extra cost. Late cancellations may be charged at the trainer's discretion.</div></div>
            </div>
            <div class="faq-card">
                <div class="faq-card-header"><h5 class="mb-0"><button class="faq-btn collapsed" data-toggle="collapse" data-target="#l7">Do you provide lesson materials? <span></span></button></h5></div>
                <div id="l7" class="collapse" data-parent="#faqLessons"><div class="faq-card-body">Yes — your trainer will provide lesson materials, exercises, vocabulary lists, and resources tailored to your level and goals. Materials are typically shared digitally before or during the lesson.</div></div>
            </div>
            <div class="faq-card">
                <div class="faq-card-header"><h5 class="mb-0"><button class="faq-btn collapsed" data-toggle="collapse" data-target="#l8">Can I record my lessons? <span></span></button></h5></div>
                <div id="l8" class="collapse" data-parent="#faqLessons"><div class="faq-card-body">You may record lessons for personal study purposes with your trainer's consent. We recommend discussing this with your trainer at the start of your programme.</div></div>
            </div>
        </div>

        <!-- LANGUAGES & TRAINERS -->
        <div class="faq-category-title"><i class="fa fa-globe"></i> Languages & Trainers</div>
        <div class="faq-accordion" id="faqLang">
            <div class="faq-card">
                <div class="faq-card-header"><h5 class="mb-0"><button class="faq-btn collapsed" data-toggle="collapse" data-target="#lg1">What languages do you teach? <span></span></button></h5></div>
                <div id="lg1" class="collapse" data-parent="#faqLang"><div class="faq-card-body">We offer lessons in over 100 languages including Swahili, English, French, Spanish, German, Portuguese, Italian, Mandarin Chinese, Arabic, Japanese, Korean, Russian, Hindi, Dutch, and many more. Contact us if you don't see your language listed — we will do our best to find you a suitable trainer.</div></div>
            </div>
            <div class="faq-card">
                <div class="faq-card-header"><h5 class="mb-0"><button class="faq-btn collapsed" data-toggle="collapse" data-target="#lg2">Are all your trainers native speakers? <span></span></button></h5></div>
                <div id="lg2" class="collapse" data-parent="#faqLang"><div class="faq-card-body">Yes — 100% of our trainers are native speakers of the language they teach. This ensures you learn authentic pronunciation, natural expressions, and real cultural context from your very first lesson. All trainers are also qualified and experienced language educators.</div></div>
            </div>
            <div class="faq-card">
                <div class="faq-card-header"><h5 class="mb-0"><button class="faq-btn collapsed" data-toggle="collapse" data-target="#lg3">Can I switch trainers if I am not happy? <span></span></button></h5></div>
                <div id="lg3" class="collapse" data-parent="#faqLang"><div class="faq-card-body">Absolutely. Student satisfaction is our priority. If you feel your trainer is not the right fit — whether in terms of teaching style, pace, or personality — simply contact us and we will match you with another trainer at no extra cost.</div></div>
            </div>
            <div class="faq-card">
                <div class="faq-card-header"><h5 class="mb-0"><button class="faq-btn collapsed" data-toggle="collapse" data-target="#lg4">Can I learn multiple languages at the same time? <span></span></button></h5></div>
                <div id="lg4" class="collapse" data-parent="#faqLang"><div class="faq-card-body">Yes — many of our students learn two or even three languages simultaneously. We recommend spacing lessons on different days to avoid confusion between languages. Our team can help you build an effective multi-language schedule.</div></div>
            </div>
            <div class="faq-card">
                <div class="faq-card-header"><h5 class="mb-0"><button class="faq-btn collapsed" data-toggle="collapse" data-target="#lg5">Can I learn a language for a specific purpose? <span></span></button></h5></div>
                <div id="lg5" class="collapse" data-parent="#faqLang"><div class="faq-card-body">Absolutely — we specialise in purpose-driven learning: business language, travel preparation, exam preparation (DELF, DALF, Goethe, HSK), family connections, missionary and NGO work, and academic purposes. Tell us your goal and we will build a programme tailored around it.</div></div>
            </div>
            <div class="faq-card">
                <div class="faq-card-header"><h5 class="mb-0"><button class="faq-btn collapsed" data-toggle="collapse" data-target="#lg6">What is the minimum age for lessons? <span></span></button></h5></div>
                <div id="lg6" class="collapse" data-parent="#faqLang"><div class="faq-card-body">We offer language lessons for learners of all ages — from young children to adults and seniors. Our trainers are experienced in adapting their teaching style to suit the learner's age and level. Contact us to discuss a suitable programme for your child.</div></div>
            </div>
            <div class="faq-card">
                <div class="faq-card-header"><h5 class="mb-0"><button class="faq-btn collapsed" data-toggle="collapse" data-target="#lg7">How long does it take to learn a new language? <span></span></button></h5></div>
                <div id="lg7" class="collapse" data-parent="#faqLang"><div class="faq-card-body">It depends on the language, your starting level, and how much time you practise. With consistent daily effort, most students can hold basic conversations within 3 months. Our native-speaking trainers will set realistic milestones based on your specific goals.</div></div>
            </div>
        </div>

        <!-- PRICING & PACKAGES -->
        <div class="faq-category-title"><i class="fa fa-tag"></i> Pricing & Packages</div>
        <div class="faq-accordion" id="faqPrice">
            <div class="faq-card">
                <div class="faq-card-header"><h5 class="mb-0"><button class="faq-btn collapsed" data-toggle="collapse" data-target="#p1">How much do lessons cost? <span></span></button></h5></div>
                <div id="p1" class="collapse" data-parent="#faqPrice"><div class="faq-card-body">Our rates are: Group lessons (5+ students) — $8/hr per student. Semi-private (2–4 students) — $10/hr per student. Private lessons — $40/hr. Crash course — $55/hr. Private package rates vary by hours committed — see our full pricing table on the <a href="/pricing" style="color:#4db8e8;">Pricing page</a>.</div></div>
            </div>
            <div class="faq-card">
                <div class="faq-card-header"><h5 class="mb-0"><button class="faq-btn collapsed" data-toggle="collapse" data-target="#p2">What are the Swahili language packages? <span></span></button></h5></div>
                <div id="p2" class="collapse" data-parent="#faqPrice"><div class="faq-card-body">We offer three fixed-price Swahili programs: Beginner (4 weeks, KSh 25,000) — build core conversational skills. Intermediate Boot Camp (6 weeks, KSh 35,000) — gain real-world fluency. Advanced Crash Program (10 weeks, KSh 55,000) — master advanced grammar and professional Swahili. All packages have a fixed price — no per-lesson billing.</div></div>
            </div>
            <div class="faq-card">
                <div class="faq-card-header"><h5 class="mb-0"><button class="faq-btn collapsed" data-toggle="collapse" data-target="#p3">Do you offer group discounts? <span></span></button></h5></div>
                <div id="p3" class="collapse" data-parent="#faqPrice"><div class="faq-card-body">Yes — group and semi-private lessons are already discounted compared to private rates. For corporate groups of 5 or more, contact us for a custom package quote. We regularly work with NGOs, businesses, and organisations on tailored group programmes.</div></div>
            </div>
            <div class="faq-card">
                <div class="faq-card-header"><h5 class="mb-0"><button class="faq-btn collapsed" data-toggle="collapse" data-target="#p4">How do I pay? <span></span></button></h5></div>
                <div id="p4" class="collapse" data-parent="#faqPrice"><div class="faq-card-body">We accept M-Pesa, bank transfer (Kenya and international), and other payment methods depending on your location. Contact us when enrolling and our team will advise on the most convenient payment option for you.</div></div>
            </div>
            <div class="faq-card">
                <div class="faq-card-header"><h5 class="mb-0"><button class="faq-btn collapsed" data-toggle="collapse" data-target="#p5">Is there a refund policy? <span></span></button></h5></div>
                <div id="p5" class="collapse" data-parent="#faqPrice"><div class="faq-card-body">We offer a satisfaction guarantee. If you are not happy after your first paid lesson, contact us and we will do our best to resolve the issue — either by reassigning your trainer or discussing a suitable arrangement. Please contact us within 7 days of your first lesson.</div></div>
            </div>
            <div class="faq-card">
                <div class="faq-card-header"><h5 class="mb-0"><button class="faq-btn collapsed" data-toggle="collapse" data-target="#p6">Do you offer corporate language training? <span></span></button></h5></div>
                <div id="p6" class="collapse" data-parent="#faqPrice"><div class="faq-card-body">Yes — we offer corporate language training packages tailored for businesses, NGOs, government agencies, and organisations. We have previously provided training for Helen Keller International and Smart HealthCare Solution among others. Contact us for a corporate quote.</div></div>
            </div>
        </div>

        <!-- TRANSLATION SERVICES -->
        <div class="faq-category-title"><i class="fa fa-file-text"></i> Translation Services</div>
        <div class="faq-accordion" id="faqTrans">
            <div class="faq-card">
                <div class="faq-card-header"><h5 class="mb-0"><button class="faq-btn collapsed" data-toggle="collapse" data-target="#t1">Do you offer translation services? <span></span></button></h5></div>
                <div id="t1" class="collapse" data-parent="#faqTrans"><div class="faq-card-body">Yes — we offer certified translation and interpretation services across many language pairs. We have translated documents for Helen Keller International, Smart HealthCare Solution, and collaborated with OJ Language Hub on various translation projects. Contact us with your document and language pair for a quote.</div></div>
            </div>
            <div class="faq-card">
                <div class="faq-card-header"><h5 class="mb-0"><button class="faq-btn collapsed" data-toggle="collapse" data-target="#t2">What types of translation do you offer? <span></span></button></h5></div>
                <div id="t2" class="collapse" data-parent="#faqTrans"><div class="faq-card-body">We offer document translation, community service document translation, legal translation, business translation, interpretation (simultaneous and consecutive), subtitling, transcription, and voice-over services. Contact us to discuss your specific requirements.</div></div>
            </div>
            <div class="faq-card">
                <div class="faq-card-header"><h5 class="mb-0"><button class="faq-btn collapsed" data-toggle="collapse" data-target="#t3">How do I get a translation quote? <span></span></button></h5></div>
                <div id="t3" class="collapse" data-parent="#faqTrans"><div class="faq-card-body">Contact us via email at info@beltralace.com or through our contact form. Share the document you need translated, the source and target languages, and your deadline. We will get back to you with a quote within 24 hours.</div></div>
            </div>
            <div class="faq-card">
                <div class="faq-card-header"><h5 class="mb-0"><button class="faq-btn collapsed" data-toggle="collapse" data-target="#t4">Are your translations certified? <span></span></button></h5></div>
                <div id="t4" class="collapse" data-parent="#faqTrans"><div class="faq-card-body">Yes — BELTRALACE is a registered member of Proz.com (the world's leading professional translation platform) and the East Africa Interpreters and Translators Association (EAITA). Our translations are carried out by qualified professional linguists.</div></div>
            </div>
        </div>

        <!-- ABOUT BELTRALACE -->
        <div class="faq-category-title"><i class="fa fa-building"></i> About BELTRALACE</div>
        <div class="faq-accordion" id="faqAbout">
            <div class="faq-card">
                <div class="faq-card-header"><h5 class="mb-0"><button class="faq-btn collapsed" data-toggle="collapse" data-target="#a1">Is BELTRALACE a registered professional organisation? <span></span></button></h5></div>
                <div id="a1" class="collapse" data-parent="#faqAbout"><div class="faq-card-body">Yes. BELTRALACE (Belxin Translators and Language Centre) is a registered member of Proz.com and the East Africa Interpreters and Translators Association (EAITA). We have operated professionally since 2012.</div></div>
            </div>
            <div class="faq-card">
                <div class="faq-card-header"><h5 class="mb-0"><button class="faq-btn collapsed" data-toggle="collapse" data-target="#a2">Where is BELTRALACE based? <span></span></button></h5></div>
                <div id="a2" class="collapse" data-parent="#faqAbout"><div class="faq-card-body">BELTRALACE is based in Nairobi, Kenya, but operates as an online language school serving students worldwide. Face-to-face lessons are available for students in Nairobi.</div></div>
            </div>
            <div class="faq-card">
                <div class="faq-card-header"><h5 class="mb-0"><button class="faq-btn collapsed" data-toggle="collapse" data-target="#a3">How do I become a language trainer at BELTRALACE? <span></span></button></h5></div>
                <div id="a3" class="collapse" data-parent="#faqAbout"><div class="faq-card-body">We are always looking for qualified native-speaking language trainers. Visit our <a href="/teaching-jobs" style="color:#4db8e8;">Teaching Jobs page</a> to submit your application with your CV, cover letter, and passport photo.</div></div>
            </div>
            <div class="faq-card">
                <div class="faq-card-header"><h5 class="mb-0"><button class="faq-btn collapsed" data-toggle="collapse" data-target="#a4">How can I contact BELTRALACE? <span></span></button></h5></div>
                <div id="a4" class="collapse" data-parent="#faqAbout"><div class="faq-card-body">You can reach us by email at info@beltralace.com, by phone at +254 724 736 255, via WhatsApp at the same number, or through our <a href="/contact-us" style="color:#4db8e8;">Contact page</a>. We typically respond within 24 hours.</div></div>
            </div>
        </div>

        </div><!-- end faqContainer -->

        <!-- CTA -->
        <div class="faq-cta">
            <div class="container">
                <h3>Still have questions?</h3>
                <p>Our team is happy to help — get in touch and we will respond within 24 hours.</p>
                <a href="#" class="btn btn-main mr-3" style="background:#f5c518;border-color:#f5c518;color:#1a1a6e;font-weight:800;" data-toggle="modal" data-target="#modal-form">
                    <i class="fa fa-paper-plane mr-2"></i>Get Started — It's Free
                </a>
                <a href="/contact-us" class="btn btn-outline-light">
                    <i class="fa fa-envelope mr-2"></i>Contact Us
                </a>
            </div>
        </div>

    </div>
</section>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {"@type":"Question","name":"How do I get started with BELTRALACE?","acceptedAnswer":{"@type":"Answer","text":"Click Get Started on our homepage and fill in the enquiry form. Our team will respond within 24 hours to match you with the right trainer."}},
    {"@type":"Question","name":"Do you offer a free trial lesson?","acceptedAnswer":{"@type":"Answer","text":"Yes — new students get a FREE 30-minute taster lesson before committing to a full programme."}},
    {"@type":"Question","name":"Are all your trainers native speakers?","acceptedAnswer":{"@type":"Answer","text":"Yes — 100% of our trainers are native speakers of the language they teach."}},
    {"@type":"Question","name":"What languages do you teach?","acceptedAnswer":{"@type":"Answer","text":"We offer lessons in over 100 languages including Swahili, English, French, Spanish, German, Portuguese, Italian, Mandarin, Arabic and more."}},
    {"@type":"Question","name":"How much do lessons cost?","acceptedAnswer":{"@type":"Answer","text":"Group lessons from $8/hr per student, semi-private from $10/hr, private lessons from $40/hr, crash course $55/hr."}},
    {"@type":"Question","name":"What are the Swahili language packages?","acceptedAnswer":{"@type":"Answer","text":"Beginner 4 weeks KSh 25,000. Intermediate boot camp 6 weeks KSh 35,000. Advanced crash program 10 weeks KSh 55,000."}},
    {"@type":"Question","name":"Do you offer translation services?","acceptedAnswer":{"@type":"Answer","text":"Yes — certified translation and interpretation services. We have worked with Helen Keller International, Smart HealthCare Solution, and OJ Language Hub."}},
    {"@type":"Question","name":"Is BELTRALACE a registered professional organisation?","acceptedAnswer":{"@type":"Answer","text":"Yes — registered member of Proz.com and the East Africa Interpreters and Translators Association (EAITA) since 2012."}},
    {"@type":"Question","name":"How do I pay?","acceptedAnswer":{"@type":"Answer","text":"We accept M-Pesa, bank transfer (Kenya and international), and other payment methods."}},
    {"@type":"Question","name":"Can I switch trainers if I am not happy?","acceptedAnswer":{"@type":"Answer","text":"Yes — simply contact us and we will match you with another trainer at no extra cost."}}
  ]
}
</script>

<script>
function filterFAQs() {
    var input = document.getElementById('faqSearch').value.toLowerCase();
    var cards = document.querySelectorAll('.faq-card');
    cards.forEach(function(card) {
        var text = card.textContent.toLowerCase();
        card.style.display = text.includes(input) ? '' : 'none';
    });
    var categories = document.querySelectorAll('.faq-category-title');
    categories.forEach(function(cat) {
        var next = cat.nextElementSibling;
        var visible = next ? next.querySelectorAll('.faq-card:not([style*="display: none"])').length : 0;
        cat.style.display = visible > 0 ? '' : 'none';
    });
}
</script>
