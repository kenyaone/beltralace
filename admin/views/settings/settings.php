<?php
$dir = dirname(__DIR__);
include_once $dir . '/includes/header.php';
?>
<main class="content">
    <div class="container-fluid p-0">

        <h1 class="h3 mb-3 pb-3">Settings</h1>

        <div class="row">
            <div class="col-md-12 col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <form action="<?php echo API; ?>" method="POST" role="form" id="edit-settings-form" class="settings-form">
                            <div>
                                <div class="mb-3">
                                    <input type="hidden" name="object" value="Settings">
                                    <input type="hidden" name="action" value="update">
                                    <input type="hidden" name="user_token" value="<?php echo encrypt_data($user->id); ?>">
                                    <input type="hidden" name="id" value="1">
                                    <div class="form-group row mb-3">
                                        <div class="col-md-12">
                                            <label for="name" class="col-form-label">Name</label>
                                            <input type="text" name="name" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <div class="col-md-6">
                                            <label for="phone" class="col-form-label">Phone</label>
                                            <input type="text" name="phone" class="form-control" autocomplete="off">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email" class="col-form-label">Email</label>
                                            <input type="email" name="email" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <div class="col-md-12">
                                            <label for="address" class="col-form-label">Address</label>
                                            <textarea name="address" class="form-control summernote" rows="3"></textarea>
                                            <small class="characters-indicator float-right"></small>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <h5 class="card-title">Brand</h5>
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <div class="col-md-12">
                                            <label for="tagline" class="col-form-label">Tag line</label>
                                            <textarea name="tagline" class="form-control summernote" rows="3"></textarea>
                                            <small class="characters-indicator float-right"></small>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <h5 class="card-title">Socials</h5>
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <div class="col-md-4">
                                            <label for="facebook" class="col-form-label">Facebook</label>
                                            <input type="text" name="facebook" class="form-control" autocomplete="off">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="instagram" class="col-form-label">Instagram</label>
                                            <input type="text" name="instagram" class="form-control" autocomplete="off">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="linkedin" class="col-form-label">LinkedIn</label>
                                            <input type="text" name="linkedin" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <div class="col-md-4">
                                            <label for="youtube" class="col-form-label">YouTube</label>
                                            <input type="text" name="youtube" class="form-control" autocomplete="off">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="twitter" class="col-form-label">Twitter</label>
                                            <input type="text" name="twitter" class="form-control" autocomplete="off">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="tiktok" class="col-form-label">Tiktok</label>
                                            <input type="text" name="tiktok" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <button type="submit" class="btn btn-primary"> Update</button>
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
        // if ($("[name='route_action']").val().length) {
        //     var action = $("[name='route_action']").val();
        //     switch (action) {
        //         case 'new':

        //             $('a[aria-controls="all-sms-templates"]').removeClass('active');
        //             $('#all-sms-templates').removeClass('active');
        //             $('a[aria-controls="new-sms-template"]').addClass('active');
        //             $('#new-sms-template').addClass('active').addClass('show');
        //             $('a[aria-controls="new-sms-template"]').closest('li').removeClass('d-none');

        //             break;

        //         case 'edit':
        //             var value = $("[name='route_value']").val();

        //             if (value.length) {
        //                 editSettings(value);

        //                 $('a[aria-controls="all-sms-templates"]').removeClass('active');
        //                 $('#all-sms-templates').removeClass('active');
        //                 $('a[aria-controls="edit-sms-template"]').addClass('active');
        //                 $('#edit-sms-template').addClass('active').addClass('show');
        //                 $('a[aria-controls="edit-sms-template"]').closest('li').removeClass('d-none');

        //             }
        //             break;

        //         default:
        //             break;
        //     }
        // }

        getSettings();

        $("#edit-settings-form").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 2
                },
                phone: {
                    required: true,
                    minlength: 10
                },
                email: {
                    required: true,
                }
            },
            messages: {
                name: {
                    required: "Name is required",
                },
                phone: {
                    required: "Phone is required",
                },
                email: {
                    required: "Email is required",
                },
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
                        toastr.success(response.message);

                        getSettings();

                        // if ($("[name='route_action']").val().length) {
                        //     window.location = $("[name='route_view']").val();
                        // }

                        $('a[aria-controls="edit-sms-template"]').removeClass('active');
                        $('#edit-sms-template').removeClass('active');
                        $('a[aria-controls="all-sms-templates"]').addClass('active');
                        $('#all-sms-templates').addClass('active').addClass('show');
                        $('a[aria-controls="edit-sms-template"]').closest('li').addClass('d-none');

                    },
                    error: function(data) {
                        toastr.error(data.responseJSON.message);
                    }
                });
            }
        });

    });

    function getSettings() {
        $.ajax({
            type: 'GET',
            url: '<?php echo API; ?>',
            data: {
                object: 'Settings',
                action: 'get_settings'
            },
            cache: false,
            dataType: 'JSON',
            success: function(response) {
                $('#edit-settings-form').find('[name="id"]').val(response.id).end()
                    .find('[name="name"]').val(response.name).end()
                    .find('[name="phone"]').val(response.phone).end()
                    .find('[name="email"]').val(response.email).end()
                    .find('[name="address"]').val(response.address).end()
                    .find('[name="tagline"]').val(response.tagline).end()
                    .find('[name="facebook"]').val(response.facebook).end()
                    .find('[name="instagram"]').val(response.instagram).end()
                    .find('[name="linkedin"]').val(response.linkedin).end()
                    .find('[name="youtube"]').val(response.youtube).end()
                    .find('[name="twitter"]').val(response.twitter).end()
                    .find('[name="tiktok"]').val(response.tiktok).end();
            }
        });
    }
</script>

<?php
include_once $dir . '/includes/footer.php';
?>