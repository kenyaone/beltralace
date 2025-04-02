<?php
$dir = dirname(__DIR__);
include_once __DIR__ . '/includes/auth-header.php';
?>
<main class="d-flex w-100">
    <div class="container d-flex flex-column">
        <div class="row vh-100">
            <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
                <div class="d-table-cell align-middle">

                    <div class="text-center mt-4 pb-3">
                        <h1 class="h2">Leave a review</h1>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="m-sm-3">
                                <form id="user-review-form" action="<?php echo API;?>">
                                    <input type="hidden" name="object" value="Review">
                                    <input type="hidden" name="action" value="create">
                                    <div class="mb-3">
                                        <label class="form-label">Name</label>
                                        <input class="form-control form-control-lg" type="text" name="name" placeholder="Enter your name" required/>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input class="form-control form-control-lg" type="email" name="email" placeholder="Enter your email" required/>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label">Review</label>
                                        <textarea class="form-control form-control-lg" name="review" placeholder="Enter your review" rows="6" required></textarea>
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
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-bottom-right",
            "timeOut": "10000",
        };

        $("#user-review-form").validate({
            messages: {
                name: {
                    required: "Name is required",
                    minlength: "Name should be at least 2 characters"
                },
                email: {
                    required: "Email is required",
                    minlength: "Email should be at least 2 characters"
                },
                review: {
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
                        window.location = '<?php echo WEBSITE; ?>';

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
include_once __DIR__ . '/includes/auth-footer.php';
?>