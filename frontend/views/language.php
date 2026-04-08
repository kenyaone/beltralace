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
                            Language
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

// echo $child;
// echo $response;
// exit;

$widget = json_decode($response);
?>
<section class="about-section section-padding about-2">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-12">
                <div class="section-heading">
                    <span class="subheading">Know more about</span>
                    <h3><?php echo $widget ? $widget->title : "Swahili"; ?></h3>
                    <small>
                        <strong>
                            <i>
                                <?php echo $widget ? $widget->sub_title : "Learn Swahili from the heart of Africa with professional native speakers!"; ?>
                            </i>
                        </strong>
                    </small>
                </div>
                <p>
                    <?php
                    if($widget){
                        echo $widget->body;
                    }else{
                    ?>
                    Swahili is the most popular African language with over 150 million users, majority of whom
                    are reside in East Africa. It is the East African lingua franca. It is also the official language of
                    the African union because of its fast spread to the Western, Northern and Southern Africa as
                    a language of trade and inter-ethnic communication. It will not take long before Swahili
                    becomes a ‘must know’ language in Africa. We therefore warmly welcome you to register for
                    Swahili lessons at Beltralace, taught by experienced natives from East Africa.
                    <?php
                    }
                    ?>
                </p>

                <a href="#" class="btn btn-main" data-toggle="modal" data-target="#modal-form"><i class="fa fa-check mr-2"></i>Get started</a>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="about-img2">
                    <img src="<?php echo $widget ? UPLOAD_SERVER . '/' . $widget->image : 'https://images.pexels.com/photos/667202/pexels-photo-667202.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1' ?>" alt="" class="img-fluid" style="object-fit:cover; width: 100%">
                </div>
            </div>
        </div>
    </div>
</section>
