<?php
$dir = dirname(__DIR__);
include_once $dir . '/includes/header.php';
?>
<input type="hidden" name="route_view" value="<?php echo DIRADMIN .'blog-articles'; ?>">
<input type="hidden" name="route_action" value="<?php echo $action; ?>">
<input type="hidden" name="route_value" value="<?php echo $index; ?>">
<main class="content">
    <div class="container-fluid p-0">
        <div class="d-flex justify-content-between mb-4">
            <h1 class="h3">Blog Articles</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo DIRADMIN; ?>">Home</a></li>
                    <li class="breadcrumb-item active">Blog Articles</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-12 col-lg-12">
                <form action="<?php echo API; ?>" method="POST" role="form" id="blog-article-form" class="blog-article-form" accept-charset="UTF-8">
                    <div>
                        <div class="mb-3">
                            <input type="hidden" name="object" value="BlogArticle">
                            <input type="hidden" name="action" value="create">
                            <input type="hidden" name="id">
                            <input type="hidden" name="section" value="blogs">
                            <input type="hidden" name="user_token" value="<?php echo encrypt_data($user->id); ?>">
                            <div class="form-group row mb-3">
                                <div class="col-md-12">
                                    <label for="title" class="col-form-label">Title</label>
                                    <input type="text" name="title" class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <div class="col-md-12">
                                    <label for="slug" class="col-form-label">Slug</label>
                                    <input type="text" name="slug" class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <div class="col-md-12">
                                    <label for="author_name" class="col-form-label">Author</label>
                                    <input type="text" name="author_name" class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <div class="col-md-12">
                                    <label for="meta_description" class="col-form-label">Meta Description</label>
                                    <textarea name="meta_description" class="form-control" rows="3"></textarea>
                                    <small class="characters-indicator float-right"></small>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <div class="col-md-12">
                                    <label for="body" class="col-form-label">Body</label>
                                    <textarea name="body" class="form-control summernote" rows="5"></textarea>
                                    <small class="characters-indicator float-right"></small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <h5 class="card-title">Cover Image</h5>
                                    <hr>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <div class="col-md-12">
                                    <div class="dropzone-area dropzone cover_image" data-name="tempFile" id="new-cover-image">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <div class="form-check form-switch form-switch-md">
                                        <input class="form-check-input" type="checkbox" name="published" value="1">
                                        <label class="form-check-label">Published</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="reset" class="btn btn-primary mx-2"> Clear</button>
                            <button type="submit" class="btn btn-success"> Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            placeholder: 'Add text here',
            tabsize: 2,
            height: 150
        });

        var section = "blogs";
        var current_record = 0;

        <?php
        if ($action == 'edit') {
        ?>
            $('#blog-article-form').find('[name="action"]').val("update").end()
            editBlogArticle(<?php echo $index; ?>);
        <?php
        }
        ?>

        var new_blog_article = $('#new-cover-image').initDropzone();

        $(document).on('change', '[name="title"]', function(){
            var current_form = $(this).closest('form');
            $(this).generateSlug($(this).val(), current_form);
            if($(current_form).find('[name="action"]').val() == 'update'){
                current_record = $(current_form).find('[name="id"]').val();
            }
            
            $(this).checkSlug($(current_form).find('[name="slug"]').val(), section, current_record, current_form);
        });

        $(document).on('keyup', '[name="slug"]', function(){
            var current_form = $(this).closest('form');
            var slug = $(this).val();
            if(slug != ''){
                if($(current_form).find('[name="action"]').val() == 'update'){
                    current_record = $(current_form).find('[name="id"]').val();
                }
                
                $(this).checkSlug(slug, section, current_record, current_form);
            }
            
        });

        $("#blog-article-form").validate({
            rules: {
                title: {
                    required: true,
                    minlength: 2
                },
                meta_description: {
                    required: true,
                }
            },
            messages: {
                title: {
                    required: "Title is required",
                    minlength: "Title should be at least 2 characters"
                },
                meta_description: {
                    required: "Meta Description is required",
                }
            },
            submitHandler: function(form) {
                var body = $("#blog-article-form").find('[name="body"]').val();
                var formData = new FormData(form);
                formData.set('body', btoa(unescape(encodeURIComponent(body))));
                $.ajax({
                    beforeSend: function() {
                        $('#overlay').removeClass('d-none');
                    },
                    complete: function() {
                        $('#overlay').addClass('d-none');
                    },
                    url: $(form).attr('action'),
                    method: 'POST',
                    data: formData,
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    success: function(response, textStatus, jqXHR) {
                        // form.reset();
                        toastr.success(response.message);
                        new_blog_article.removeAllFiles();

                        if ($("[name='route_action']").val().length) {
                            window.location = $("[name='route_view']").val();
                        }
                    },
                    error: function(data) {
                        toastr.error(data.responseJSON.message);
                    }
                });
            }
        });

    });

    function editBlogArticle(id) {
        $.ajax({
            type: 'GET',
            url: '<?php echo API; ?>',
            data: {
                object: 'BlogArticle',
                action: 'get_details',
                id: id
            },
            cache: false,
            dataType: 'JSON',
            success: function(response) {
                $('#blog-article-form').find('[name="id"]').val(response.page_id).end()
                    .find('[name="title"]').val(response.title).end()
                    .find('[name="author_name"]').val(response.author_name).end()
                    .find('[name="slug"]').val(response.slug).end()
                    .find('[name="meta_description"]').val(response.meta_description).end()
                    .find('[name="cover_image"]').val(response.cover_image).end()
                    .find('[name="cover_image_thumbnail"]').val(response.cover_image_thumbnail).end()
                    .find('[name="body"]').summernote('code', response.body);

                if (response.published == 1) {
                    $('#blog-article-form').find('input[name="published"]').prop('checked', true);
                }
            }
        });
    }
</script>

<?php
include_once $dir . '/includes/footer.php';
?>