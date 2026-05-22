<section class="page-header">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="page-header-content">
                    <h1>Teaching jobs</h1>
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item">
                            <a href="#">Home</a>
                        </li>
                        <li class="list-inline-item">/</li>
                        <li class="list-inline-item">
                            Teaching Jobs
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="contact-info section-padding">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-6">
                <div class="section-heading center-heading">
                    <h3>Language Teacher Application</h3>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <p class="mb-5">
                    Language teachers are the heart of our organization, and we deeply appreciate your dedication. That’s why we 
                    strive to connect you with exceptional and engaging students while providing top-tier communication, academic 
                    support, and seamless administrative processes for scheduling, payments, and more.
                </p>
                <form action="/" id="job-application-form">
                    <input type="hidden" name="object" value="Enquiry">
                    <input type="hidden" name="action" value="teaching_job_application">
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-success contact__msg" style="display: none" role="alert">
                                Your message was sent successfully.
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <input type="text" name="first_name" class="form-control" placeholder="First Name" required>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <input type="text" name="mmiddle_name" class="form-control" placeholder="Middle Name" required>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <input type="text" name="last_name" class="form-control" placeholder="Last Name" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input type="text" name="phone" id="email" class="form-control" placeholder="Phone" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input type="text" name="email" id="email" class="form-control" placeholder="Email Address" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input type="text" name="address" class="form-control" placeholder="Address" required>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <input type="text" name="town" class="form-control" placeholder="Town" required>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <input type="text" name="country" class="form-control" placeholder="Country" required>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input type="text" name="nationality" class="form-control" placeholder="Nationality" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input type="text" name="native_language" class="form-control" placeholder="Native language" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="cv">Curriculum Vitae</label>
                                <input type="file" name="cv">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="cover_letter">Cover letter</label>
                                <input type="file" name="cover_letter">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="passport">Passport-sized photo</label>
                                <input type="file" name="passport">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="mt-4 text-right">
                            <button class="btn btn-main" type="submit">Send Application <i class="fa fa-angle-right ml-2"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<script src="https://www.google.com/recaptcha/api.js?render=<?php echo GOOGLE_RECAPTCHA_SITE_KEY; ?>"></script>
<script>
	$(document).ready(function(){
        $("#job-application-form").validate({
            submitHandler: function(form) {
                grecaptcha.ready(function() {
                    grecaptcha.execute('<?php echo GOOGLE_RECAPTCHA_SITE_KEY; ?>', {action: 'teaching_job_application'}).then(function(token) {
                        var formData = new FormData(form);
                        formData.append('g-recaptcha-response', token);
                        $.ajax({
                            url: '<?php echo API; ?>',
                            method: 'POST',
                            data: formData,
                            processData: false,
                            dataType: 'json',
                            contentType: false,
                            success: function(response, textStatus, jqXHR) {
                                form.reset();
                                $('#modal-form').modal('hide');
                                $('#modal-confirm').modal('show');
                            },
                            error: function(data) {
                                toastr.error(data.responseJSON.message);
                            }
                        });
                    });
                });
            }
        });
	})
</script>
<script type="application/ld+json">{"@context":"https://schema.org","@type":"JobPosting","title":"Language Teacher","description":"BELTRALACE is hiring native-speaking language trainers for Swahili, English, French, Spanish, German, and more. We offer remote and Nairobi-based roles with flexible schedules.","datePosted":"2026-04-08","validThrough":"2026-12-31","employmentType":["FULL_TIME","PART_TIME","CONTRACTOR"],"hiringOrganization":{"@type":"Organization","name":"BELTRALACE","sameAs":"https://www.beltralace.com"},"jobLocation":[{"@type":"Place","address":{"@type":"PostalAddress","addressLocality":"Nairobi","addressCountry":"KE"}}],"jobLocationType":"TELECOMMUTE"}</script>