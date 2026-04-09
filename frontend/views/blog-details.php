<?php
// ── Fetch the blog post server-side ──────────────────────────────────────────
$post = null;
try {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, API . '?object=BlogArticle&action=get_by_slug&slug=' . urlencode($child));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPGET, true);
    $post_response = curl_exec($ch);
    curl_close($ch);
    if ($post_response) {
        $post = json_decode($post_response);
    }
} catch (Throwable $th) {
    error_log($th->getMessage());
}

// ── Fetch latest posts for sidebar ───────────────────────────────────────────
$latest_posts = [];
try {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, API . '?object=BlogArticle&action=get_latest');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPGET, true);
    $latest_response = curl_exec($ch);
    curl_close($ch);
    if ($latest_response) {
        $latest_posts = json_decode($latest_response) ?: [];
    }
} catch (Throwable $th) {
    error_log($th->getMessage());
}

// ── 404-style fallback if post not found or not published ────────────────────
if (!$post || (isset($post->published) && !$post->published)) {
    http_response_code(404);
?>
<section class="page-header">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="page-header-content">
          <h1>Blog</h1>
          <ul class="list-inline mb-0">
            <li class="list-inline-item"><a href="/">Home</a></li>
            <li class="list-inline-item">/</li>
            <li class="list-inline-item"><a href="/blog">Blog</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>
<div class="page-wrapper">
  <div class="container">
    <div class="row justify-content-center py-5">
      <div class="col-md-8 text-center">
        <h2>Post not found</h2>
        <p class="text-muted">The article you are looking for does not exist or has been removed.</p>
        <a href="/blog" class="btn btn-main mt-3">Back to Blog</a>
      </div>
    </div>
  </div>
</div>
<?php
    return;
}
?>

<section class="page-header">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="page-header-content">
          <h1>Blog</h1>
          <ul class="list-inline mb-0">
            <li class="list-inline-item"><a href="/">Home</a></li>
            <li class="list-inline-item">/</li>
            <li class="list-inline-item"><a href="/blog">Blog</a></li>
            <li class="list-inline-item">/</li>
            <li class="list-inline-item"><?php echo htmlspecialchars($post->title ?? ''); ?></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="page-wrapper">
  <div class="container">
    <div class="row">

      <!-- ── Main Article ──────────────────────────────────────────────────── -->
      <div class="col-md-8">
        <article class="blog-post-item" itemscope itemtype="https://schema.org/BlogPosting">

          <?php if (!empty($post->cover_image)): ?>
          <div class="post-thumb">
            <img
              src="<?php echo rtrim(UPLOAD_SERVER, '/') . '/' . ltrim($post->cover_image, '/'); ?>"
              alt="<?php echo htmlspecialchars($post->title ?? ''); ?>"
              class="img-fluid post-image"
              itemprop="image">
          </div>
          <?php endif; ?>

          <div class="post-item mt-4">
            <div class="post-meta">
              <?php if (!empty($post->created_at)): ?>
              <span class="post-date">
                <i class="fa fa-calendar-alt mr-2"></i>
                <time itemprop="datePublished" datetime="<?php echo htmlspecialchars($post->created_at); ?>">
                  <?php echo htmlspecialchars($post->created_at); ?>
                </time>
              </span>
              <?php endif; ?>
              <?php if (!empty($post->author_name)): ?>
              <span class="post-author">
                <i class="fa fa-user mr-2"></i>
                <span itemprop="author"><?php echo htmlspecialchars($post->author_name); ?></span>
              </span>
              <?php endif; ?>
            </div>

            <h1 class="post-title" itemprop="headline">
              <?php echo htmlspecialchars($post->title ?? ''); ?>
            </h1>

            <div class="post-content" itemprop="articleBody">
              <?php echo $post->body ?? ''; ?>
            </div>

            <div class="mt-4 pt-3 border-top">
              <a href="/blog" class="read-more"><i class="fa fa-angle-left mr-2"></i>Back to Blog</a>
            </div>
          </div>

        </article>
      </div>

      <!-- ── Sidebar ───────────────────────────────────────────────────────── -->
      <div class="col-md-4">
        <div class="blog-sidebar mt-5 mt-lg-0 mt-md-0">

          <div class="widget widget_search">
            <h4 class="widget-title">Search</h4>
            <form role="search" class="search-form" action="/blog" method="get">
              <input type="text" name="q" class="form-control" placeholder="Search">
              <button type="submit" class="search-submit"><i class="fa fa-search"></i></button>
            </form>
          </div>

          <div class="widget widget_news">
            <h4 class="widget-title">Latest Posts</h4>
            <ul class="recent-posts">
              <?php if (!empty($latest_posts)): ?>
                <?php foreach ($latest_posts as $lpost): ?>
                  <?php
                    $lurl  = '/' . ltrim($lpost->url ?? '', '/');
                    $lthumb = !empty($lpost->cover_image_thumbnail)
                        ? rtrim(UPLOAD_SERVER, '/') . '/' . ltrim($lpost->cover_image_thumbnail, '/')
                        : rtrim(UPLOAD_SERVER, '/') . '/' . ltrim($lpost->cover_image ?? '', '/');
                  ?>
                  <li>
                    <div class="widget-post-thumb">
                      <a href="<?php echo htmlspecialchars($lurl); ?>">
                        <img src="<?php echo htmlspecialchars($lthumb); ?>"
                             alt="<?php echo htmlspecialchars($lpost->title ?? ''); ?>"
                             class="img-fluid">
                      </a>
                    </div>
                    <div class="widget-post-body">
                      <span><?php echo htmlspecialchars($lpost->created_at ?? ''); ?></span>
                      <h6>
                        <a href="<?php echo htmlspecialchars($lurl); ?>">
                          <?php echo htmlspecialchars($lpost->title ?? ''); ?>
                        </a>
                      </h6>
                    </div>
                  </li>
                <?php endforeach; ?>
              <?php else: ?>
                <li><p class="text-muted">No posts to display</p></li>
              <?php endif; ?>
            </ul>
          </div>

        </div>
      </div>

    </div>
  </div>
</div>

<?php
// ── BlogPosting JSON-LD structured data ──────────────────────────────────────
$ld_title       = htmlspecialchars($post->title ?? '', ENT_QUOTES);
$ld_description = htmlspecialchars($post->meta_description ?? '', ENT_QUOTES);
$ld_image       = !empty($post->cover_image) ? rtrim(UPLOAD_SERVER, '/') . '/' . ltrim($post->cover_image, '/') : '';
$ld_url         = SITE_URL . '/blog/' . htmlspecialchars($post->slug ?? $child);
$ld_date        = htmlspecialchars($post->created_at ?? '');
$ld_author      = htmlspecialchars($post->author_name ?? 'BETRALACE');
?>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BlogPosting",
  "headline": "<?php echo $ld_title; ?>",
  "description": "<?php echo $ld_description; ?>",
  "image": "<?php echo $ld_image; ?>",
  "url": "<?php echo $ld_url; ?>",
  "datePublished": "<?php echo $ld_date; ?>",
  "author": {
    "@type": "Person",
    "name": "<?php echo $ld_author; ?>"
  },
  "publisher": {
    "@type": "LanguageSchool",
    "name": "BETRALACE",
    "url": "<?php echo SITE_URL; ?>"
  }
}
</script>
