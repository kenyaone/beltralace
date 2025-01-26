<?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, API);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

$post_data = array(
    'object' => 'Widget',
    'action' => 'get_by_section',
    'section' => 'banner'
);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
$response = curl_exec($ch);
$banner_widgets = json_decode($response);

if(count($banner_widgets)){
?>
<section class="slider">
	<div class="hero-slider ">
		<?php
		foreach($banner_widgets as $key => $widget){
		?>
		<div class="single-slider" style="background-image:url(<?php echo UPLOAD_SERVER . '/' . $widget->image; ?>)">
			<div class="hero-content-overlay">
				<div class="container">
					<div class="row">
						<div class="col-lg-7">
							<div class="text">
								<h1><?php echo $widget->title; ?></h1>
								<p><?php echo $widget->body; ?></p>
								<div class="button">
									<a href="/about-us" class="btn <?php echo (fmod($key, 2) == 0) ? 'primary' : ''; ?>">Learn More</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
		<?php
		}
		?>
		<!-- <div class="single-slider" style="background-image:url('/frontend/views/assets/img/slide1.jpg')">
			<div class="hero-content-overlay">
				<div class="container">
					<div class="row">
						<div class="col-lg-7">
							<div class="text">
								<h1>We Provide <span>Medical</span> Services That You Can <span>Trust!</span></h1>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris sed nisl
									pellentesque, faucibus libero eu, gravida quam. </p>
								<div class="button">
									<a href="/contact-us" class="btn primary">Contact Us</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div> -->
	</div>
</section>
<?php
}
?>

<section class="schedule">
	<div class="container">
		<div class="schedule-inner">
			<div class="row">
				<div class="col-lg-3 col-md-6 col-6" data-aos="zoom-out">
					<div class="single-schedule first">
						<div class="inner">
							<div class="icon">
								<i class="icofont-prescription"></i>
							</div>
							<div class="single-content">
								<h4>Compassion</h4>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-6" data-aos="zoom-out">
					<!-- single-schedule -->
					<div class="single-schedule middle">
						<div class="inner">
							<div class="icon">
								<i class="fa fa-podcast"></i>
							</div>
							<div class="single-content">
								<h4>Resilience</h4>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-12 col-6" data-aos="zoom-out">
					<div class="single-schedule last">
						<div class="inner">
							<div class="icon">
							<i class="fa fa-handshake-o"></i>
							</div>
							<div class="single-content">
								<h4>Support</h4>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-12 col-6" data-aos="zoom-out">
					<div class="single-schedule last">
						<div class="inner">
							<div class="icon">
								<i class="fa fa-users"></i>
							</div>
							<div class="single-content">
								<h4>Collaboration</h4>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<style>
	.hero-content-overlay {
		top: 0;
		left: 0;
		background: rgba(0, 0, 0, 0.4);
		height: 100%;
	}
</style>

<?php
include 'includes/section-services.php';
?>

<?php
include 'includes/section-cta.php';
?>

<!-- <script>
    $(document).ready(function() {
        getServicesWidgets();
    });

    function getServicesWidgets() {
        $.ajax({
            type: 'GET',
            url: '<?php echo API; ?>',
            data: {
                object: 'Widget',
                action: 'get_by_section',
                section: 'services'
            },
            cache: false,
            dataType: 'JSON',
            success: function(response) {
                $('.page-subtitle').html(response.sub_title);
                $('.page-content').html(response.body);
            }
        });
    }
</script> -->