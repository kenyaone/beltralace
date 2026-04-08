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
                <div id="blogs-container" class="blog-posts">
                    <!-- Blog posts will be loaded here -->
                </div>

                <nav class="blog-pagination">
                    <ul>
                        <li class="page-num active"><a href="#">1</a></li>
                        <li class="page-num"><a href="#">2</a></li>
                        <li class="page-num"><a href="#">3</a></li>
                    </ul>
                </nav>
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


                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        loadBlogs()
        loadLatestBlogs()
    });

    function loadBlogs() {
        $.ajax({
            type: 'GET',
            url: '<?php echo API; ?>',
            data: {
                object: 'BlogArticle',
                action: 'get_published',
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
                            <article class="blog-post-item">
                                <div class="post-preview-thumb">
                                    <img src="${upload_server}${v.cover_image}" alt="" class="img-fluid">
                                </div>
                                <div class="post-item mt-4">
                                    <div class="post-meta">
                                        <span class="post-date"><i class="fa fa-calendar-alt mr-2"></i>${v.created_at}</span>
                                        <span class="post-author"><i class="fa fa-user mr-2"></i>Admin</span>
                                    </div>
                                    <h2 class="post-title"><a href="/${v.url}">${v.title}</a></h2>
                                    <div class="post-content">
                                        <p>${v.meta_description}</p>

                                        <a href="/${v.url}" class="read-more">More Details <i class="fa fa-angle-right ml-2"></i></a>
                                    </div>
                                </div>
                            </article>
                            `;
                    });
                } else {
                    blogs_html = `<div class="col-12"><p class="text-center">No blogs to display</p></div>`;
                }

                $("#blogs-container").html(blogs_html);

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