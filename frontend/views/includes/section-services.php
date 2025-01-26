<?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, API);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

$post_data = array(
    'object' => 'Widget',
    'action' => 'get_by_section',
    'section' => 'services'
);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
$response = curl_exec($ch);
$services_widgets = json_decode($response);

if(count($services_widgets)){
?>

<section class="services section pt-0">
    <div class="container">
        <div class="row">
            <div class="col-lg-12" data-aos="zoom-in">
                <div class="section-title">
                    <h2>Our services</h2>
                    <p>At HPEW, we prioritize the mental and physical well-being of healthcare professionals through our comprehensive services:</p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
			<?php
			foreach($services_widgets as $widget){
				if($widget->published){
			?>
            <div class="col-lg-4 col-md-6 col-12" data-aos="zoom-in">
                <div class="single-service">
                    <i class="icofont icofont-prescription"></i>
                    <h4><?php echo $widget->title; ?></h4>
                    <p><?php echo $widget->body; ?></p>
                </div>
            </div>
			<?php
				}
			}
			?>
        </div>
    </div>
</section>

<?php
}
?>