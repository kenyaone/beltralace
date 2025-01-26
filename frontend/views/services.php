<!-- Breadcrumbs -->
<div class="breadcrumbs overlay mb-5">
    <div class="container">
        <div class="bread-inner">
            <div class="row">
                <div class="col-12">
                    <h2>Our Services</h2>
                    <ul class="bread-list">
                        <li><a href="/">Home</a></li>
                        <li><i class="icofont-simple-right"></i></li>
                        <li class="active">Our Services</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumbs -->

<?php

include 'includes/section-services.php';

?>

<script>
    $(document).ready(function() {
        loadPageContent();
    });

    function loadPageContent() {
        $.ajax({
            type: 'GET',
            url: '<?php echo API; ?>',
            data: {
                object: 'Page',
                action: 'get_by_slug',
                slug: 'services'
            },
            cache: false,
            dataType: 'JSON',
            success: function(response) {
                $('.page-subtitle').html(response.sub_title);
                $('.page-content').html(response.body);
            }
        });
    }
</script>