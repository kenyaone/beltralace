<?php
$dir = dirname(__DIR__);
include_once $dir . '/includes/header.php';
$id = Functions::decryptData($value);
$user = User::getById($id);
$user_logs = UserTransactionLog::getByUser($id);
?>
<main class="content">
    <div class="container-fluid p-0">

        <div class="d-flex justify-content-between mb-4">
            <h1 class="h3">Profile: <?php echo $user->username; ?></h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo DIRADMIN; ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo DIRADMIN; ?>users">Users</a></li>
                    <li class="breadcrumb-item active"><?php echo $user->username; ?></li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <div class="col-md-4 col-xl-3">
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Profile Details</h5>
                    </div>
                    <div class="card-body text-center">
                        <img src="<?php echo $user->avatar ? UPLOADS_PATH . '/avatars/' . $user->avatar : ASSETS_PATH . '/admin/img/user-avatar.png'; ?>" alt="<?php echo $user->username ?>" class="img-fluid rounded-circle mb-2" width="128" height="128" />
                        <h5 class="card-title mb-0"><?php echo $user->first_name ." ".$user->last_name ?></h5>
                        <div class="text-muted mb-2">(<?php echo $user->username ?>)</div>
                    </div>

                    <hr class="my-0" />
                    <div class="card-body">
                        <h5 class="h6 card-title">Contact Info</h5>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-1"><span class="fas fa-envelope fa-fw me-1"></span> <?php echo $user->email ?></li>
                            <li class="mb-1"><span class="fa fa-phone fa-fw me-1"></span> <a href="tel:<?php echo $user->phone ?>"> <?php echo $user->phone ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-8 col-xl-9">
                <div class="card">
                    <div class="card-header">

                        <h5 class="card-title mb-0">Activities</h5>
                    </div>
                    <div class="card-body h-100">
                        <?php

                        if(count($user_logs) > 0){
                            foreach($user_logs as $log){
                        ?>
                            <div class="d-flex align-items-start">
                                <img src="<?php echo $user->avatar ? UPLOADS_PATH . '/avatars/' . $user->avatar : ASSETS_PATH . '/admin/img/user-avatar.png'; ?>" width="36" height="36" class="rounded-circle me-2" alt="Vanessa Tucker">
                                <div class="flex-grow-1">
                                    <?php
                                        $hour_of_the_day = date('H');
                                        $split_time = explode(":", $log->time_difference);
                                        $time_past = "";

                                        if($split_time[0] <= $hour_of_the_day){
                                            $log_stamp = "Today ".$log->log_time;
                                            if($split_time[0] < 1){
                                                $time_past = $split_time[1]."m ago";
                                            }
                                            else{
                                                $time_past = $split_time[1]."h ago";
                                            }
                                        }
                                        else if($split_time[0] > 24 && $split_time[0] <= (24 + $hour_of_the_day)){
                                            $log_stamp = "Yesterday ".$log->log_time;
                                            $time_past = $split_time[1]."h ago";
                                        }
                                        else{
                                            $log_stamp = $log->log_date;
                                        }
                                    ?>
                                    <small class="float-end text-navy"><?php echo $time_past; ?></small>
                                    <strong><?php echo $log->name;?></strong> <?php echo $log->description;?><br>
                                    <small class="text-muted"><?php echo $log_stamp;?></small><br>

                                </div>
                            </div>
                            <hr>
                        <?php
                            }
                        }
                        else{
                        ?>
                        <div class="d-flex align-items-start">
                            No activities to display
                        </div>
                        <?php
                        }
                        ?>

                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<?php
include_once $dir . '/includes/footer.php';
?>