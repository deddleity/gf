jQuery(document).ready(function($) {
   $('#start_color').ColorPicker({
      onShow: function (colpkr) {
         $(colpkr).fadeIn(500);
         return false;
      },
      onHide: function (colpkr, hex, rgb, el) {
        $('#start_color').css('backgroundColor','#' + hex);
        updateColors(true);
        $(colpkr).fadeOut(500);
         return false;
      },
      onChange: function (hsb, hex) {
        $('#start_color').css('backgroundColor','#' + hex);
        updateColors();
      },
      onSubmit: function(hsb, hex, rgb, el)
      {
         $('#start_color').css('backgroundColor','#' + hex);
         updateColors();
      }
   });

   $('#end_color').ColorPicker({
      onShow: function (colpkr) {
         $(colpkr).fadeIn(500);
         return false;
      },
      onHide: function (colpkr, hex, rgb, el) {
        $('#end_color').css('backgroundColor','#' + hex);
        updateColors(true);
        $(colpkr).fadeOut(500);
         return false;
      },
      onChange: function (hsb, hex) {
        $('#end_color').css('backgroundColor','#' + hex);
        updateColors();
      },
      onSubmit: function(hsb, hex, rgb, el)
      {
         $('#end_color').css('backgroundColor','#' + hex);
         updateColors();
      }
   });

   $('#text_color').ColorPicker({
      onShow: function (colpkr) {
         $(colpkr).fadeIn(500);
         return false;
      },
      onHide: function (colpkr, hex, rgb, el) {
        $('#text_color').css('backgroundColor','#' + hex);
        updateColors(true);
        $(colpkr).fadeOut(500);
         return false;
      },
      onChange: function (hsb, hex) {
        $('#text_color').css('backgroundColor','#' + hex);
        updateColors();
      },
      onSubmit: function(hsb, hex, rgb, el)
      {
         $('#text_color').css('backgroundColor','#' + hex);
         updateColors();
      }
   });   
   
   if($('#start_color').length > 0)
   {
      $('#start_color').ColorPickerSetColor($('#calc_start_color_string').val());
      $('#end_color').ColorPickerSetColor($('#calc_end_color_string').val());
      $('#text_color').ColorPickerSetColor($('#calc_text_color_string').val());
   }

   $('#cp_shortcode_picker').change(function() {
      $('#cp_shortcode').html('Step 2: Copy and paste the following shortcode into your Post, Page, or Widget: <b>[calc id=' + $(this).val() + ']</b>');
   });
   
   $('#link-colors').click(function() {
      $('#end_color').css('backgroundColor', $('#start_color').css('backgroundColor'));
      updateColors(true);
      return false;
   });   
   

   function updateColors(refresh)
   {
      $('#calc_end_color_string').val( $('#end_color').css('backgroundColor'));
      $('#calc_start_color_string').val( $('#start_color').css('backgroundColor'));
      $('#calc_text_color_string').val( $('#text_color').css('backgroundColor'));
      
      if(refresh)
         refreshPreview();
   }

   $('#cp_shortcode_picker, #calc_width_string, [name*="allow_links"], [name*="font_size"]').change(refreshPreview);
   
   $('[name*="allow_links"]').click(function() {
      if(!$(this).is(":checked")) {
         return confirm("Are you sure you want to remove links from your calculator? These links help to allow CalculatorPro.com to provide these widgets free of cost.");
      }
   });
   
   function refreshPreview() {
      if(!isNaN(parseInt($('#cp_shortcode_picker').val())))
      {   
         $('#widget_preview').html('<img class="waiting" src="/wp-admin/images/wpspin_light.gif" alt="">');         
         var data = {
            action: 'preview_calc',
            id: $('#cp_shortcode_picker').val(),
            calc_width:  $('#calc_width_string').val(),
            text_color: $('#calc_text_color_string').val(),
            start_color: $('#calc_start_color_string').val(),
            end_color: $('#calc_end_color_string').val(),
            allow_links: $('[name*="allow_links"]').is(":checked") ? 1 : null,
            font_size: $('[name*="font_size"]').val()
         };
         // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
         jQuery.post(ajaxurl, data, function(response) {
            $('#widget_preview')[0].innerHTML = response;
            var scriptTag = $('#wordpress_preview_calc_unique');
            var src = scriptTag.attr('src');
            var newScript = document.createElement('script');
            newScript.src = src;
            scriptTag.after(newScript);
         });
      }
   }
});