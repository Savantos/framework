jQuery(document).ready(function($) {

    // Re-usable Functions

    var resetSlide = function() {
        $('.slides-edit, .slides-edit-image, .slides-edit-content').hide();
    }

    var getParent = function(selector) {
        return $(selector).closest('li.slides-item');
    }

    var shortenText = function(text, amount) {
        var short = text.trim().substring(0, amount);
        if ( text.length > amount ) {
            return short + " ...";
        } else {
            return short;
        }
    }

    // Sortable List and Update
  
    $("#tf-slides-list").sortable({
        placeholder: 'ui-state-highlight',
        handle : '.slides-icon-move',
        revert: true,
        update : function () {
            var order = 1;
            $("li").each( function() {
                $(this).find('input[name*="order"]').val(order);
                order++;
            });
        }
    });

    // Sort - Reset size of Slide when clicking on Handle

    $('.slides-icon-move').mousedown(function(){
        resetSlide();
    });

    // Sort - Match UI Highlight Placeholder to height of selected Slide

    $('body').delegate('.slides-icon-move', 'sortstart', function(){
        var uiHeight = $(this).parent().parent().parent().css('height');
        $('li.ui-state-highlight').css('min-height', uiHeight );
    });
      
    // Edit - Click on main Edit Button
    
    $('.slides-icon-edit').click(function () {

        resetSlide();

        var slideTop = $(this).parent().parent().parent();
        var slideType = slideTop.find('.slides-edit .slide-type-selection input').val();

        slideTop.find('.slides-edit').show();

        if ( slideType == 'contdent' ) {
                slideTop.find('.slides-edit-content').show();
            } else if ( slideType == 'imdage' ) {
                slideTop.find('.slides-edit-image').show();
            } else {

            }
        });

    // Edit - Change Slide Type

    $('.slides-edit .slide-type-selection input').change(function(){

        var parent = getParent($(this));

        if ( $(this).val() == 'content') {

            parent.find('.slides-edit-image').hide();
            parent.find('.slides-edit-content').show('slow');
            parent.find('.slide-thumbnail').animate({'width':'400px'}, 'slow');
            parent.find('.slide-content-preview').show('slow');

        } else {

            parent.find('.slides-edit-content').hide();
            parent.find('.slide-content-preview').hide();
            parent.find('.slides-edit-image').show('slow');
            parent.find('.slide-thumbnail').animate({'width':'678px'}, 'slow');

        }

    })

    // Update Preview Slide

    $('#slide-content-header, #slide-content-text, #slide-content-link-text, ').on('keyup', function(){

            var parent = getParent($(this));
            var destination = $(this).data('preview');
            var preview = $(this).val();

            getParent($(this)).find('.' + destination).text(shortenText(preview,130));

    });

    // Delete Slide
    
    $('.slider-delete').click(function () {
    var thisbox = $(this);    
        
    jConfirm('Can you confirm this? (You\'ll still need to click on \'Update\')', 'Confirmation Dialog', function(r) {
        if (r) {
                $(thisbox).parent().parent().find('input[name*="delete"]').val('true');
                $(thisbox).parent().parent().slideUp('slow')
                }
        });    
        
    });
    
    // Upload Slide Image
    
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
    
    // Show Additional Options
    
    $('#slidertype_new').change(function(){
      if($(this).val() == 'content'){
        $('tr.extra-options').show();
      }
    });

  });