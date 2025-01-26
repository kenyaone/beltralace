<div class="breadcrumbs overlay">
    <div class="container">
        <div class="bread-inner">
            <div class="row">
                <div class="col-12">
                    <h2>Blogs</h2>
                    <ul class="bread-list">
                        <li><a href="/">Home</a></li>
                        <li><i class="icofont-simple-right"></i></li>
                        <li class="active">Blogs</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="blog section" id="blog">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>Keep up with Our Most Recent Articles.</h2>
                </div>
            </div>
        </div>
        <div class="row" id="blogs-container">
            <!-- <div class="col-lg-4 col-md-6 col-12">
                <div class="single-news">
                    <div class="news-head">
                        <img src="https://wellsaidlabs.com/wp-content/uploads/2023/09/blog_header_custom-voice-768x432.jpg" alt="#">
                    </div>
                    <div class="news-body">
                        <div class="news-content">
                            <div class="date">22 Aug, 2020</div>
                            <h2><a href="blog-single.html">We have annnocuced our new product.</a></h2>
                            <p class="text">Lorem ipsum dolor a sit ameti, consectetur adipisicing elit, sed do
                                eiusmod tempor incididunt sed do incididunt sed.</p>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
</section>
<script>
    $(document).ready(function() {
        loadBlogs()
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

                if(response.length > 0){
                    $(response).each(function(k, v){
                        blogs_html += 
                            `
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="single-news">
                                    <div class="news-head">
                                        <img src="<?php echo UPLOAD_SERVER; ?>/${v.cover_image}" alt="#">
                                    </div>
                                    <div class="news-body">
                                        <div class="news-content">
                                            <div class="date">${v.created_at}</div>
                                            <h2><a href="/${v.url}">${v.title}</a></h2>
                                            <p class="text">${v.meta_description}.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            `;
                    });
                }
                else{
                    blogs_html = `<div class="col-12"><p class="text-center">No blogs to display</p></div>`;
                }

                $("#blogs-container").html(blogs_html);
                
            }
        });
    }
</script>