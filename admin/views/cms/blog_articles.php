<?php
$dir = dirname(__DIR__);
include_once $dir . '/includes/header.php';
?>
<input type="hidden" name="route_view" value="<?php echo DIRADMIN . $page; ?>">
<input type="hidden" name="route_action" value="<?php echo $action; ?>">
<input type="hidden" name="route_value" value="<?php echo $value; ?>">
<main class="content">
    <div class="container-fluid p-0">
        <div class="d-flex justify-content-between mb-4">
            <h1 class="h3">Blog Articles</h1>
            <div class="ms-auto">
                <a href="<?php echo DIRADMIN . 'blog-articles/new'; ?>" class="btn btn-outline-dark task-form-btn">New Article <i class="fas fa-fw fa-plus"></i></a>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-12 tab">
                <div class="row">
                    <div class="col-md-12 datatables-buttons m-b-20 text-right">
                    </div>
                </div>
                <table class="table table-striped" data-status="" id="blog-articles-table">
                    <thead>
                        <tr>
                            <th class="col-1"></th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Created</th>
                            <th>Last Modified</th>
                            <th class="col-1"></th>
                        </tr>
                    </thead>
                </table>
                <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <form id="delete-blog-article-form" method="post" action="<?php echo API; ?>">
                            <input type="hidden" name="id">
                            <input type="hidden" name="object" value="BlogArticle">
                            <input type="hidden" name="action" value="delete" />
                            <input type="hidden" name="user_token" value="<?php echo encrypt_data($user->id); ?>">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Confirm action</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body m-3">
                                    <p class="mb-0">Do you really want to remove this item from the database?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger">Proceed</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal fade" id="publish-modal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <form id="publish-blog-article-form" method="post" action="<?php echo API; ?>">
                            <input type="hidden" name="id">
                            <input type="hidden" name="object" value="BlogArticle">
                            <input type="hidden" name="action" value="publish" />
                            <input type="hidden" name="user_token" value="<?php echo encrypt_data($user->id); ?>">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Confirm action</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body m-3">
                                    <p class="mb-0">Are you sure you want to proceed with this action?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-success">Proceed</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    $(document).ready(function() {
        var section = "blog_articles";
        var current_record = 0;

        if ($("[name='route_action']").val().length) {
            var action = $("[name='route_action']").val();
            switch (action) {
                case 'new':

                    $('a[aria-controls="all-blog-articles"]').removeClass('active');
                    $('#all-blog-articles').removeClass('active');
                    $('a[aria-controls="new-blog-article"]').addClass('active');
                    $('#new-blog-article').addClass('active').addClass('show');
                    $('a[aria-controls="new-blog-article"]').closest('li').removeClass('d-none');

                    break;

                case 'edit':
                    var value = $("[name='route_value']").val();

                    if (value.length) {
                        editBlogArticle(value);

                        $('a[aria-controls="all-blog-articles"]').removeClass('active');
                        $('#all-blog-articles').removeClass('active');
                        $('a[aria-controls="edit-blog-article"]').addClass('active');
                        $('#edit-blog-article').addClass('active').addClass('show');
                        $('a[aria-controls="edit-blog-article"]').closest('li').removeClass('d-none');

                    }
                    break;

                default:
                    break;
            }
        }

        $('#blog-articles-table').DataTable({
            "processing": true,
            "serverSide": true,
            responsive: true,
            "order": [],
            "ajax": {
                url: "<?php echo API; ?>",
                data: function(d) {
                    d.object = 'BlogArticle';
                    d.action = 'data_table';
                },
                type: "GET"
            },
            "columnDefs": [{
                    "targets": [5],
                    "orderable": false,
                },

            ],
            language: {
                searchPlaceholder: "Search...",
                sEmptyTable: "There is no data in the table yet"
            }
        });

        $(document).on('change', '[name="title"]', function() {
            var current_form = $(this).closest('form');
            $(this).generateSlug($(this).val(), current_form);
            if ($(current_form).find('[name="action"]').val() == 'update') {
                current_record = $(current_form).find('[name="id"]').val();
            }

            $(this).checkSlug($(current_form).find('[name="slug"]').val(), section, current_record, current_form);
        });

        $(document).on('keyup', '[name="slug"]', function() {
            var current_form = $(this).closest('form');
            var slug = $(this).val();
            if (slug != '') {
                if ($(current_form).find('[name="action"]').val() == 'update') {
                    current_record = $(current_form).find('[name="id"]').val();
                }

                $(this).checkSlug(slug, section, current_record, current_form);

            }

        });

        $("#new-blog-article-form").validate({
            rules: {
                title: {
                    required: true,
                    minlength: 2
                },
                slug: {
                    required: true,
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
                slug: {
                    required: "Slug is required",
                },
                meta_description: {
                    required: "Meta Description is required",
                }
            },
            submitHandler: function(form) {
                var formData = new FormData(form);
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
                        form.reset();
                        toastr.success(response.message);
                        $('#blog-articles-table').DataTable().ajax.reload(null, false);
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

        $(document).on('click', '.delete-blog-article-btn', function() {
            var id = $(this).attr('data-id');
            $('#delete-blog-article-form').find("[name='id']").val(id);
            $('#delete-modal').modal('toggle');
        });

        $(document).on('submit', '#delete-blog-article-form', function(e) {
            e.preventDefault();
            var form = $(this);
            var formData = new FormData(form[0]);
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
                    toastr.success(response.message);
                    $('#blog-articles-table').DataTable().ajax.reload(null, false);
                    $('#delete-modal').modal('toggle');

                },
                error: function(data) {
                    toastr.error(data.responseJSON.message);
                    $('#delete-modal').modal('toggle');
                }
            });
        });

        $(document).on('click', '.publish-blog-article-btn', function() {
            var id = $(this).attr('data-id');
            $('#publish-blog-article-form').find("[name='id']").val(id);
            $('#publish-blog-article-form').find("[name='action']").val('publish');
            $('#publish-modal').modal('toggle');
        });

        $(document).on('click', '.unpublish-blog-article-btn', function() {
            var id = $(this).attr('data-id');
            $('#publish-blog-article-form').find("[name='id']").val(id);
            $('#publish-blog-article-form').find("[name='action']").val('unpublish');
            $('#publish-modal').modal('toggle');
        });

        $(document).on('submit', '#publish-blog-article-form', function(e) {
            e.preventDefault();
            var form = $(this);
            var formData = new FormData(form[0]);
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
                    toastr.success(response.message);
                    $('#blog-articles-table').DataTable().ajax.reload(null, false);
                    $('#publish-modal').modal('toggle');

                },
                error: function(data) {
                    toastr.error(data.responseJSON.message);
                    $('#publish-modal').modal('toggle');
                }
            });
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
                $('#edit-blog-article-form').find('[name="id"]').val(response.id).end()
                    .find('[name="page_id"]').val(response.page_id).end()
                    .find('[name="title"]').val(response.title).end()
                    .find('[name="author_name"]').val(response.author_name).end()
                    .find('[name="slug"]').val(response.slug).end()
                    .find('[name="meta_description"]').val(response.meta_description).end()
                    .find('[name="cover_image"]').val(response.cover_image).end()
                    .find('[name="cover_image_thumbnail"]').val(response.cover_image_thumbnail).end()
                    .find('[name="body"]').summernote('code', response.body);

                if (response.published == 1) {
                    $('#edit-blog-article-form').find('input[name="published"]').prop('checked', true);
                }
            }
        });
    }
</script>

<?php
include_once $dir . '/includes/footer.php';
?>