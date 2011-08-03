<?php
/*
 * Theme Force - Dynamic Color Palette Creation
 * --------------------------------------------
 * 
 * The basis for color extraction has been adopted from:
 * http://www.coolphptools.com/color_extract
 * which you can find in the file included below:
 */

require_once( TF_PATH . '/core_colors/colors.inc.php' );

/*
 * The remainder of the code was created for Theme Force with the majority
 * replicated from Drupal Color Module (i.e. unpack, rgb -> hsl, hsl -> rgb, pack)
 */

/*
 * Update Theme Colors based on Logo Image
 * TODO: Ability to update other themes (though they may require different color settings)
 */

function tf_logocolors($colorimage) {
    $hexarray = tf_dynamiccolors($colorimage);
    // Activate Custom Colors
        update_option('baseforce_custom_colors','#'.$hexarray[0]);
    // Primary
        update_option('baseforce_color_pri_dark','#'.$hexarray[0]);
        update_option('baseforce_color_pri_light','#'.$hexarray[1]);
        update_option('baseforce_color_pri_link','#'.$hexarray[2]);
    // Secondary
    /*
     * Still require better logic to extract secondary.
     */
}

function tf_dynamiccolors($colorimage) {
    
    // Extract Colors
    
    // Defaults
    $delta = 4;
    $reduce_brightness = true;
    $reduce_gradients = true;
    $num_results = 2;

    // Grab Image Colors
    $extractcolors = new GetMostCommonColors();
    $colorsummary = $extractcolors->Get_Color($colorimage, $num_results, $reduce_brightness, $reduce_gradients, $delta);
    
    foreach ($colorsummary as $hex => $count) {
         $colors[] = $hex;
    }
    
    /*
    
    // Echo Colors Extracted
    echo '<h3>Colors Extracted</h3>';
    echo '<div style="outline:1px gray solid;float:left;width:60px;height:60px;font-size:12px;font-family: Lucida Console;background-color:#'.$colors[0].'">'.$colors[0].'</div>';
    echo '<div style="outline:1px gray solid;float:left;width:60px;height:60px;font-size:12px;font-family: Lucida Console;background-color:#'.$colors[1].'">'.$colors[1].'</div><div class="clearfix"></div>';
    echo '<br /><h3>Various Arrays</h3>';
    
    // Create Awesome Palette
    
        // standard
    */
        // echo $colors[0];
        $s1 = tf_colorpalette($colors[0],'primary');
        /* $s2 = tf_colorpalette($colors[1],'secondary');
        $standard = array_merge($s1, $s2); */
        $standard = $s1;
        return $standard;
        
        /*

        
        echo '<br /><h3>TF Color Scheme</h3>';
        foreach ($standard as $color => $key) {
            echo '<div style="outline:1px gray solid;float:left;width:60px;height:60px;font-size:12px;background-color:#'.$key.'">'.$key.'</div>';
        }
	*/
    }

function tf_colorpalette($hex, $type) {

    // Conversion from Hex to RGB to HSL

    $rgb = _color_unpack($hex,true);
    echo '<pre> Unpack to RGB ';print_r($rgb);echo '</pre>';
    $hsl = _color_rgb2hsl($rgb);
    echo '<pre> RGB to HSL ';print_r($hsl);echo '</pre>';
    // Extract HSL values
    
    $h = $hsl[0];
    $s = $hsl[1];
    $l = $hsl[2];
    
    $colors = array();
    
    // Create Final Products
    /*
    if ( $type == 'primary' ) {
        $primary = array('0.3','0.5','0.7');
        $saturation = '0.4';
        foreach ($primary as $value) {
            $hsl = array ($h, $saturation, $value);
            $rgb = _color_hsl2rgb($hsl);
            $color = _color_pack($rgb,true);
            $colors[] = $color;
            
        }
    }
    */
    if ( $type == 'primary' ) {
        // Dark    
        $hsl = array ($h, 0.4, 0.2);
        $rgb = _color_hsl2rgb($hsl);
        $color = _color_pack($rgb,true);
        $colors[] = $color;
        // Light
        $hsl = array ($h, 0.4, 0.6);
        $rgb = _color_hsl2rgb($hsl);
        $color = _color_pack($rgb,true);
        $colors[] = $color; 
        // Active
        $hsl = array ($h, 0.6, 0.4);
        $rgb = _color_hsl2rgb($hsl);
        $color = _color_pack($rgb,true);
        $colors[] = $color;
        }
    
    if ( $type == 'secondary' ) {
        $secondary = array('0.3','0.7');
        $saturation = '1.0';
        foreach ($secondary as $value) {
            $hsl = array ($h, $saturation, $value);
            $rgb = _color_hsl2rgb($hsl);
            $color = _color_pack($rgb,true);
            $colors[] = $color;
        }
    }
    
    return $colors;
}

/**
 * Convert a hex color into an RGB triplet. 
 */ 

function _color_unpack($hex, $normalize = false) { 
  if (strlen($hex) == 4) { 
    $hex = $hex[1] . $hex[1] . $hex[2] . $hex[2] . $hex[3] . $hex[3]; 
  } 
  $c = hexdec($hex); 
  for ($i = 16; $i >= 0; $i -= 8) { 
    $out[] = number_format((($c >> $i) & 0xFF) / ($normalize ? 255 : 1),'100'); 
  } 
  return $out; 
} 

function _color_rgb2hsl($rgb) { 
  $r = $rgb[0]; 
  $g = $rgb[1]; 
  $b = $rgb[2]; 
  $min = min($r, min($g, $b)); 
  $max = max($r, max($g, $b)); 
  $delta = number_format($max - $min,'100'); 
  $l = number_format((($min + $max) / 2),'100'); 
  $s = 0; 
  if ($l > 0 && $l < 1) { 
    $s = number_format(($delta / ($l < 0.5 ? (2 * $l) : (2 - 2 * $l))),'100'); 
  } 
  $h = 0; 
  if ($delta > 0) { 
    if ($max == $r && $max != $g) $h += number_format((($g - $b) / $delta),'100'); 
    if ($max == $g && $max != $b) $h += number_format((2 + ($b - $r) / $delta),'100'); 
    if ($max == $b && $max != $r) $h += number_format((4 + ($r - $g) / $delta),'100'); 
    $h = number_format($h/6,'100'); 
  } 
  return array($h, $s, $l); 
} 

function _color_hsl2rgb($hsl) { 
  $h = $hsl[0]; 
  $s = $hsl[1]; 
  $l = $hsl[2]; 
  $m2 = number_format(($l <= 0.5) ? $l * ($s + 1) : $l + $s - $l*$s,'100'); 
  $m1 = number_format($l * 2 - $m2,'100'); 
  return array(_color_hue2rgb($m1, $m2, $h + (1/3)), 
               _color_hue2rgb($m1, $m2, $h), 
               _color_hue2rgb($m1, $m2, $h - (1/3))); 
}

/** 
 * Helper function for _color_hsl2rgb(). 
 */ 

function _color_hue2rgb($m1, $m2, $h) { 
  $h = number_format(($h < 0) ? $h + 1 : (($h > 1) ? $h - 1 : $h),'100'); 
  if ($h * 6 < 1) return $m1 + ($m2 - $m1) * $h * 6; 
  if ($h * 2 < 1) return $m2; 
  if ($h * 3 < 2) return $m1 + ($m2 - $m1) * ((2/3) - $h) * 6; 
  return $m1; 
} 

/** 
 * Convert an RGB triplet to a hex color. 
 */ 

function _color_pack($rgb, $normalize = false) { 
  foreach ($rgb as $k => $v) { 
    $out |= (($v * ($normalize ? 255 : 1)) << (16 - $k * 8)); 
  } 
  return str_pad(dechex($out), 6, 0, STR_PAD_LEFT); 
} 

/* $testrgb = array(0.2,0.75,0.4); //RGB to start with 
print_r($testrgb); */ 

/*
  print "Hex: "; 
  $testhex = "#C5003E"; 
  print $testhex; 
  $testhex2rgb = _color_unpack($testhex,true);  
  print "<br />RGB: "; 
  var_dump($testhex2rgb); 
  print "<br />HSL color module: "; 
  $testrgb2hsl = _color_rgb2hsl($testhex2rgb); //Converteren naar HSL 
  var_dump($testrgb2hsl); 
  print "<br />RGB: "; 
  $testhsl2rgb = _color_hsl2rgb($testrgb2hsl); // En weer terug naar RGB 
  var_dump($testhsl2rgb); 
  print "<br />Hex: "; 
  $testrgb2hex = _color_pack($testhsl2rgb,true); 
  var_dump($testrgb2hex); 
*/

    
?>