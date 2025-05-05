<section class="page-header">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
          <div class="page-header-content">
            <h1>Blog</h1>
            <ul class="list-inline mb-0">
              <li class="list-inline-item">
                <a href="#">Home</a>
              </li>
              <li class="list-inline-item">/</li>
              <li class="list-inline-item">
                  Blog
              </li>
            </ul>
          </div>
      </div>
    </div>
  </div>
</section>
<div class="page-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <article class="blog-post-item">
                    <div class="post-thumb">
                        <img src="" alt="" class="img-fluid post-image">
                    </div>
                    <div class="post-item mt-4">
                        <div class="post-meta">
                            <span class="post-date"><i class="fa fa-calendar-alt mr-2"></i>May 9, 2020</span>
                            <span class="post-author"><i class="fa fa-user mr-2"></i>Admin</span>
                            <!-- <span><a href="#" class="post-comment"><i class="fa fa-comments mr-2"></i>1 Comment</a></span> -->
                        </div>
                        <h2 class="post-title"></h2>
                        <div class="post-content">
                            
                        </div>
                    </div>
                </article>

            </div>
            <div class="col-md-4">
                <div class="blog-sidebar mt-5 mt-lg-0 mt-md-0">
                    <div class="widget widget_search">
                        <h4 class="widget-title">Search</h4>
                        <form role="search" class="search-form">
                            <input type="text" class="form-control" placeholder="Search">
                            <button type="submit" class="search-submit"><i class="fa fa-search"></i></button>
                        </form>
                    </div>

                    <div class="widget widget_news">
                        <h4 class="widget-title">Latest Posts</h4>
                        <ul class="recent-posts">

                        </ul>
                    </div>


                    <!-- <div class="widget widget_categories">
                        <h4 class="widget-title">Categories</h4>
                        <ul>
                            <li class="cat-item"><a href="#"><i class="fa fa-angle-right"></i>Web Design</a>(4)</li>
                            <li class="cat-item"><a href="#"><i class="fa fa-angle-right"></i>Wordpress</a>(14)</li>
                            <li class="cat-item"><a href="#"><i class="fa fa-angle-right"></i>Marketing</a>(24)</li>
                            <li class="cat-item"><a href="#"><i class="fa fa-angle-right"></i>Design & dev</a>(6)</li>
                        </ul>
                    </div> -->

                    <!-- <div class="widget widget_tag_cloud">
                        <h4 class="widget-title">Tags</h4>
                        <a href="#">Design</a>
                        <a href="#">Development</a>
                        <a href="#">UX</a>
                        <a href="#">Marketing</a>
                        <a href="#">Tips</a>
                        <a href="#">Tricks</a>
                        <a href="#">Ui</a>
                        <a href="#">Free</a>
                        <a href="#">Wordpress</a>
                        <a href="#">bootstrap</a>
                        <a href="#">Tutorial</a>
                        <a href="#">Html</a>
                    </div> -->

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        loadBlog();
        loadLatestBlogs();
    });

    function loadBlog() {
        $.ajax({
            type: 'GET',
            url: '<?php echo API; ?>',
            data: {
                object: 'BlogArticle',
                action: 'get_by_slug',
                slug: '<?php echo $child; ?>',
            },
            cache: false,
            dataType: 'JSON',
            success: function(response) {
                var blogs_html = "";
                var upload_server = "<?php echo UPLOAD_SERVER; ?>/";

                if(response){
                    $(".post-image").attr('src', upload_server+response.cover_image);
                    $(".post-title").html(response.title);
                    $(".post-content").html(response.body);
                    $(".post-date").html(response.created_at);
                }

            }
        });
    }

    function loadLatestBlogs() {
        $.ajax({
            type: 'GET',
            url: '<?php echo API; ?>',
            data: {
                object: 'BlogArticle',
                action: 'get_latest',
            },
            cache: false,
            dataType: 'JSON',
            success: function(response) {
                var blogs_html = "";
                var upload_server = "<?php echo UPLOAD_SERVER; ?>/";

                if (response.length > 0) {
                    $(response).each(function(k, v) {
                        blogs_html +=
                            `
                            <li>
                                <div class="widget-post-thumb">
                                    <a href="#"><img src="${upload_server}${v.cover_image_thumbnail}" alt="" class="img-fluid"></a>
                                </div>
                                <div class="widget-post-body">
                                    <span>${v.created_at}</span>
                                    <h6> <a href="#">${v.title}</a></h6>
                                </div>
                            </li>
                            `;
                    });
                } else {
                    blogs_html = `<div class="col-12"><p class="text-center">No blogs to display</p></div>`;
                }

                $(".recent-posts").html(blogs_html);

            }
        });
    }
</script>