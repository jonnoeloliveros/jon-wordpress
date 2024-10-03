<?php
    $contact_title = (get_field('contact_title')) ? '<h1 class="mb-3">' . get_field('contact_title') . '</h1>' : '';
    $contact_description = get_field('contact_description');
    $contact_address = get_field('contact_address');
    $contact_email = get_field('contact_email');
    $contact_phone = get_field('contact_phone');
    $contact_map = get_field('contact_map');
    $contact_form_description = get_field('contact_form_description');

    if ($contact_title || $contact_description || $contact_address || $contact_email || $contact_phone || $contact_map || $contact_form_description) {
        ?>
        <!-- Contact Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <?php
                    if ($contact_title || $contact_description) {
                        echo '<div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">' . $contact_title . $contact_description . '</div>';
                    }
                ?>
                <div class="row g-4">
                    <?php
                        echo '<div class="col-12">
                                <div class="row gy-4">';
                                    if ($contact_address) {
                                        echo '<div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.1s">
                                                <div class="bg-light rounded p-3">
                                                    <div class="d-flex align-items-center bg-white rounded p-3" style="border: 1px dashed rgba(0, 185, 142, .3)">
                                                        <div class="icon me-3" style="width: 45px; height: 45px;">
                                                            <i class="fa fa-map-marker-alt text-primary"></i>
                                                        </div>
                                                        <span>' . $contact_address . '</span>
                                                    </div>
                                                </div>
                                            </div>';
                                    }
                                    if ($contact_email) {
                                        echo '<div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.3s">
                                                <div class="bg-light rounded p-3">
                                                    <div class="d-flex align-items-center bg-white rounded p-3" style="border: 1px dashed rgba(0, 185, 142, .3)">
                                                        <div class="icon me-3" style="width: 45px; height: 45px;">
                                                            <i class="fa fa-envelope-open text-primary"></i>
                                                        </div>
                                                        <span>' . $contact_email . '</span>
                                                    </div>
                                                </div>
                                            </div>';
                                    }
                                    if ($contact_phone) {
                                        echo '<div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.5s">
                                                <div class="bg-light rounded p-3">
                                                    <div class="d-flex align-items-center bg-white rounded p-3" style="border: 1px dashed rgba(0, 185, 142, .3)">
                                                        <div class="icon me-3" style="width: 45px; height: 45px;">
                                                            <i class="fa fa-phone-alt text-primary"></i>
                                                        </div>
                                                        <span>' . $contact_phone . '</span>
                                                    </div>
                                                </div>
                                            </div>';
                                    }
                                    
                        echo '</div></div>';

                        if ($contact_map) {
                            echo '<div class="col-md-6 wow fadeInUp" data-wow-delay="0.1s">' . $contact_map . '</div>';
                        }
                    ?>
                    <div class="col-md-6">
                        <div class="wow fadeInUp" data-wow-delay="0.5s">
                            <?php echo $contact_form_description; ?>
                            <form>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="name" placeholder="Your Name">
                                            <label for="name">Your Name</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="email" class="form-control" id="email" placeholder="Your Email">
                                            <label for="email">Your Email</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="subject" placeholder="Subject">
                                            <label for="subject">Subject</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <textarea class="form-control" placeholder="Leave a message here" id="message" style="height: 150px"></textarea>
                                            <label for="message">Message</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-primary w-100 py-3" type="submit">Send Message</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Contact End -->
        <?php
    }
?>