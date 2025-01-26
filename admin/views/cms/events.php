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
            <h1 class="h3">Events</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo DIRADMIN; ?>">Home</a></li>
                    <li class="breadcrumb-item active">Events</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-12 col-lg-12 tab">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="all-events-tab" data-bs-toggle="tab" data-bs-target="#all-events" role="tab" aria-controls="all-events" aria-selected="true">Events</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="new-event-tab" data-bs-toggle="tab" data-bs-target="#new-event" role="tab" aria-controls="new-event" aria-selected="false">New <i class="fa fa-plus"></i></a>
                    </li>
                    <li class="nav-item d-none" role="presentation">
                        <a class="nav-link" id="edit-event-tab" data-bs-toggle="tab" data-bs-target="#edit-event" role="tab" aria-controls="edit-event" aria-selected="false">Edit <i class="fa fa-edit"></i></a>
                    </li>
                    <li class="nav-item d-none" role="presentation">
                        <a class="nav-link" id="gallery-event-tab" data-bs-toggle="tab" data-bs-target="#gallery-event" role="tab" aria-controls="gallery-event" aria-selected="false">Gallery <i class="fa fa-image"></i></a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="all-events" role="tabpanel" aria-labelledby="all-events-tab">
                        <div class="row">
                            <div class="col-md-12 datatables-buttons m-b-20 text-right">
                            </div>
                        </div>
                        <table class="table table-striped" data-status="" id="events-table">
                            <thead>
                                <tr>
                                    <th class="col-1"></th>
                                    <th>Title</th>
                                    <th>Event Date</th>
                                    <th>Author</th>
                                    <th>Last Modified</th>
                                    <th class="col-1"></th>
                                </tr>
                            </thead>
                        </table>
                        <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <form id="delete-event-form" method="post" action="<?php echo API; ?>">
                                    <input type="hidden" name="id">
                                    <input type="hidden" name="object" value="Event">
                                    <input type="hidden" name="action" value="delete" />
                                    <input type="hidden" name="user_token" value="<?php echo encrypt_data($user->id); ?>">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Confirm action</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-description m-3">
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
                                <form id="publish-event-form" method="post" action="<?php echo API; ?>">
                                    <input type="hidden" name="id">
                                    <input type="hidden" name="object" value="Event">
                                    <input type="hidden" name="action" value="publish" />
                                    <input type="hidden" name="user_token" value="<?php echo encrypt_data($user->id); ?>">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Confirm action</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-description m-3">
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
                    <div class="tab-pane fade" id="new-event" role="tabpanel" aria-labelledby="new-event-tab">
                        <form action="<?php echo API; ?>" method="POST" role="form" id="new-event-form" class="event-form">
                            <div>
                                <div class="mb-3">
                                    <input type="hidden" name="object" value="Event">
                                    <input type="hidden" name="action" value="create">
                                    <input type="hidden" name="user_token" value="<?php echo encrypt_data($user->id); ?>">
                                    <input type="hidden" name="slug">
                                    <div class="form-group row mb-3">
                                        <div class="col-md-12">
                                            <label for="title" class="col-form-label">Title</label>
                                            <input type="text" name="title" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <div class="col-md-12">
                                            <label for="location" class="col-form-label">Location</label>
                                            <input type="text" name="location" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <div class="col-md-6">
                                            <label for="start_date" class="col-form-label">Start Date</label>
                                            <input type="datetime-local" name="start_date" class="form-control" autocomplete="off">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="end_date" class="col-form-label">End Date</label>
                                            <input type="datetime-local" name="end_date" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <div class="col-md-12">
                                            <label for="body" class="col-form-label">Description</label>
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
                                            <div class="dropzone-area dropzone event_poster" data-name="tempFile" id="new-cover-image">
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
                    <div class="tab-pane fade" id="edit-event" role="tabpanel" aria-labelledby="edit-event-tab">
                        <form action="<?php echo API; ?>" method="POST" role="form" id="edit-event-form" class="event-form">
                            <div>
                                <div class="mb-3">
                                    <input type="hidden" name="object" value="Event">
                                    <input type="hidden" name="action" value="update">
                                    <input type="hidden" name="user_token" value="<?php echo encrypt_data($user->id); ?>">
                                    <input type="hidden" name="cover_image">
                                    <input type="hidden" name="cover_image_thumbnail">
                                    <input type="hidden" name="id">
                                    <input type="hidden" name="page_id">
                                    <input type="hidden" name="slug">
                                    <div class="form-group row mb-3">
                                        <div class="col-md-12">
                                            <label for="title" class="col-form-label">Title</label>
                                            <input type="text" name="title" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <div class="col-md-12">
                                            <label for="location" class="col-form-label">Location</label>
                                            <input type="text" name="location" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <div class="col-md-6">
                                            <label for="start_date" class="col-form-label">Start Date</label>
                                            <input type="datetime-local" name="start_date" class="form-control" autocomplete="off">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="end_date" class="col-form-label">End Date</label>
                                            <input type="datetime-local" name="end_date" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <div class="col-md-12">
                                            <label for="body" class="col-form-label">Description</label>
                                            <textarea name="body" class="form-control summernote" rows="3"></textarea>
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
                                            <div class="dropzone-area dropzone event_poster" data-name="tempFile" id="edit-cover-image">
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
                                    <button type="button" class="btn btn-primary mx-2 cancel-edit-event-btn"> Cancel</button>
                                    <button type="submit" class="btn btn-success"> Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="gallery-event" role="tabpanel" aria-labelledby="gallery-event-tab">
                        <form action="<?php echo API; ?>" method="POST" role="form" id="gallery-event-form" class="event-form">
                            <div class="mb-3">
                                <div class="mb-3">
                                    <input type="hidden" name="object" value="Event">
                                    <input type="hidden" name="action" value="add_gallery_images">
                                    <input type="hidden" name="user_token" value="<?php echo encrypt_data($user->id); ?>">
                                    <input type="hidden" name="id">
                                    <input type="hidden" name="page_id">
                                    <input type="hidden" name="slug">
                                    <div class="form-group row mb-3">
                                        <div class="col-md-12">
                                            <h3 id="event-title">Event Images</h3>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <div class="col-md-12">
                                            <div class="dropzone-area dropzone gallery multiple" data-name="tempFiles[]" id="gallery-images">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary mx-2 cancel-gallery-event-btn"> Cancel</button>
                                    <button type="submit" class="btn btn-success"> Submit</button>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="parent-container d-flex d-inline">

                                        </div>
                                    </div>
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
        $('.summernote').summernote({
            placeholder: 'Add text here',
            tabsize: 2,
            height: 150
        });

        // $('.parent-container').magnificPopup({
        //     delegate: 'a', // child items selector, by clicking on it popup will open
        //     type: 'image',
        //     gallery:{
        //         enabled:true
        //     }
        // });

        var new_event = $('#new-cover-image').initDropzone();
        var edit_event = $('#edit-cover-image').initDropzone();
        var gallery_event = $('#gallery-images').initDropzone();

        if ($("[name='route_action']").val().length) {
            var action = $("[name='route_action']").val();
            switch (action) {
                case 'new':

                    $('a[aria-controls="all-events"]').removeClass('active');
                    $('#all-events').removeClass('active');
                    $('a[aria-controls="new-event"]').addClass('active');
                    $('#new-event').addClass('active').addClass('show');
                    $('a[aria-controls="new-event"]').closest('li').removeClass('d-none');

                    break;

                case 'edit':
                    var value = $("[name='route_value']").val();

                    if (value.length) {
                        editEvent(value);

                        $('a[aria-controls="all-events"]').removeClass('active');
                        $('#all-events').removeClass('active');
                        $('a[aria-controls="edit-event"]').addClass('active');
                        $('#edit-event').addClass('active').addClass('show');
                        $('a[aria-controls="edit-event"]').closest('li').removeClass('d-none');

                    }
                    break;

                default:
                    break;
            }
        }

        $('#events-table').DataTable({
            "processing": true,
            "serverSide": true,
            responsive: true,
            "order": [],
            "ajax": {
                url: "<?php echo API; ?>",
                data: function(d) {
                    d.object = 'Event';
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

        $("#new-event-form").validate({
            rules: {
                title: {
                    required: true,
                    minlength: 2
                },
                start_date: {
                    required: true,
                },
                description: {
                    required: true,
                }
            },
            messages: {
                title: {
                    required: "Title is required",
                    minlength: "Title should be at least 2 characters"
                },
                start_date: {
                    required: "Date is required",
                },
                description: {
                    required: "Description is required",
                }
            },
            submitHandler: function(form) {
                var body = $("#new-event-form").find('[name="body"]').val();
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
                        $('#events-table').DataTable().ajax.reload(null, false);
                        new_event.removeAllFiles();

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

        $(document).on('click', '.edit-event-btn', function() {
            var id = $(this).attr('data-id');

            editEvent(id);

            $('a[aria-controls="all-events"]').removeClass('active');
            $('#all-events').removeClass('active');
            $('a[aria-controls="edit-event"]').addClass('active');
            $('#edit-event').addClass('active').addClass('show');
            $('a[aria-controls="edit-event"]').closest('li').removeClass('d-none');
        });

        $("#edit-event-form").validate({
            rules: {
                title: {
                    required: true,
                    minlength: 2
                },
                start_date: {
                    required: true,
                },
                description: {
                    required: true,
                }
            },
            messages: {
                title: {
                    required: "Title is required",
                    minlength: "Title should be at least 2 characters"
                },
                start_date: {
                    required: "Date is required",
                },
                description: {
                    required: "Description is required",
                }
            },
            submitHandler: function(form) {
                var body = $("#edit-event-form").find('[name="body"]').val();
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
                        $('#events-table').DataTable().ajax.reload(null, false);
                        edit_event.removeAllFiles();

                        if ($("[name='route_action']").val().length) {
                            window.location = $("[name='route_view']").val();
                        }

                        $('a[aria-controls="edit-event"]').removeClass('active');
                        $('#edit-event').removeClass('active');
                        $('a[aria-controls="all-events"]').addClass('active');
                        $('#all-events').addClass('active').addClass('show');
                        $('a[aria-controls="edit-event"]').closest('li').addClass('d-none');

                    },
                    error: function(data) {
                        toastr.error(data.responseJSON.message);
                    }
                });
            }
        });

        $(document).on('click', '.cancel-edit-event-btn', function() {
            var id = $(this).attr('data-id');

            $('a[aria-controls="edit-event"]').removeClass('active');
            $('#edit-event').removeClass('active');
            $('a[aria-controls="all-events"]').addClass('active');
            $('#all-events').addClass('active').addClass('show');
            $('a[aria-controls="edit-event"]').closest('li').addClass('d-none');
        });

        $(document).on('click', '.delete-event-btn', function() {
            var id = $(this).attr('data-id');
            $('#delete-event-form').find("[name='id']").val(id);
            $('#delete-modal').modal('toggle');
        });

        $(document).on('submit', '#delete-event-form', function(e) {
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
                    $('#events-table').DataTable().ajax.reload(null, false);
                    $('#delete-modal').modal('toggle');

                },
                error: function(data) {
                    toastr.error(data.responseJSON.message);
                    $('#delete-modal').modal('toggle');
                }
            });
        });

        $(document).on('click', '.publish-event-btn', function() {
            var id = $(this).attr('data-id');
            $('#publish-event-form').find("[name='id']").val(id);
            $('#publish-event-form').find("[name='action']").val('publish');
            $('#publish-modal').modal('toggle');
        });

        $(document).on('click', '.unpublish-event-btn', function() {
            var id = $(this).attr('data-id');
            $('#publish-event-form').find("[name='id']").val(id);
            $('#publish-event-form').find("[name='action']").val('unpublish');
            $('#publish-modal').modal('toggle');
        });

        $(document).on('submit', '#publish-event-form', function(e) {
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
                    $('#events-table').DataTable().ajax.reload(null, false);
                    $('#publish-modal').modal('toggle');

                },
                error: function(data) {
                    toastr.error(data.responseJSON.message);
                    $('#publish-modal').modal('toggle');
                }
            });
        });

        $(document).on('click', '.gallery-event-btn', function() {
            var id = $(this).attr('data-id');

            galleryEvent(id);

            $('a[aria-controls="all-events"]').removeClass('active');
            $('#all-events').removeClass('active');
            $('a[aria-controls="gallery-event"]').addClass('active');
            $('#gallery-event').addClass('active').addClass('show');
            $('a[aria-controls="gallery-event"]').closest('li').removeClass('d-none');
        });

        $("#gallery-event-form").validate({
            submitHandler: function(form) {
                var formData = new FormData(form);
                $.ajax({
                    beforeSend: function() {
                        // $('#overlay').removeClass('d-none');
                    },
                    complete: function() {
                        // $('#overlay').addClass('d-none');
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
                        $('#events-table').DataTable().ajax.reload(null, false);
                        gallery_event.removeAllFiles();

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

        $(document).on('click', '.cancel-gallery-event-btn', function() {
            var id = $(this).attr('data-id');

            $('a[aria-controls="gallery-event"]').removeClass('active');
            $('#gallery-event').removeClass('active');
            $('a[aria-controls="all-events"]').addClass('active');
            $('#all-events').addClass('active').addClass('show');
            $('a[aria-controls="gallery-event"]').closest('li').addClass('d-none');
        });

        $(document).on('click', '.publish-event-image-btn', function() {
            var id = $(this).attr('data-id');
            var event_id = $(this).closest('form').find("[name='id']").val();

            $.ajax({
                type: 'GET',
                url: '<?php echo API; ?>',
                data: {
                    object: 'Event',
                    action: 'publish_image',
                    id: id
                },
                cache: false,
                dataType: 'JSON',
                success: function(response) {
                    toastr.success(response.message);
                    galleryEvent(event_id);
                }

            });

        });

        $(document).on('click', '.unpublish-event-image-btn', function() {
            var id = $(this).attr('data-id');
            var event_id = $(this).closest('form').find("[name='id']").val();

            $.ajax({
                type: 'GET',
                url: '<?php echo API; ?>',
                data: {
                    object: 'Event',
                    action: 'unpublish_image',
                    id: id
                },
                cache: false,
                dataType: 'JSON',
                success: function(response) {
                    toastr.success(response.message);
                    galleryEvent(event_id);
                }

            });

        });

        $(document).on('click', '.delete-event-image-btn', function() {
            var id = $(this).attr('data-id');
            var event_id = $(this).closest('form').find("[name='id']").val();

            $.ajax({
                type: 'GET',
                url: '<?php echo API; ?>',
                data: {
                    object: 'Event',
                    action: 'delete_image',
                    id: id
                },
                cache: false,
                dataType: 'JSON',
                success: function(response) {
                    toastr.success(response.message);
                    galleryEvent(event_id);
                }

            });

        });
    });

    function editEvent(id) {
        $.ajax({
            type: 'GET',
            url: '<?php echo API; ?>',
            data: {
                object: 'Event',
                action: 'get_details',
                id: id
            },
            cache: false,
            dataType: 'JSON',
            success: function(response) {
                $('#edit-event-form').find('[name="id"]').val(response.id).end()
                    .find('[name="page_id"]').val(response.page_id).end()
                    .find('[name="title"]').val(response.title).end()
                    .find('[name="slug"]').val(response.slug).end()
                    .find('[name="location"]').val(response.location).end()
                    .find('[name="start_date"]').val(response.start_date).end()
                    .find('[name="end_date"]').val(response.end_date).end()
                    .find('[name="description"]').val(response.description).end()
                    .find('[name="cover_image"]').val(response.cover_image).end()
                    .find('[name="cover_image_thumbnail"]').val(response.cover_image_thumbnail).end()
                    .find('[name="body"]').summernote('code', response.body);

                if (response.published == 1) {
                    $('#edit-event-form').find('input[name="published"]').prop('checked', true);
                }
            }
        });
    }

    function galleryEvent(id) {
        $.ajax({
            type: 'GET',
            url: '<?php echo API; ?>',
            data: {
                object: 'Event',
                action: 'get_details',
                id: id
            },
            cache: false,
            dataType: 'JSON',
            success: function(response) {
                $('#gallery-event-form').find('[name="id"]').val(response.id).end()
                    .find('[name="page_id"]').val(response.page_id).end()
                    .find('[name="slug"]').val(response.slug).end()
                    .find('#event-title').html(response.title + ' Images').end();

                var images_html = "";
                $(response.event_images).each(function(k, v) {
                    if(v.is_published == 1){
                        var publish_btn = `<button type="button" class="btn btn-sm btn-warning mt-2 unpublish-event-image-btn" data-id="${v.id}"><i class="fa fa-link"></i></button>`;
                    }
                    else{
                        var publish_btn = `<button type="button" class="btn btn-sm btn-success mt-2 publish-event-image-btn" data-id="${v.id}"><i class="fa fa-link"></i></button>`;
                    }
                    
                    images_html += `
                    <div class="div-container ps-2">
                        <a href="<?php echo DIR ?>${v.name}" class="gallery-image-container" target="_blank">
                            <img src="<?php echo DIR ?>${v.name}" class="img-fluid gallery-image">
                        </a>
                        <br>
                        ${publish_btn}
                        <button type="button" class="btn btn-sm btn-danger mt-2 delete-event-image-btn" data-id="${v.id}"><i class="fa fa-trash"></i></button>
                    </div>`;
                })

                $('.parent-container').html(images_html);
            }

        });
    }
</script>

<?php
include_once $dir . '/includes/footer.php';
?>