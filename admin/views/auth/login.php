<?php
$dir = dirname(__DIR__);
include_once $dir . '/includes/auth-header.php';
?>
<main class="d-flex w-100">
    <div class="container d-flex flex-column">
        <div class="row vh-100">
            <div class="col-sm-10 col-md-8 col-lg-5 col-xl-5 mx-auto d-table h-100">
                <div class="d-table-cell align-middle">

                    <div class="text-center mt-4 pb-3">
                        <h1 class="h2">Login</h1>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="m-sm-3">
                                <form id="login-form" data-test='EWD' action="<?php echo API; ?>">
                                    <input type="hidden" name="object" value="Auth">
                                    <input type="hidden" name="action" value="login">
                                    <input type="hidden" name="redirect" value="<?php echo DIRADMIN ?>">
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input class="form-control form-control" type="email" name="email" placeholder="Enter your email" required />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <input class="form-control form-control" type="password" name="password" placeholder="Enter your password" required />
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div class="form-check align-items-center">
                                            <input id="customControlInline" type="checkbox" class="form-check-input" value="remember-me" name="remember-me" checked>
                                            <label class="form-check-label text-sm" for="customControlInline">Remember me</label>
                                        </div>
                                        <div>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#reset-password-modal"><label class="text-sm">Forgot password?</label></a>
                                        </div>
                                    </div>
                                    <div class="d-grid gap-2 mt-3">
                                        <button type="submit" class="btn btn-primary">Sign in</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="text-center mb-3">
                        Don't have an account? <a href="pages-sign-up.html">Sign up</a>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</main>
<div class="modal fade" id="reset-password-modal" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="<?php echo API; ?>" id="reset-password-form">
            <input type="hidden" name="object" value="User">
            <input type="hidden" name="action" value="request_pass_reset">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reset password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body m-3">
                    <div class="mb-3">
                        <label class="form-label">Enter your email address to reset your password</label>
                        <input type="email" name="email" class="form-control form-control-lg" placeholder="name@example.com">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="confirm-reset">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function() {
        // $('input[type="password"]').hideShowPassword({
        //     show: false,
        //     innerToggle: true,
        //     states: {
        //         shown: {
        //             toggle: {
        //                 content: '<i class="fa fa-eye-slash"></i>'
        //             }
        //         },
        //         hidden: {
        //             toggle: {
        //                 content: '<i class="fa fa-eye"></i>'
        //             }
        //         }
        //     }
        // });
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-bottom-right",
            "timeOut": "10000",
        };

        // $(document).on('submit', '#login-form', function(e) {
        //     e.preventDefault();
        //     var formObj = $(this);
        //     var formURL = formObj.attr("action");
        //     if (window.FormData !== undefined) {
        //         var formData = new FormData(this);
        //         $.ajax({
        //             beforeSend: function() {
        //                 $(".preloader").fadeIn();
        //             },
        //             complete: function() {
        //                 $(".preloader").fadeOut();
        //             },
        //             type: 'POST',
        //             url: formURL,
        //             data: formData,
        //             dataType: 'json',
        //             contentType: false,
        //             cache: false,
        //             processData: false,
        //             success: function(data, textStatus, jqXHR) {
        //                 if (parseInt(data.status) == 1) {
        //                     toastr.success(data.message);
        //                     window.location = data.redirect;
        //                     // location.reload();
        //                 } else {
        //                     toastr.error(data.message);
        //                 }
        //             },
        //             error: function(jqXHR, textStatus, errorThrown) {
        //                 toastr.error(jqXHR);
        //             }
        //         });
        //     }
        // });

        $("#login-form").validate({
            submitHandler: function(form) {
                var formData = new FormData(form);
                $.ajax({
                    beforeSend: function() {
                        // $('#overlay').removeClass('d-none');
                    },
                    complete: function() {
                        // $('#overlay').addClass('d-none');
                    },
                    url: '<?php echo API; ?>',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    success: function(response, textStatus, jqXHR) {
                        // form.reset();
                        toastr.success(response.message);

                        setTimeout(function() {
                            window.location.href = '<?php echo CMS; ?>?code=' + response.code;
                        }, 1500);

                    },
                    error: function(data) {
                        toastr.error(data.responseJSON.message);
                    }
                });
            }
        });

        $("#reset-password-form").validate({
            rules: {
                email: {
                    required: true,
                    minlength: 2
                }
            },
            messages: {
                email: {
                    required: "Email is required",
                    minlength: "Email should be at least 2 characters"
                }
            },
            submitHandler: function(form) {
                var formData = new FormData(form);
                $.ajax({
                    beforeSend: function() {
                        $('#reset-password-modal').modal('toggle');
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
                    },
                    error: function(data) {
                        form.reset();
                        toastr.error(data.responseJSON.message);
                    }
                });
            }
        });
    });
</script>
<?php
include_once $dir . '/includes/auth-footer.php';
?>