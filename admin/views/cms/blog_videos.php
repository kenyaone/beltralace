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
            <h1 class="h3">Blog Videos</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo DIRADMIN; ?>">Home</a></li>
                    <li class="breadcrumb-item active">Blog Videos</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-12 col-lg-12 tab">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="all-blog-videos-tab" data-bs-toggle="tab" data-bs-target="#all-blog-videos" role="tab" aria-controls="all-blog-videos" aria-selected="true">Blog Videos</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="new-blog-video-tab" data-bs-toggle="tab" data-bs-target="#new-blog-video" role="tab" aria-controls="new-blog-video" aria-selected="false">New <i class="fa fa-plus"></i></a>
                    </li>
                    <li class="nav-item d-none" role="presentation">
                        <a class="nav-link" id="edit-blog-video-tab" data-bs-toggle="tab" data-bs-target="#edit-blog-video" role="tab" aria-controls="edit-blog-video" aria-selected="false">Edit <i class="fa fa-edit"></i></a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="all-blog-videos" role="tabpanel" aria-labelledby="all-blog-videos-tab">
                        <div class="row">
                            <div class="col-md-12 datatables-buttons m-b-20 text-right">
                            </div>
                        </div>
                        <table class="table table-striped" data-status="" id="blog-videos-table">
                            <thead>
                                <tr>
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
                                <form id="delete-blog-video-form" method="post" action="<?php echo API; ?>">
                                    <input type="hidden" name="id">
                                    <input type="hidden" name="object" value="BlogVideo">
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
                    </div>
                    <div class="tab-pane fade" id="new-blog-video" role="tabpanel" aria-labelledby="new-blog-video-tab">
                        <form action="<?php echo API; ?>" method="POST" role="form" id="new-blog-video-form" class="blog-video-form">
                            <div>
                                <div class="mb-3">
                                    <input type="hidden" name="object" value="BlogVideo">
                                    <input type="hidden" name="action" value="create">
                                    <input type="hidden" name="user_token" value="<?php echo encrypt_data($user->id); ?>">
                                    <div class="form-group row mb-3">
                                        <div class="col-md-12">
                                            <label for="title" class="col-form-label">Title</label>
                                            <input type="text" name="title" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <div class="col-md-12">
                                            <label for="link" class="col-form-label">YouTube Link</label>
                                            <input type="text" name="link" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <label for="description" class="col-form-label">Brief Description</label>
                                            <textarea name="description" class="form-control" rows="5"></textarea>
                                            <small class="characters-indicator float-right"></small>
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
                    <div class="tab-pane fade" id="edit-blog-video" role="tabpanel" aria-labelledby="edit-blog-video-tab">
                        <form action="<?php echo API; ?>" method="POST" role="form" id="edit-blog-video-form" class="blog-video-form">
                            <div>
                                <div class="mb-3">
                                    <input type="hidden" name="object" value="BlogVideo">
                                    <input type="hidden" name="action" value="update">
                                    <input type="hidden" name="user_token" value="<?php echo encrypt_data($user->id); ?>">
                                    <input type="hidden" name="id">
                                    <div class="form-group row mb-3">
                                        <div class="col-md-12">
                                            <label for="title" class="col-form-label">Title</label>
                                            <input type="text" name="title" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <div class="col-md-12">
                                            <label for="link" class="col-form-label">YouTube Link</label>
                                            <input type="text" name="link" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <label for="description" class="col-form-label">Brief Description</label>
                                            <textarea name="description" class="form-control" rows="5"></textarea>
                                            <small class="characters-indicator float-right"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary mx-2 cancel-edit-blog-video-btn"> Cancel</button>
                                    <button type="submit" class="btn btn-success"> Submit</button>
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
        if ($("[name='route_action']").val().length) {
            var action = $("[name='route_action']").val();
            switch (action) {
                case 'new':

                    $('a[aria-controls="all-blog-videos"]').removeClass('active');
                    $('#all-blog-videos').removeClass('active');
                    $('a[aria-controls="new-blog-video"]').addClass('active');
                    $('#new-blog-video').addClass('active').addClass('show');
                    $('a[aria-controls="new-blog-video"]').closest('li').removeClass('d-none');

                    break;

                case 'edit':
                    var value = $("[name='route_value']").val();

                    if (value.length) {
                        editBlogVideo(value);

                        $('a[aria-controls="all-blog-videos"]').removeClass('active');
                        $('#all-blog-videos').removeClass('active');
                        $('a[aria-controls="edit-blog-video"]').addClass('active');
                        $('#edit-blog-video').addClass('active').addClass('show');
                        $('a[aria-controls="edit-blog-video"]').closest('li').removeClass('d-none');

                    }
                    break;

                default:
                    break;
            }
        }

        $('#blog-videos-table').DataTable({
            "processing": true,
            "serverSide": true,
            responsive: true,
            "order": [],
            "ajax": {
                url: "<?php echo API; ?>",
                data: function(d) {
                    d.object = 'BlogVideo';
                    d.action = 'data_table';
                },
                type: "GET"
            },
            "columnDefs": [{
                    "targets": [4],
                    "orderable": false,
                },

            ],
            language: {
                searchPlaceholder: "Search...",
                sEmptyTable: "There is no data in the table yet"
            }
        });

        $("#new-blog-video-form").validate({
            rules: {
                title: {
                    required: true,
                    minlength: 2
                },
                link: {
                    required: true,
                    url: true
                },
                description: {
                    required: true,
                    minlength: 10
                }
            },
            messages: {
                title: {
                    required: "Title is required",
                    minlength: "Title should be at least 2 characters"
                },
                link: {
                    required: "Link is required",
                },
                description: {
                    required: "Brief Description is required",
                    minlength: "Brief Description should be at least 10 characters"
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
                        $('#blog-videos-table').DataTable().ajax.reload(null, false);

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

        $(document).on('click', '.edit-blog-video-btn', function() {
            var id = $(this).attr('data-id');

            editBlogVideo(id);

            $('a[aria-controls="all-blog-videos"]').removeClass('active');
            $('#all-blog-videos').removeClass('active');
            $('a[aria-controls="edit-blog-video"]').addClass('active');
            $('#edit-blog-video').addClass('active').addClass('show');
            $('a[aria-controls="edit-blog-video"]').closest('li').removeClass('d-none');
        });

        $("#edit-blog-video-form").validate({
            rules: {
                title: {
                    required: true,
                    minlength: 2
                },
                link: {
                    required: true,
                    url: true
                },
                description: {
                    required: true,
                    minlength: 10
                }
            },
            messages: {
                title: {
                    required: "Title is required",
                    minlength: "Title should be at least 2 characters"
                },
                link: {
                    required: "Link is required",
                },
                description: {
                    required: "Brief Description is required",
                    minlength: "Brief Description should be at least 10 characters"
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
                        $('#blog-videos-table').DataTable().ajax.reload(null, false);

                        if ($("[name='route_action']").val().length) {
                            window.location = $("[name='route_view']").val();
                        }

                        $('a[aria-controls="edit-blog-video"]').removeClass('active');
                        $('#edit-blog-video').removeClass('active');
                        $('a[aria-controls="all-blog-videos"]').addClass('active');
                        $('#all-blog-videos').addClass('active').addClass('show');
                        $('a[aria-controls="edit-blog-video"]').closest('li').addClass('d-none');

                    },
                    error: function(data) {
                        toastr.error(data.responseJSON.message);
                    }
                });
            }
        });

        $(document).on('click', '.cancel-edit-blog-video-btn', function() {
            var id = $(this).attr('data-id');

            $('a[aria-controls="edit-blog-video"]').removeClass('active');
            $('#edit-blog-video').removeClass('active');
            $('a[aria-controls="all-blog-videos"]').addClass('active');
            $('#all-blog-videos').addClass('active').addClass('show');
            $('a[aria-controls="edit-blog-video"]').closest('li').addClass('d-none');
        });

        $(document).on('click', '.delete-blog-video-btn', function() {
            var id = $(this).attr('data-id');
            $('#delete-blog-video-form').find("[name='id']").val(id);
            $('#delete-modal').modal('toggle');
        });

        $(document).on('submit', '#delete-blog-video-form', function(e) {
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
                    $('#blog-videos-table').DataTable().ajax.reload(null, false);
                    $('#delete-modal').modal('toggle');

                },
                error: function(data) {
                    toastr.error(data.responseJSON.message);
                    $('#delete-modal').modal('toggle');
                }
            });
        });
    });

    function editBlogVideo(id) {
        $.ajax({
            type: 'GET',
            url: '<?php echo API; ?>',
            data: {
                object: 'BlogVideo',
                action: 'get_details',
                id: id
            },
            cache: false,
            dataType: 'JSON',
            success: function(response) {
                $('#edit-blog-video-form').find('[name="id"]').val(response.id).end()
                    .find('[name="title"]').val(response.title).end()
                    .find('[name="link"]').val(response.link).end()
                    .find('[name="description"]').val(response.description).end();
            }
        });
    }
</script>

<?php
include_once $dir . '/includes/footer.php';
?>