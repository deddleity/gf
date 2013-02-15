<?php
/*
 Plugin Name: CalculatorPro Calculators
 Plugin URI: http://www.calculatorpro.org
 Description: A collection of over 300 embeddable calculators.
 Version: 1.1.2
 Author: jgadbois
 Author URI: http://www.domainsuperstar.com
 */
?>
<?php
   define("CP_VERSION","1.1.2");

   // setup callbacks
   add_action('admin_menu', 'CP_add_settings');
   add_action('admin_init', 'CP_init_fn');

   // ajax
   add_action('wp_ajax_preview_calc', 'CP_preview_calc');

   add_shortcode('calc', 'CP_widget_shortcode');

   // allow shortcode in widget
   add_filter('widget_text', 'do_shortcode');
   add_action('init', 'CP_load_text_domain');
   add_action('init', 'CP_setup_actions');

	
	 function CP_load_text_domain() {
		 $plugin_dir = trailingslashit( basename(dirname(__FILE__)) ) . 'lang/';
	 	 load_plugin_textdomain( 'calculator_pro', false, $plugin_dir );
	 }

   function CP_setup_actions() {
     if( get_option('cp_version') != CP_VERSION ) {
       update_option('cp_version', CP_VERSION);
     }
   }

   function CP_add_settings() {
      add_options_page('Calculator Pro', 'Calculator Pro', 'administrator', __FILE__, 'CP_options_page_fn');
   }

   function CP_options_page_fn() {
   ?>
      <div class="wrap">
         <div class="icon32" id="icon-options-general"><br></div>
         <h2>Calculator Pro Calculators</h2>
         <div>Provided by <a href="http://www.calculatorpro.com/" target="_blank">CalculatorPro.com</a>. Can't find the calculator you're looking for?  <a href="http://www.calculatorpro.com/contact/" target="_blank">Contact us</a>.</div>
         <div>
            <h3>Support Calculator Pro!</h2>
            <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
               <input type="hidden" name="cmd" value="_s-xclick">
               <input type="hidden" name="hosted_button_id" value="SR6TBXHTVJV2N">
               <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
               <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
            </form>
         </div>
         <form action="options.php" method="post">
            <?php settings_fields('calc_pro_options'); ?>
            <?php do_settings_sections(__FILE__); ?>
            <p class="submit">
               <input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
            </p>
            <h3>Add This Calculator To Your Site</h3>
            <table class="form-table"><tbody><tr valign="top"><th scope="row">Step 1: Select a Calculator</th>
               <td><?php CP_section_calcs() ?></td>
            </tr></tbody></table>
            <div id="cp_shortcode"></div>
         </form>
          <h3>Calculator Preview</h3>
          <div id="widget_preview">
             Select a calculator for a preview.
          </div>
      </div>
   <?php
   }

   function CP_getCalculatorList()
   {
      $calcList = wp_remote_get("http://calculatorpro.com/wp-content/plugins/calcs/ajax/widget.php?action=getCalcList");

      if(is_wp_error($calcList)) {
        // echo $calcList->get_error_message();
      } else {
        return json_decode($calcList['body']);
      }
   }

   function CP_getCalculator($id)
   {
      $calc = wp_remote_get("http://calculatorpro.com/wp-content/plugins/calcs/ajax/widget.php?action=getCalc&calc_id=" . $id);

      if(is_wp_error($calc)) {
        // echo $calc->get_error_message();
      } else {
        return json_decode($calc['body']);  
      }
   }

   function CP_init_fn(){
      // set up settings
      register_setting('calc_pro_options', 'calc_pro_options' );

      add_settings_section('main_section', 'Calculator Settings', 'CP_section_text_fn', __FILE__);
      add_settings_field('start_color', 'Background Color', 'CP_color_start_fn', __FILE__, 'main_section');
      add_settings_field('end_color', 'Border Color', 'CP_color_end_fn', __FILE__, 'main_section');
      add_settings_field('text_color', 'Text Color', 'CP_color_text_fn', __FILE__, 'main_section');
      add_settings_field('calc_width', 'Calculator Width', 'CP_width_fn', __FILE__, 'main_section');
      add_settings_field('font_size', 'Calculator Font Size (16px default)', 'CP_font_size_fn', __FILE__, 'main_section');
      add_settings_field('allow_links', 'Allow Links to Calculator Pro', 'CP_allow_links_fn', __FILE__, 'main_section');
      add_settings_field('currency_symbol', 'Currency Symbol', 'CP_currency_symbol_fn', __FILE__, 'main_section');
      // add_settings_field('use_custom_css', 'Use Custom CSS', 'CP_use_custom_css_fn', __FILE__, 'main_section');
      // add_settings_field('custom_css', 'Custom CSS Styles', 'CP_custom_css_fn', __FILE__, 'main_section');

      wp_enqueue_script('calc-colorpicker', plugins_url('js/colorpicker/colorpicker.js', __FILE__), array('jquery'));
      wp_enqueue_script('cp-app', plugins_url('js/app.js', __FILE__), array('jquery'));
      wp_register_style('cp-colorpicker', plugins_url('js/colorpicker/css/colorpicker.css', __FILE__));
      wp_enqueue_style('cp-colorpicker');
      wp_register_style('cp-styles', plugins_url('css/cp_styles.css', __FILE__));
      wp_enqueue_style('cp-styles');

      if(!get_option('calc_pro_options'))
      {
         $defaults = array('start_color'=>'#378CAF', 'end_color'=>'#006395', 'calc_width'=>260, 'text_color'=>'#FFFFFF', 'allow_links'=>true, 'font_size'=>'16px');
         add_option('calc_pro_options', $defaults);
      }
   }
   
   function CP_use_custom_css_fn()
   {
      $options = get_option('calc_pro_options');
      $checked = !empty($options['use_custom_css']) && $options['use_custom_css'] ? "checked=checked" : "";

      echo "<input name='calc_pro_options[use_custom_css]' type='checkbox' value='true' " . $checked . "/> <span>Checking this box will disable all default styles (including the above settings).</span>";
   }  

   function CP_currency_symbol_fn() {
      $options = get_option('calc_pro_options');
      $symbol = !empty($options['currency_symbol']) ? $options['currency_symbol'] : "$";
      echo "<input name='calc_pro_options[currency_symbol]' type='text' value='" . $symbol . "' /> <span>Use this setting to globally change answers from $ to the symbol of your choice.</span>";
   }

   function CP_custom_css_fn()
   {
      $options = get_option('calc_pro_options');
      $css = !empty($options['custom_css']) ? $options['custom_css'] : "";

      echo "<textarea name='calc_pro_options[custom_css]' rows='4' style='width: 400px;'>$css</textarea><br/><p>This CSS will only be used if Use Custom CSS is selected.</p>";
   }   


   function CP_section_text_fn()
   {
      echo '<p>Settings for your CalculatorPro widgets.  Select a calculator below to see a live preview of how your calculator will look with the chosen settings.</p>';
   }

   function CP_shortcode_section_text_fn()
   {
      echo '<p>Select a calculator from the list to generate a shortcode that can be placed in any Post or Page</p>';
   }

   function CP_section_calcs()
   {
      $calcs = CP_getCalculatorList();

      echo "<select id='cp_shortcode_picker' name='cp_shortcode_picker'>";

      echo "<option value=''>Choose Calculator</option>";

      foreach($calcs as $item=>$value)
      {
         echo "<option value='$item'>$value</option>";
      }

      echo "</select>";
   }

   function CP_color_start_fn()
   {
      $options = get_option('calc_pro_options');
      echo "<div class=\"colorHolder\"><div class=\"colorSelector\" id=\"bgColorSelector\"><div id=\"start_color\" style=\"background-color: {$options['start_color']}\"></div></div></div>";
      echo "<input id='calc_start_color_string' name='calc_pro_options[start_color]' size='40' type='hidden' value='{$options['start_color']}' />";
   }

   function CP_color_end_fn()
   {
      $options = get_option('calc_pro_options');
      echo "<div class=\"colorHolder\"><div class=\"colorSelector\" id=\"bgColorSelector\"><div id=\"end_color\" style=\"background-color: {$options['end_color']}\"></div></div></div>";
      echo "<input id='calc_end_color_string' name='calc_pro_options[end_color]' size='40' type='hidden' value='{$options['end_color']}' />";
   }

   function CP_color_text_fn()
   {
      $options = get_option('calc_pro_options');
      echo "<div class=\"colorHolder\"><div class=\"colorSelector\" id=\"bgColorSelector\"><div id=\"text_color\" style=\"background-color: {$options['text_color']}\"></div></div></div>";
      echo "<input id='calc_text_color_string' name='calc_pro_options[text_color]' size='40' type='hidden' value='{$options['text_color']}' />";
   }

   function CP_width_fn()
   {
      $options = get_option('calc_pro_options');
      echo "<input id='calc_width_string' name='calc_pro_options[calc_width]' size='40' type='text' value='{$options['calc_width']}' />";
   }

   function CP_font_size_fn() {
      $options = get_option('calc_pro_options');

      if(!$options['font_size'])
         $options['font_size'] = '16px';
      echo "<select id='calc_pro_options[calc_width]' name='calc_pro_options[font_size]'>";
      for($i = 10; $i <= 20; $i++) {
         echo "<option value='{$i}px'" . ($options['font_size'] == "{$i}px" ? " selected" : "") . ">{$i}px</option>";
      }
      echo "</select>";
   }

   function CP_allow_links_fn()
   {
      $options = get_option('calc_pro_options');
      $checked = $options['allow_links'] ? "checked=checked" : "";

      echo "<input name='calc_pro_options[allow_links]' type='checkbox' value='true' " . $checked . "/>";
   }

   function CP_rgb_to_html($rgbStr)
   {
		if( strpos( $rgbStr, "#" ) !== FALSE ) return $rgbStr;

		$rgbStr = substr($rgbStr, 4, sizeof($rgbStr)-2);
		$rgb = explode(',', $rgbStr);
		$r = $rgb[0]; $g = $rgb[1]; $b = $rgb[2];
		$r = intval($r); $g = intval($g); $b = intval($b);

		$r = dechex($r<0?0:($r>255?255:$r));
		$g = dechex($g<0?0:($g>255?255:$g));
		$b = dechex($b<0?0:($b>255?255:$b));

		$color = (strlen($r) < 2?'0':'').$r;
		$color .= (strlen($g) < 2?'0':'').$g;
		$color .= (strlen($b) < 2?'0':'').$b;
		return '#'.$color;
   }

   function CP_widget_shortcode($atts)
   {
      extract(shortcode_atts(array(
          'id' => '910',
          'text_color'=>null,
          'start_color'=>null,
          'end_color'=>null,
          'calc_width'=>null,
          'allow_links'=>null,
          'font_size'=>null,
          'use_custom_css'=>null,
          'currency_symbol'=>null,
          'unique_id'=>false
	), $atts));
		
        $calc = CP_getCalculator($id);

        $calc->fields = explode(",", $calc->fields);
        $options = get_option('calc_pro_options');

        $text_color = $text_color ? $text_color : $options['text_color'];
        $calc_width  = $calc_width ? $calc_width : $options['calc_width'];
        $start_color = CP_rgb_to_html($start_color ? $start_color : $options['start_color']);
        $end_color = CP_rgb_to_html($end_color ? $end_color : $options['end_color']);
        $allow_links = $allow_links ? $allow_links : $options['allow_links'];
        $font_size = $font_size ? $font_size : $options['font_size'];
        $use_custom_css = $use_custom_css ? $use_custom_css : (isset($options['use_custom_css']) ? $options['use_custom_css'] : false);
        $currency_symbol = $currency_symbol ? $currency_symbol : (isset($options['currency_symbol']) ? $options['currency_symbol'] : '$');
        $unique_id = $atts['unique_id'];
        $datas = '';
        if (CP_rgb_to_html($text_color) != '#ffffff' && CP_rgb_to_html($text_color) != '#FFFFFF' && CP_rgb_to_html($text_color) != 'white') {
          $datas .= ' data-textcolor="' . CP_rgb_to_html($text_color) . '"';
        }
        if ($calc_width != '260') {
          $datas .= ' data-calcwidth="' . $calc_width . 'px"';
        }
        if (CP_rgb_to_html($start_color) != '#378CAF' && CP_rgb_to_html($start_color) != '#378caf') {
          $datas .= ' data-backcolor="' . CP_rgb_to_html($start_color) . '"';
        }
        if (CP_rgb_to_html($end_color) != '#006395') {
          $datas .= ' data-bordcolor="' . CP_rgb_to_html($end_color) . '"';
        }
        if ($allow_links != null && $allow_links != 'null') {
          $datas .= ' data-anchor="2"';
        } else {
          $datas .= ' data-anchor="' . ( -1 * ($id * 7 + 36)) . '"';
        }
        if ($font_size != '16px') {
          $datas .= ' data-textsize="' . $font_size . '"';
        }

        if ($currency_symbol != null) {
          $datas .= ' data-currencysymbol="' . $currency_symbol . '"';
        }

        ob_start();
   ?>
      <div class="cp-calc-widget" data-calcid="<?php echo $id; ?>"<?php echo $datas; ?>></div><a href="http://www.calculatorpro.com/calculator/<?php $calc->name ?>"></a><script <?php echo ($unique_id ? 'id="wordpress_preview_calc_unique"' : ''); ?> src="http://www.calculatorpro.com/wp-content/plugins/calcs/js/widgetV4.min.js"></script>
   <?php
      $widget = ob_get_contents();
      ob_end_clean();
      return trim($widget);
   }


   function CP_preview_calc()
   {
      echo CP_widget_shortcode(array(
          'id' => $_POST['id'],
          'calc_width' => $_POST['calc_width'],
          'text_color' => $_POST['text_color'],
          'start_color' => $_POST['start_color'],
          'end_color' => $_POST['end_color'],
          'allow_links' => $_POST['allow_links'],
          'font_size' => $_POST['font_size'],
          'unique_id' => true
       ));
      die();
   }
?>
