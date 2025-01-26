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
            <h1 class="h3">Widgets</h1>
            <div class="ms-auto">
                <a href="<?php echo DIRADMIN . 'widgets/new'; ?>" class="btn btn-outline-dark task-form-btn">New Widget <i class="fas fa-fw fa-plus"></i></a>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-12 tab">
                <div class="row">
                    <div class="col-md-12 datatables-buttons m-b-20 text-right">
                    </div>
                </div>
                <table class="table table-striped" data-status="" id="widgets-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Section</th>
                            <th>Author</th>
                            <th>Created</th>
                            <th>Last Modified</th>
                            <th class="col-1"></th>
                        </tr>
                    </thead>
                </table>
                <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <form id="delete-widget-form" method="post" action="<?php echo API; ?>">
                            <input type="hidden" name="id">
                            <input type="hidden" name="object" value="Widget">
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
                        <form id="publish-widget-form" method="post" action="<?php echo API; ?>">
                            <input type="hidden" name="id">
                            <input type="hidden" name="object" value="Widget">
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

<script src="<?php echo ASSETS_PATH; ?>/admin/js/choices.js"></script>
<script>
    $(document).ready(function() {
        $('#widgets-table').DataTable({
            "processing": true,
            "serverSide": true,
            responsive: true,
            "order": [],
            "ajax": {
                url: "<?php echo API; ?>",
                data: function(d) {
                    d.object = 'Widget';
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

        $("#new-widget-form").validate({
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
                var body = $("#new-widget-form").find('[name="body"]').val();
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
                        form.reset();
                        toastr.success(response.message);
                        $('#widgets-table').DataTable().ajax.reload(null, false);
                        new_widget.removeAllFiles();
                        $('.selectpicker').selectpicker('val', '');

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

        $(document).on('click', '.edit-widget-btn', function() {
            var id = $(this).attr('data-id');

            editWidget(id);

            $('a[aria-controls="all-widgets"]').removeClass('active');
            $('#all-widgets').removeClass('active');
            $('a[aria-controls="edit-widget"]').addClass('active');
            $('#edit-widget').addClass('active').addClass('show');
            $('a[aria-controls="edit-widget"]').closest('li').removeClass('d-none');
        });

        $("#edit-widget-form").validate({
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
                var body = $("#edit-widget-form").find('[name="body"]').val();
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
                        form.reset();
                        toastr.success(response.message);
                        $('#widgets-table').DataTable().ajax.reload(null, false);
                        edit_widget.removeAllFiles();

                        if ($("[name='route_action']").val().length) {
                            window.location = $("[name='route_view']").val();
                        }

                        $('a[aria-controls="edit-widget"]').removeClass('active');
                        $('#edit-widget').removeClass('active');
                        $('a[aria-controls="all-widgets"]').addClass('active');
                        $('#all-widgets').addClass('active').addClass('show');
                        $('a[aria-controls="edit-widget"]').closest('li').addClass('d-none');

                    },
                    error: function(data) {
                        toastr.error(data.responseJSON.message);
                    }
                });
            }
        });

        $(document).on('click', '.cancel-edit-widget-btn', function() {
            var id = $(this).attr('data-id');

            $('a[aria-controls="edit-widget"]').removeClass('active');
            $('#edit-widget').removeClass('active');
            $('a[aria-controls="all-widgets"]').addClass('active');
            $('#all-widgets').addClass('active').addClass('show');
            $('a[aria-controls="edit-widget"]').closest('li').addClass('d-none');
        });

        $(document).on('click', '.delete-widget-btn', function() {
            var id = $(this).attr('data-id');
            $('#delete-widget-form').find("[name='id']").val(id);
            $('#delete-modal').modal('toggle');
        });

        $(document).on('submit', '#delete-widget-form', function(e) {
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
                    $('#widgets-table').DataTable().ajax.reload(null, false);
                    $('#delete-modal').modal('toggle');

                },
                error: function(data) {
                    toastr.error(data.responseJSON.message);
                    $('#delete-modal').modal('toggle');
                }
            });
        });

        $(document).on('click', '.publish-widget-btn', function() {
            var id = $(this).attr('data-id');
            $('#publish-widget-form').find("[name='id']").val(id);
            $('#publish-widget-form').find("[name='action']").val('publish');
            $('#publish-modal').modal('toggle');
        });

        $(document).on('click', '.unpublish-widget-btn', function() {
            var id = $(this).attr('data-id');
            $('#publish-widget-form').find("[name='id']").val(id);
            $('#publish-widget-form').find("[name='action']").val('unpublish');
            $('#publish-modal').modal('toggle');
        });

        $(document).on('submit', '#publish-widget-form', function(e) {
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
                    $('#widgets-table').DataTable().ajax.reload(null, false);
                    $('#publish-modal').modal('toggle');

                },
                error: function(data) {
                    toastr.error(data.responseJSON.message);
                    $('#publish-modal').modal('toggle');
                }
            });
        });
    });

    function editWidget(id) {
        $.ajax({
            type: 'GET',
            url: '<?php echo API; ?>',
            data: {
                object: 'Widget',
                action: 'get_details',
                id: id
            },
            cache: false,
            dataType: 'JSON',
            success: function(response) {
                if (response.section != 'banner' && response.section != 'projects_cta') {
                    $('.image-container').addClass('d-none');
                } else {
                    $('.image-container').removeClass('d-none');

                    switch (response.section) {
                        case 'banner':
                            $('#edit-image').addClass('banner');
                            break;

                        default:
                            $('#edit-image').addClass('gallery');
                            break;
                    }
                }

                $('#edit-widget-form').find('[name="id"]').val(response.id).end()
                    .find('[name="title"]').val(response.title).end()
                    .find('[name="sub_title"]').val(response.sub_title).end()
                    .find('[name="section"]').val(response.section).end()
                    .find('[name="image"]').val(response.image).end()
                    .find('[name="body"]').val(response.body).end();

                if (response.published == 1) {
                    $('#edit-widget-form').find('input[name="published"]').prop('checked', true);
                }
            }
        });
    }
</script>

<?php
include_once $dir . '/includes/footer.php';
?>