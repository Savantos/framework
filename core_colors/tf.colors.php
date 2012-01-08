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

function themeforce_update_logo_colors() {
    
    if ( isset($_POST['grab_logo_colors'] ) == '1') {

        $logo = get_option( 'tf_logo' );
        tf_logocolors( $logo );
        wp_redirect( wp_get_referer() );
        exit;
        
    }    

}

add_action('admin_init', 'themeforce_update_logo_colors');


/*
 * tf_logocolors ( above ) is stored within the individual theme (uses theme options) but calls on tf_dynamiccolors ( below )
 */


function tf_dynamiccolors( $colorimage ) {
    
    // Extract Colors
    
    // Defaults
    $delta = 24;
    $reduce_brightness = true;
    $reduce_gradients = true;
    $num_results = 10;

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
    */
    // Create Awesome Palette
    
        // standard
    
        // echo $colors[0];
        $s1 = tf_colorpalette( $colors[1], 'primary' );
        /* $s2 = tf_colorpalette( $colors[1], 'secondary' );
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

    $rgb = _color_unpack( $hex, true );
    $hsl = _color_rgb2hsl( $rgb );
    
    // Extract HSL values
    
    $h = $hsl[0];
    $s = $hsl[1];
    $l = $hsl[2];
    
    $colors = array();
    
    // Create Final Products
    /*
    if ( $type == 'primary' ) {
        $primary = array( '0.3', '0.5', '0.7' );
        $saturation = '0.4';
        foreach ($primary as $value) {
            $hsl = array ($h, $saturation, $value);
            $rgb = _color_hsl2rgb( $hsl );
            $color = _color_pack( $rgb, true );
            $colors[] = $color;
            
        }
    }
    */
    if ( $type == 'primary' ) {
        // Dark    
        $hsl = array ($h, 0.3, 0.2);
        $rgb = _color_hsl2rgb( $hsl );
        $color = _color_pack( $rgb, true );
        $colors[] = $color;
        // Light
        $hsl = array ($h, 0.3, 0.6);
        $rgb = _color_hsl2rgb( $hsl );
        $color = _color_pack( $rgb, true );
        $colors[] = $color; 
        // Active
        $hsl = array ($h, 0.6, 0.4);
        $rgb = _color_hsl2rgb( $hsl );
        $color = _color_pack( $rgb, true );
        $colors[] = $color;
        }
    
    if ( $type == 'secondary' ) {
        $secondary = array( '0.3', '0.7' );
        $saturation = '1.0';
        foreach ($secondary as $value) {
            $hsl = array ($h, $saturation, $value);
            $rgb = _color_hsl2rgb( $hsl );
            $color = _color_pack( $rgb, true );
            $colors[] = $color;
        }
    }
    
    return $colors;
}


function hex2rgb($color)
{
    
    if ($color[0] == '#')
        $color = substr($color, 1);

    if (strlen($color) == 6)
        list($r, $g, $b) = array($color[0].$color[1],
                                 $color[2].$color[3],
                                 $color[4].$color[5]);
    elseif (strlen($color) == 3)
        list($r, $g, $b) = array($color[0].$color[0], $color[1].$color[1], $color[2].$color[2]);
    else
        return false;

    $r = hexdec($r); $g = hexdec($g); $b = hexdec($b);

    return array($r, $g, $b);
    
}

function rgb2hsl($rgb){
   
     $clrR = ($rgb[0] / 255);
     $clrG = ($rgb[1] / 255);
     $clrB = ($rgb[2] / 255);
   
     $clrMin = min($clrR, $clrG, $clrB);
     $clrMax = max($clrR, $clrG, $clrB);
     $deltaMax = $clrMax - $clrMin;
   
     $L = ($clrMax + $clrMin) / 2;
   
     if (0 == $deltaMax){
         $H = 0;
         $S = 0;
         }
    else{
         if (0.5 > $L){
             $S = $deltaMax / ($clrMax + $clrMin);
             }
        else{
             $S = $deltaMax / (2 - $clrMax - $clrMin);
             }
         $deltaR = ((($clrMax - $clrR) / 6) + ($deltaMax / 2)) / $deltaMax;
         $deltaG = ((($clrMax - $clrG) / 6) + ($deltaMax / 2)) / $deltaMax;
         $deltaB = ((($clrMax - $clrB) / 6) + ($deltaMax / 2)) / $deltaMax;
         if ($clrR == $clrMax){
             $H = $deltaB - $deltaG;
             }
        else if ($clrG == $clrMax){
             $H = (1 / 3) + $deltaR - $deltaB;
             }
        else if ($clrB == $clrMax){
             $H = (2 / 3) + $deltaG - $deltaR;
             }
         if (0 > $H) $H += 1;
         if (1 < $H) $H -= 1;
         }
     return array($H, $S, $L);
     }
     
/*
function hsl2rgb($hsl) {
      $h = $hsl[0]; 
      $s = $hsl[1]; 
      $v = $hsl[2]; 
    
    if($s == 0) {
        $r = $g = $B = $v * 255;
    } else {
        $var_H = $h * 6;
        $var_i = floor( $var_H );
        $var_1 = $v * ( 1 - $s );
        $var_2 = $v * ( 1 - $s * ( $var_H - $var_i ) );
        $var_3 = $v * ( 1 - $s * (1 - ( $var_H - $var_i ) ) );

        if       ($var_i == 0) { $var_R = $v     ; $var_G = $var_3  ; $var_B = $var_1 ; }
        else if  ($var_i == 1) { $var_R = $var_2 ; $var_G = $v      ; $var_B = $var_1 ; }
        else if  ($var_i == 2) { $var_R = $var_1 ; $var_G = $v      ; $var_B = $var_3 ; }
        else if  ($var_i == 3) { $var_R = $var_1 ; $var_G = $var_2  ; $var_B = $v     ; }
        else if  ($var_i == 4) { $var_R = $var_3 ; $var_G = $var_1  ; $var_B = $v     ; }
        else                   { $var_R = $v     ; $var_G = $var_1  ; $var_B = $var_2 ; }

        $r = round($var_R * 255);
        $g = round($var_G * 255);
        $B = round($var_B * 255);
    }    
    return array($r, $g, $B);
}
*/

function hsl2rgb($hsl) {
  $h = $hsl[0];
  $s = $hsl[1];
  $l = $hsl[2];
  $m2 = ($l <= 0.5) ? $l * ($s + 1) : $l + $s - $l*$s;
  $m1 = $l * 2 - $m2;
  return array(round(_color_hue2rgb($m1, $m2, $h + 0.33333)*255),
               round(_color_hue2rgb($m1, $m2, $h)*255),
               round(_color_hue2rgb($m1, $m2, $h - 0.33333)*255));
}
    
function _color_hue2rgb($m1, $m2, $h) {
  $h = ($h < 0) ? $h + 1 : (($h > 1) ? $h - 1 : $h);
  if ($h * 6 < 1) return $m1 + ($m2 - $m1) * $h * 6;
  if ($h * 2 < 1) return $m2;
  if ($h * 3 < 2) return $m1 + ($m2 - $m1) * (0.66666 - $h) * 6;
  return $m1;
}
?>