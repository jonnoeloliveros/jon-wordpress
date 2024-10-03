jQuery(document).ready(function($) {
    var galleryFrame;

    $('.gallery-picker-button').on('click', function(e) {
        e.preventDefault();

        // If the media frame already exists, reopen it.
        if (galleryFrame) {
            galleryFrame.open();
            return;
        }

        // Create a new media frame
        galleryFrame = wp.media({
            title: 'Select Images for Gallery',
            button: {
                text: 'Use these images'
            },
            multiple: true // Allow multiple image selection
        });

        // When images are selected, this function runs
        galleryFrame.on('select', function() {
            var selection = galleryFrame.state().get('selection');
            var imageIds = [];
            var previewHtml = '';

            // Loop through the selected images
            selection.map(function(attachment) {
                attachment = attachment.toJSON();
                imageIds.push(attachment.id);
                previewHtml += '<img src="' + attachment.url + '" style="max-width: 100px; margin-right: 10px;">';
            });

            // Store the image IDs in the hidden input
            $('#gallery_images').val(imageIds.join(','));

            // Display the selected images
            $('.gallery-preview').html(previewHtml);
        });

        // Open the media frame
        galleryFrame.open();
    });
});
