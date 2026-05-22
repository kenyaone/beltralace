<section class="page-header">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="page-header-content">
                    <h1><?php echo $child ? ucfirst(htmlspecialchars($child)) . ' Language Course | BELTRALACE' : 'Our Languages'; ?></h1>
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item">
                            <a href="#">Home</a>
                        </li>
                        <li class="list-inline-item">/</li>
                        <li class="list-inline-item">
                            <?php echo $child ? ucfirst(htmlspecialchars($child)) : 'Languages'; ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$url = implode("/", $_GET);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, API);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
$post_data = array(
    'object' => 'Widget',
    'action' => 'get_by_title',
    'title' => $child
);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
$response = curl_exec($ch);
$widget = json_decode($response);
?>
<section class="about-section section-padding about-2">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-12">
                <div class="section-heading">
                    <span class="subheading">Know more about</span>
                    <h3><?php echo $widget ? $widget->title : ucfirst($child); ?></h3>
                    <small>
                        <strong>
                            <i>
                                <?php echo $widget ? $widget->sub_title : "Learn " . ucfirst($child) . " with professional native speakers at BELTRALACE!"; ?>
                            </i>
                        </strong>
                    </small>
                </div>
                <p>
                    <?php
                    if($widget){
                        echo $widget->body;
                    } else {
                        echo "Learn " . ucfirst($child) . " with BELTRALACE — native-speaking trainers, flexible online and in-person lessons tailored to your level and goals. Based in Nairobi, Kenya, we warmly welcome you to enroll for " . ucfirst($child) . " lessons with experienced native speakers.";
                    }
                    ?>
                </p>
                <a href="#" class="btn btn-main" data-toggle="modal" data-target="#modal-form"><i class="fa fa-check mr-2"></i>Get started</a>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="about-img2">
                    <img src="<?php echo $widget ? UPLOAD_SERVER . '/' . $widget->image : 'https://images.pexels.com/photos/667202/pexels-photo-667202.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1' ?>" alt="<?php echo ucfirst($child); ?> language course at BELTRALACE, Nairobi" class="img-fluid" style="object-fit:cover; width: 100%">
                </div>
            </div>
        </div>
    </div>
</section>
