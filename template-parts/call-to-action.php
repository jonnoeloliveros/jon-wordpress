<?php
    $cta_title              = get_field('cta_title');
    $cta_description        = get_field('cta_description');
    $cta_phone_label        = get_field('cta_phone_label');
    $cta_phone_number       = get_field('cta_phone_number');
    $cta_appointment_button = get_field('cta_appointment_button');
    $cta_image              = get_field('cta_image');

    if ($cta_title || $cta_description || $cta_phone_label || $cta_phone_number || $cta_appointment_button || $cta_image) {
        ?>
        <!-- Call to Action Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="bg-light rounded p-3">
                    <div class="bg-white rounded p-4" style="border: 1px dashed rgba(0, 185, 142, .3)">
                        <div class="row g-5 align-items-center">
                            <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                                <?php
                                    if ($cta_image) {
                                        echo '<img class="img-fluid rounded w-100" src="' . $cta_image . '" alt="">';
                                    }
                                ?>
                            </div>
                            <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                                <?php
                                    if ($cta_title || $cta_description) {
                                        echo '<div class="mb-4">';
                                            if ($cta_title) {
                                                echo '<h1 class="mb-3">' . $cta_title . '</h1>';
                                            }
                                            echo $cta_description;
                                        echo '</div>';
                                    }

                                    if ($cta_phone_label && $cta_phone_number) {
                                        echo '<a href="tel:' . $cta_phone_number . '" class="btn btn-primary py-3 px-4 me-2"><i class="fa fa-phone-alt me-2"></i>' . $cta_phone_label . '</a>';
                                    }

                                    if (!empty($cta_appointment_button)) {
                                        echo '<a href="' . $cta_appointment_button['url'] . '" target="' . $cta_appointment_button['target'] . '" class="btn btn-dark py-3 px-4"><i class="fa fa-calendar-alt me-2"></i>' . $cta_appointment_button['title'] . '</a>';
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Call to Action End -->
        <?php
    }
?>