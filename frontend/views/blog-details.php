<section class="news-single section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="single-main">
                            <!-- News Head -->
                            <div class="news-head">
                                <img src="<?php echo $page->cover_image ? (UPLOAD_SERVER . '/' . $page->cover_image) : 'https://wellsaidlabs.com/wp-content/uploads/2023/09/blog_header_custom-voice-768x432.jpg'; ?>" alt="#">
                            </div>
                            <!-- News Title -->
                            <h1 class="news-title"><?php echo $page->title; ?></h1>
                            <!-- Meta -->
                            <div class="meta">
                                <div class="meta-left">
                                    <!-- <span class="author"><a href="#"><img src="img/author1.jpg" alt="#">Naimur Rahman</a></span> -->
                                    <!-- <span class="date"><i class="fa fa-clock-o"></i><?php echo $page->blog_details->authored_on; ?></span> -->
                                </div>
                                <div class="meta-right">
                                    <!-- <span class="comments"><a href="#"><i class="fa fa-comments"></i>05 Comments</a></span> -->
                                    <span class="views"><i class="fa fa-eye"></i>33K Views</span>
                                </div>
                            </div>
                            <!-- News Text -->
                            <div class="news-text">
                                <?php echo $page->body; ?>
                            </div>
                            <div class="blog-bottom">
                                <!-- Social Share -->
                                <ul class="social-share">
                                    <li class="facebook"><a href="#"><i class="fa fa-facebook"></i><span>Facebook</span></a></li>
                                    <li class="twitter"><a href="#"><i class="fa fa-twitter"></i><span>Twitter</span></a></li>
                                    <!-- <li class="google-plus"><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                    <li class="linkedin"><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                    <li class="pinterest"><a href="#"><i class="fa fa-pinterest"></i></a></li> -->
                                </ul>
                                <!-- Next Prev -->
                                <ul class="prev-next">
                                    <li class="prev"><a href="#"><i class="fa fa-angle-double-left"></i></a></li>
                                    <li class="next"><a href="#"><i class="fa fa-angle-double-right"></i></a></li>
                                </ul>
                                <!--/ End Next Prev -->
                            </div>
                        </div>
                    </div>

                    <!-- <div class="col-12">
                        <div class="comments-form">
                            <h2>Leave Comments</h2>
                            <form class="form" method="post" action="/">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-12">
                                        <div class="form-group">
                                            <i class="fa fa-user"></i>
                                            <input type="text" name="first-name" placeholder="First name" required="required">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-12">
                                        <div class="form-group">
                                            <i class="fa fa-envelope"></i>
                                            <input type="text" name="last-name" placeholder="Last name" required="required">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-12">
                                        <div class="form-group">
                                            <i class="fa fa-envelope"></i>
                                            <input type="email" name="email" placeholder="Your Email" required="required">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group message">
                                            <i class="fa fa-pencil"></i>
                                            <textarea name="message" rows="7" placeholder="Type Your Message Here"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group button">
                                            <button type="button" class="btn primary"><i class="fa fa-send"></i>Submit Comment</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div> -->
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <div class="main-sidebar">
                    <div class="single-widget search">
                        <div class="form">
                            <input type="email" placeholder="Search Here...">
                            <a class="button" href="#"><i class="fa fa-search"></i></a>
                        </div>
                    </div>
                    <div class="single-widget recent-post">
                        <h3 class="title">Recent post</h3>
                        <!-- Single Post -->
                        <div class="single-post">
                            <div class="image">
                                <img src="https://wellsaidlabs.com/wp-content/uploads/2023/09/blog_header_custom-voice-768x432.jpg" alt="#">
                            </div>
                            <div class="content">
                                <h5><a href="#">We have annnocuced our new product.</a></h5>
                                <ul class="comment">
                                    <li><i class="fa fa-calendar" aria-hidden="true"></i>Jan 11, 2020</li>
                                    <!-- <li><i class="fa fa-commenting-o" aria-hidden="true"></i>35</li> -->
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function() {
        // loadBlog()
    });

    function loadBlog() {
        $.ajax({
            type: 'GET',
            url: '<?php echo API; ?>',
            data: {
                object: 'BlogArticle',
                action: 'get_details',
                id: '',
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
                                        <img src="http://api.hpew.local/${v.cover_image}" alt="#">
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