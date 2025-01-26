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
            <h1 class="h3">FAQs</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo DIRADMIN; ?>">Home</a></li>
                    <li class="breadcrumb-item active">FAQs</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-12 col-lg-12 tab">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="all-faqs-tab" data-bs-toggle="tab" data-bs-target="#all-faqs" role="tab" aria-controls="all-faqs" aria-selected="true">FAQs</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="new-faq-tab" data-bs-toggle="tab" data-bs-target="#new-faq" role="tab" aria-controls="new-faq" aria-selected="false">New <i class="fa fa-plus"></i></a>
                    </li>
                    <li class="nav-item d-none" role="presentation">
                        <a class="nav-link" id="edit-faq-tab" data-bs-toggle="tab" data-bs-target="#edit-faq" role="tab" aria-controls="edit-faq" aria-selected="false">Edit <i class="fa fa-edit"></i></a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="all-faqs" role="tabpanel" aria-labelledby="all-faqs-tab">
                        <div class="row">
                            <div class="col-md-12 datatables-buttons m-b-20 text-right">
                            </div>
                        </div>
                        <table class="table table-striped" data-status="" id="faqs-table">
                            <thead>
                                <tr>
                                    <th>Question</th>
                                    <th>Author</th>
                                    <th>Created</th>
                                    <th>Last Modified</th>
                                    <th class="col-1"></th>
                                </tr>
                            </thead>
                        </table>
                        <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <form id="delete-faq-form" method="post" action="<?php echo API; ?>">
                                    <input type="hidden" name="id">
                                    <input type="hidden" name="object" value="FAQ">
                                    <input type="hidden" name="action" value="delete" />
                                    <input type="hidden" name="user_token" value="<?php echo encrypt_data($user->id); ?>">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-question">Confirm action</h5>
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
                    <div class="tab-pane fade" id="new-faq" role="tabpanel" aria-labelledby="new-faq-tab">
                        <form action="<?php echo API; ?>" method="POST" role="form" id="new-faq-form" class="faq-form">
                            <div>
                                <div class="mb-3">
                                    <input type="hidden" name="object" value="FAQ">
                                    <input type="hidden" name="action" value="create">
                                    <input type="hidden" name="user_token" value="<?php echo encrypt_data($user->id); ?>">
                                    <div class="form-group row mb-3">
                                        <div class="col-md-12">
                                            <label for="question" class="col-form-label">Question</label>
                                            <textarea name="question" class="form-control" rows="3"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <div class="col-md-12">
                                            <label for="answer" class="col-form-label">Answer</label>
                                            <textarea name="answer" class="form-control summernote" rows="5"></textarea>
                                            <small class="characters-indicator float-right"></small>
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
                    <div class="tab-pane fade" id="edit-faq" role="tabpanel" aria-labelledby="edit-faq-tab">
                        <form action="<?php echo API; ?>" method="POST" role="form" id="edit-faq-form" class="faq-form">
                            <div>
                                <div class="mb-3">
                                    <input type="hidden" name="object" value="FAQ">
                                    <input type="hidden" name="action" value="update">
                                    <input type="hidden" name="user_token" value="<?php echo encrypt_data($user->id); ?>">
                                    <input type="hidden" name="id">
                                    <div class="form-group row mb-3">
                                        <div class="col-md-12">
                                            <label for="question" class="col-form-label">Question</label>
                                            <textarea name="question" class="form-control" rows="3"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <div class="col-md-12">
                                            <label for="answer" class="col-form-label">Answer</label>
                                            <textarea name="answer" class="form-control summernote" rows="5"></textarea>
                                            <small class="characters-indicator float-right"></small>
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
                                    <button type="button" class="btn btn-primary mx-2 cancel-edit-faq-btn"> Cancel</button>
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
        $('.summernote').summernote({
            placeholder: 'Add text here',
            tabsize: 2,
            height: 150
        });

        if ($("[name='route_action']").val().length) {
            var action = $("[name='route_action']").val();
            switch (action) {
                case 'new':

                    $('a[aria-controls="all-faqs"]').removeClass('active');
                    $('#all-faqs').removeClass('active');
                    $('a[aria-controls="new-faq"]').addClass('active');
                    $('#new-faq').addClass('active').addClass('show');
                    $('a[aria-controls="new-faq"]').closest('li').removeClass('d-none');

                    break;

                case 'edit':
                    var value = $("[name='route_value']").val();

                    if (value.length) {
                        editFAQ(value);

                        $('a[aria-controls="all-faqs"]').removeClass('active');
                        $('#all-faqs').removeClass('active');
                        $('a[aria-controls="edit-faq"]').addClass('active');
                        $('#edit-faq').addClass('active').addClass('show');
                        $('a[aria-controls="edit-faq"]').closest('li').removeClass('d-none');

                    }
                    break;

                default:
                    break;
            }
        }

        $('#faqs-table').DataTable({
            "processing": true,
            "serverSide": true,
            responsive: true,
            "order": [],
            "ajax": {
                url: "<?php echo API; ?>",
                data: function(d) {
                    d.object = 'FAQ';
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

        $("#new-faq-form").validate({
            rules: {
                question: {
                    required: true,
                    minlength: 2
                },
                slug: {
                    required: true,
                    url: true
                },
                answer: {
                    required: true,
                    minlength: 10
                }
            },
            messages: {
                question: {
                    required: "Title is required",
                    minlength: "Title should be at least 2 characters"
                },
                slug: {
                    required: "Link is required",
                },
                answer: {
                    required: "Meta Description is required",
                    minlength: "Meta Description should be at least 150 characters",
                    maxlength: "Meta Description should be at least 200 characters"
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
                        $('#new-faq-form').find('.summernote').summernote('code', '<p><br></p>');
                        toastr.success(response.message);
                        $('#faqs-table').DataTable().ajax.reload(null, false);

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

        $(document).on('click', '.edit-faq-btn', function() {
            var id = $(this).attr('data-id');

            editFAQ(id);

            $('a[aria-controls="all-faqs"]').removeClass('active');
            $('#all-faqs').removeClass('active');
            $('a[aria-controls="edit-faq"]').addClass('active');
            $('#edit-faq').addClass('active').addClass('show');
            $('a[aria-controls="edit-faq"]').closest('li').removeClass('d-none');
        });

        $("#edit-faq-form").validate({
            rules: {
                question: {
                    required: true,
                    minlength: 2
                },
                slug: {
                    required: true,
                    url: true
                },
                answer: {
                    required: true,
                    minlength: 10
                }
            },
            messages: {
                question: {
                    required: "Title is required",
                    minlength: "Title should be at least 2 characters"
                },
                slug: {
                    required: "Link is required",
                },
                answer: {
                    required: "Meta Description is required",
                    minlength: "Meta Description should be at least 150 characters",
                    maxlength: "Meta Description should be at least 200 characters"
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
                        $('#faqs-table').DataTable().ajax.reload(null, false);

                        if ($("[name='route_action']").val().length) {
                            window.location = $("[name='route_view']").val();
                        }

                        $('a[aria-controls="edit-faq"]').removeClass('active');
                        $('#edit-faq').removeClass('active');
                        $('a[aria-controls="all-faqs"]').addClass('active');
                        $('#all-faqs').addClass('active').addClass('show');
                        $('a[aria-controls="edit-faq"]').closest('li').addClass('d-none');

                    },
                    error: function(data) {
                        toastr.error(data.responseJSON.message);
                    }
                });
            }
        });

        $(document).on('click', '.cancel-edit-faq-btn', function() {
            var id = $(this).attr('data-id');

            $('a[aria-controls="edit-faq"]').removeClass('active');
            $('#edit-faq').removeClass('active');
            $('a[aria-controls="all-faqs"]').addClass('active');
            $('#all-faqs').addClass('active').addClass('show');
            $('a[aria-controls="edit-faq"]').closest('li').addClass('d-none');
        });

        $(document).on('click', '.delete-faq-btn', function() {
            var id = $(this).attr('data-id');
            $('#delete-faq-form').find("[name='id']").val(id);
            $('#delete-modal').modal('toggle');
        });

        $(document).on('submit', '#delete-faq-form', function(e) {
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
                    $('#faqs-table').DataTable().ajax.reload(null, false);
                    $('#delete-modal').modal('toggle');

                },
                error: function(data) {
                    toastr.error(data.responseJSON.message);
                    $('#delete-modal').modal('toggle');
                }
            });
        });
    });

    function editFAQ(id) {
        $.ajax({
            type: 'GET',
            url: '<?php echo API; ?>',
            data: {
                object: 'FAQ',
                action: 'get_details',
                id: id
            },
            cache: false,
            dataType: 'JSON',
            success: function(response) {
                $('#edit-faq-form').find('[name="id"]').val(response.id).end()
                    .find('[name="question"]').val(response.question).end()
                    .find('[name="answer"]').summernote('code', response.answer);

                if (response.published == 1) {
                    $('#edit-faq-form').find('input[name="published"]').prop('checked', true);
                }
            }
        });
    }
</script>

<?php
include_once $dir . '/includes/footer.php';
?>