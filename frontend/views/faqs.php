<?php
$faqs_by_category = array();
try {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, API);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
        'object' => 'FAQ',
        'action' => 'get_published_grouped',
    )));
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    $response = curl_exec($ch);
    curl_close($ch);
    if ($response) {
        $decoded = json_decode($response, true);
        if (is_array($decoded)) {
            $faqs_by_category = $decoded;
        }
    }
} catch (Throwable $th) {
    error_log('FAQ fetch failed: ' . $th->getMessage());
}

$faq_categories = array(
    array('name' => 'Getting Started',       'icon' => 'fa-play-circle'),
    array('name' => 'Lessons & Delivery',    'icon' => 'fa-video-camera'),
    array('name' => 'Languages & Trainers',  'icon' => 'fa-globe'),
    array('name' => 'Pricing & Packages',    'icon' => 'fa-tag'),
    array('name' => 'Translation Services',  'icon' => 'fa-file-text'),
    array('name' => 'About BELTRALACE',      'icon' => 'fa-building'),
);
?>
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
.faq-empty { text-align: center; color: #777; padding: 40px 20px; font-style: italic; }
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

        <div class="faq-search">
            <input type="text" id="faqSearch" placeholder="Search questions..." onkeyup="filterFAQs()">
            <i class="fa fa-search"></i>
        </div>

        <div id="faqContainer">
<?php
$has_any = false;
foreach ($faq_categories as $cat_index => $cat):
    $items = isset($faqs_by_category[$cat['name']]) ? $faqs_by_category[$cat['name']] : array();
    if (empty($items)) continue;
    $has_any = true;
    $accordion_id = 'faq-cat-' . $cat_index;
?>
        <div class="faq-category-title"><i class="fa <?php echo htmlspecialchars($cat['icon'], ENT_QUOTES); ?>"></i> <?php echo htmlspecialchars($cat['name'], ENT_QUOTES); ?></div>
        <div class="faq-accordion" id="<?php echo $accordion_id; ?>">
<?php
    $first_in_category = true;
    foreach ($items as $item):
        $item_id = 'faq-item-' . intval($item['id']);
        $btn_class = $first_in_category ? 'faq-btn' : 'faq-btn collapsed';
        $body_class = $first_in_category ? 'collapse show' : 'collapse';
        $first_in_category = false;
?>
            <div class="faq-card">
                <div class="faq-card-header">
                    <h5 class="mb-0">
                        <button class="<?php echo $btn_class; ?>" data-toggle="collapse" data-target="#<?php echo $item_id; ?>">
                            <?php echo htmlspecialchars($item['question'], ENT_QUOTES); ?>
                            <span></span>
                        </button>
                    </h5>
                </div>
                <div id="<?php echo $item_id; ?>" class="<?php echo $body_class; ?>" data-parent="#<?php echo $accordion_id; ?>">
                    <div class="faq-card-body"><?php echo $item['answer']; ?></div>
                </div>
            </div>
<?php endforeach; ?>
        </div>
<?php endforeach; ?>
<?php if (!$has_any): ?>
        <div class="faq-empty">No FAQs have been published yet. Please check back soon.</div>
<?php endif; ?>
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

<?php if ($has_any): ?>
<script type="application/ld+json">
<?php
$json_ld_entities = array();
foreach ($faq_categories as $cat) {
    $items = isset($faqs_by_category[$cat['name']]) ? $faqs_by_category[$cat['name']] : array();
    foreach ($items as $item) {
        $json_ld_entities[] = array(
            '@type' => 'Question',
            'name' => strip_tags($item['question']),
            'acceptedAnswer' => array(
                '@type' => 'Answer',
                'text' => trim(strip_tags($item['answer'])),
            ),
        );
    }
}
echo json_encode(array(
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => $json_ld_entities,
), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
?>
</script>
<?php endif; ?>

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
