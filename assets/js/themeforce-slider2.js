jQuery(document).ready(function($) {

    // Functions

    var resetTypes = function() {
        $('.slide-edit-image, .slide-edit-content').hide();
    }

    var resetSlide = function() {
        $('.slide-edit').hide();
        resetTypes();
    }

    var getParent = function(selector) {
        return $(selector).closest('li.slide-item');
    }

    var getID = function(selector) {
        return $(selector).closest('li.slide-item').find('input[name*="id"]').val();
    }

    var shortenText = function(text, amount) {
        var short = text.trim().substring(0, amount);
        if ( text.length > amount ) {
            return short + "...";
        } else {
            return short;
        }
    }

    var switchType = function(selector, slideType) {

        var parent = getParent(selector);

        resetTypes();

        switch (slideType)

        {
            case 'content':
                parent.find('.slide-edit-content').show('slow');
                parent.find('.slide-thumbnail').animate({'width':'400px'}, 'slow');
                parent.find('.slide-content-preview').show('slow');
                break;

            default:
                parent.find('.slide-edit-content').hide();
                parent.find('.slide-content-preview').hide();
                parent.find('.slide-edit-image').show('slow');
                parent.find('.slide-thumbnail').animate({'width':'678px'}, 'slow');
        }

    }

    var switchPreview = function(selector, slideType) {

        var parent = getParent(selector);
        console.log(parent);

        switch (slideType)

        {
            case 'content':
                parent.find('.slide-thumbnail').animate({'width':'400px'}, 'slow');
                parent.find('.slide-content-preview').show('slow');
                break;

            default:
                parent.find('.slide-content-preview').hide();
                parent.find('.slide-thumbnail').animate({'width':'678px'}, 'slow');
        }

    }

    // Init

    $('ul#tf-slides-list li.slide-item').each(function(index) {
        var slideType = $(this).find('.slide-edit .slide-type-selection input:checked').val();
        console.log(slideType);
        switchPreview($(this),slideType);
    });

    // Sortable List and Update
  
    $("#tf-slides-list").sortable({
        placeholder: 'ui-state-highlight',
        handle : '.slide-icon-move',
        revert: true,
        update : function () {
            var order = 1;
            $("li.slide-item").each( function() {
                $(this).find('input[name*="order"]').val(order);
                var id = $(this).find('input[name*="id"]').val();
                jQuery.post( ajaxurl, { action: 'tf_slides_update_order', postid: id, neworder: order } );
                console.log('Fired - Update Slide Order - ID: ' + id + ', Order: ' + order);
                order++;
            });
        }
    });

    // Sort - Reset size of Slide when clicking on Handle

    $('.slide-icon-move').mousedown(function(){
        resetSlide();
    });

    // Sort - Match UI Highlight Placeholder to height of selected Slide

    $('body').delegate('.slide-icon-move', 'sortstart', function(){

        var uiHeight = $(this).parent().parent().parent().css('height');
        $('li.ui-state-highlight').css('min-height', uiHeight );

    });
      
    // Edit - Click on main Edit Button
    
    $('.slide-icon-edit').click(function () {

        resetSlide();
        getParent($(this)).find('.slide-edit').show();

        var slideType = getParent($(this)).find('.slide-edit .slide-type-selection input:checked').val();
        getParent($(this)).find( '.slide-edit-' + slideType ).show();

    });

    // Edit - Change Slide Type

    $('.slide-edit .slide-type-selection input').change(function(){

        var parent = getParent($(this));
        var slideType = $(this).val();

        jQuery.post( ajaxurl, { action: 'tf_slides_update_type', postid: getID($(this)), type: slideType } );

        switchType($(this),slideType);
        switchPreview($(this),slideType);

    })

    // Update Preview Slide

    $('.slide-content-header, .slide-content-desc, .slide-content-button').on('keyup', function(){

        var meta = $(this).data('meta');
        var value = $(this).val();

        getParent($(this)).find('.preview-' + meta).text(shortenText(value,130));

    });

    // Update Slide Content

    $('.slide-content-header, .slide-content-desc, .slide-content-button, .slide-content-link').on('change', function(){

        var id = getID($(this));
        var meta = $(this).data('meta');
        var value = $(this).val();

        jQuery.post( ajaxurl, { action: 'tf_slides_update_content', postid: id, key: meta, value: value }, function(data) {
            console.log(data);
        } );

        console.log('Fired - Update Slide Content - ID: ' + id + ', Meta: ' + meta + ', Value: ' + value);

    });

    // Delete Slide
    
    $('.slide-icon-delete').click(function () {

        getParent($(this)).css({opacity:'0.8', "background-color":"#B81D21"}).animate({opacity: "0.1"}, 650, "swing").hide('slow');
        jQuery.post( ajaxurl, { action: 'tf_slides_delete', postid: getID($(this)) } );

        console.log('Fired - Delete Slide');

    });
    
    // Upload Slide Image (still useful?)
    
    $('#upload_image_button').click(function() {
        formfield = jQuery('#tfslider_image').attr('name');
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true&amp;tab=gallery');
        $('tr.post_title, tr.image_alt, tr.post_except, tr.post_content, tr.url, tr.0, tr.align, tr.image-size').hide();
        return false;
    });

    window.send_to_editor = function(html) {
        imgurl = jQuery('img',html).attr('src');
        jQuery('#tfslider_image').val(imgurl);
        tb_remove();
    }

  });