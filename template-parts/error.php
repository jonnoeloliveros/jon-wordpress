<?php
    $error_title = get_field('error_title');
    $error_message = get_field('error_message');
    $error_button = get_field('error_button');
?>
<!-- 404 Start -->
<div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <i class="bi bi-exclamation-triangle display-1 text-primary"></i>
                <span class="h1 display-1 d-block">404</span>
                <h1 class="mb-4"><?php echo $error_title; ?></h1>
                <?php
                    echo $error_message;
                    
                    if ($error_button) {
                        echo '<a class="btn btn-primary py-3 px-5" href="' . $error_button['url'] . '" target="' . $error_button['target'] . '">' . $error_button['title'] . '</a>';
                    }else {
                        echo '<a class="btn btn-primary py-3 px-5" href="' . home_url() . '">Go Back To Home</a>';
                    }
                ?>
            </div>
        </div>
    </div>
</div>
<!-- 404 End -->