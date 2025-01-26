<?php
$dir = dirname(__DIR__);
include_once $dir . '/includes/auth-header.php';
?>
<main class="d-flex w-100">
    <div class="container d-flex flex-column">
        <div class="row vh-100">
            <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
                <div class="d-table-cell align-middle">

                    <div class="text-center mt-4 pb-3">
                        <h1 class="h2">Password Reset</h1>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="m-sm-3">
                                <form id="update-password-form" action="<?php echo API;?>">
                                    <input type="hidden" name="object" value="User">
                                    <input type="hidden" name="action" value="change_password">
                                    <input type="hidden" name="id" value="<?php echo $user_id; ?>">
                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <input class="form-control form-control-lg" type="password" name="password" placeholder="Enter your password" required/>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label">Confirm Password</label>
                                        <input class="form-control form-control-lg" type="password" name="confirm_password" placeholder="Enter your password" required/>
                                    </div>

                                    <div class="d-grid gap-2 mt-3">
                                        <button type="submit" class="btn btn-lg btn-primary">Submit</button>
                                    </div>
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


        $("#update-password-form").validate({
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
                    beforeSend: function () {
                        $('#overlay').removeClass('d-none');
                    },
                    complete: function () {
                        $('#overlay').addClass('d-none');  
                    },
                    url: $(form).attr('action'), 
                    method: 'POST',
                    data: formData,
                    processData: false,
                    dataType: 'json', 
                    contentType: false,
                    success: function (response, textStatus, jqXHR) {
                        // form.reset();
                        toastr.success(response.message);
                        window.location = '<?php echo DIRADMIN; ?>';

                    },
                    error: function (data) {
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