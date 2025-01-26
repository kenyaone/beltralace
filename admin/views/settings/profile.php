<?php
$dir = dirname(__DIR__);
include_once $dir . '/includes/header.php';
?>
<main class="content">
    <div class="container-fluid p-0">

        <h1 class="h3 mb-3 pb-3">Profile</h1>

        <div class="row">
            <div class="col-md-3 col-xl-2">

                <div class="card">
                    <div class="list-group list-group-flush" role="tablist">
                        <a class="list-group-item list-group-item-action active" data-bs-toggle="list" href="#account" role="tab">
                            Account
                        </a>
                        <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#password" role="tab">
                            Password
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-9 col-xl-10">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="account" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Profile</h5>
                            </div>
                            <div class="card-body">
                                <form action="<?php echo API; ?>" method="POST" role="form" id="update-user-form" class="user-form">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div>
                                                <div class="mb-3">
                                                    <input type="hidden" name="object" value="User">
                                                    <input type="hidden" name="action" value="update">
                                                    <input type="hidden" name="id" value="<?php echo Auth::current_user()->id; ?>">
                                                    <div class="form-group row mb-3">
                                                        <div class="col-md-6">
                                                            <label for="first_name" class="col-form-label">First Name</label>
                                                            <input type="text" name="first_name" class="form-control" autocomplete="off">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="last_name" class="col-form-label">Last Name</label>
                                                            <input type="text" name="last_name" class="form-control" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-3">
                                                        <div class="col-md-12">
                                                            <label for="username" class="col-form-label">Username</label>
                                                            <input type="text" name="username" class="form-control" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-3">
                                                        <div class="col-md-6">
                                                            <label for="email" class="col-form-label">Email</label>
                                                            <input type="text" name="email" class="form-control" autocomplete="off">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="phone" class="col-form-label">Phone</label>
                                                            <input type="text" name="phone" class="form-control" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-3">
                                                        <div class="col-md-12">
                                                            <label class="form-label" for="inputUsername">Biography</label>
                                                            <textarea rows="3" class="form-control" name="biography" placeholder="Tell something about yourself"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-4">
                                            <div class="text-center">
                                                <img alt="<?php echo $user->username ?>" src="<?php echo $user->avatar ? UPLOADS_PATH . '/avatars/' . $user->avatar : ASSETS_PATH . '/admin/img/user-avatar.png'; ?>" class="rounded-circle img-responsive mt-2" width="128" height="128" />
                                                <div class="mt-2">
                                                    <span class="btn btn-primary"><i class="fas fa-upload"></i> Upload</span>
                                                </div>
                                                <small>For best results, use an image at least 128px by 128px in .jpg format</small>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Update</button>
                                </form>

                            </div>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="password" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Password</h5>
                            </div>
                            <div class="card-body">
                                <form>
                                    <div class="mb-3">
                                        <label class="form-label" for="inputPasswordCurrent">Current password</label>
                                        <input type="password" class="form-control" id="inputPasswordCurrent">
                                        <small><a href="#">Forgot your password?</a></small>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="inputPasswordNew">New password</label>
                                        <input type="password" class="form-control" id="inputPasswordNew">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="inputPasswordNew2">Verify password</label>
                                        <input type="password" class="form-control" id="inputPasswordNew2">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </form>

                            </div>
                        </div>
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

        getUserDetails(<?php echo Auth::current_user()->id; ?>);

        $("#update-user-form").validate({
            rules: {
                first_name: {
                    required: true,
                    minlength: 2
                },
                last_name: {
                    required: true,
                    minlength: 2
                },
                username: {
                    required: true,
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
                first_name: {
                    required: "First name is required",
                },
                last_name: {
                    required: "Last name is required",
                },
                username: {
                    required: "Username is required",
                },
                phone: {
                    required: "Phone is required",
                },
                email: {
                    required: "Email is required",
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
                        toastr.success(response.message);

                        getUserDetails(<?php echo Auth::current_user()->id; ?>);

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

    function getUserDetails(id) {
        $.ajax({
            type: 'GET',
            url: '<?php echo API; ?>',
            data: {
                object: 'User',
                action: 'get_details',
                id: id
            },
            cache: false,
            dataType: 'JSON',
            success: function(response) {
                $('#update-user-form').find('[name="id"]').val(response.id).end()
                    .find('[name="first_name"]').val(response.first_name).end()
                    .find('[name="last_name"]').val(response.last_name).end()
                    .find('[name="email"]').val(response.email).end()
                    .find('[name="phone"]').val(response.phone).end()
                    .find('[name="username"]').val(response.username).end()
                    .find('[name="biography"]').val(response.biography).end();
            }
        });
    }
</script>

<?php
include_once $dir . '/includes/footer.php';
?>