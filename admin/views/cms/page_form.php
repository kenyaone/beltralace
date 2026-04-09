<?php
$dir = dirname(__DIR__);
include_once $dir . '/includes/header.php';
?>
<input type="hidden" name="route_view" value="<?php echo DIRADMIN . $page; ?>">
<input type="hidden" name="route_action" value="<?php echo $action; ?>">
<input type="hidden" name="route_value" value="<?php echo $index; ?>">
<main class="content">
    <div class="container-fluid p-0">
        <div class="d-flex justify-content-between mb-4">
            <h1 class="h3">Pages</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo DIRADMIN; ?>">Home</a></li>
                    <li class="breadcrumb-item active">Pages</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-12 col-lg-12">
                <form action="<?php echo API; ?>" method="POST" role="form" id="page-form" class="page-form">
                    <div>
                        <div class="mb-3">
                            <input type="hidden" name="object" value="Page">
                            <input type="hidden" name="action" value="create">
                            <input type="hidden" name="id">
                            <input type="hidden" name="slug">
                            <input type="hidden" name="user_token" value="<?php echo encrypt_data($user->id); ?>">
                            <div class="form-group row mb-3">
                                <div class="col-md-12">
                                    <label for="title" class="col-form-label">Title</label>
                                    <input type="text" name="title" class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <div class="col-md-12">
                                    <label for="sub_title" class="col-form-label">Subtitle</label>
                                    <input type="text" name="sub_title" class="form-control" autocomplete="off">
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
                                    <textarea name="body" class="form-control" id="page-body" rows="5"></textarea>
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
                                <div class="col-md-12">
                                    <h5 class="card-title">Header Image</h5>
                                    <hr>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <div class="col-md-12">
                                    <div class="dropzone-area dropzone header_image" data-name="tempHeaderFile" id="new-header-image">
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
    var pageBodyEditor = null;
    ClassicEditor.create(document.querySelector('#page-body'), {
        placeholder: 'Add text here',
        toolbar: {
            items: ['heading', '|', 'bold', 'italic', 'underline', 'strikethrough', '|',
                    'bulletedList', 'numberedList', '|', 'blockQuote', 'code', '|',
                    'link', 'insertTable', '|', 'undo', 'redo']
        }
    }).then(function(editor) {
        pageBodyEditor = editor;
    }).catch(function(error) {
        console.error('CKEditor init error:', error);
    });

    $(document).ready(function() {

        <?php
        if($action == 'edit'){
        ?>
        $('#page-form').find('[name="action"]').val("update").end()
        $('#page-form').find('[name="id"]').val(<?php echo $index; ?>).end()
        editPage(<?php echo $index; ?>);
        <?php
        }
        ?>

        var new_page = $('#new-cover-image').initDropzone();
        var new_page_header = $('#new-header-image').initDropzone();

        $("#page-form").validate({
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
                var body = pageBodyEditor ? pageBodyEditor.getData() : '';
                var formData = new FormData(form);
                formData.set('body', body);
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
                        new_page.removeAllFiles();
                        new_page_header.removeAllFiles();

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

    function editPage(id) {
        $.ajax({
            type: 'GET',
            url: '<?php echo API; ?>',
            data: {
                object: 'Page',
                action: 'get_details',
                id: id
            },
            cache: false,
            dataType: 'JSON',
            success: function(response) {
                $('#page-form').find('[name="id"]').val(response.id).end()
                    .find('[name="slug"]').val(response.slug).end()
                    .find('[name="title"]').val(response.title).end()
                    .find('[name="sub_title"]').val(response.sub_title).end()
                    .find('[name="slug"]').val(response.slug).end()
                    .find('[name="meta_description"]').val(response.meta_description).end()
                    // .find('[name="cover_image"]').val(response.cover_image).end()
                    // .find('[name="cover_image_thumbnail"]').val(response.cover_image_thumbnail).end()
                    // .find('[name="header_image"]').val(response.header_image).end()
                if (pageBodyEditor) {
                    pageBodyEditor.setData(response.body || '');
                }

                    if (response.published == 1) {
                        $('#page-form').find('input[name="published"]').prop('checked', true);
                    }
            }
        });
    }

</script>

<?php
include_once $dir . '/includes/footer.php';
?>