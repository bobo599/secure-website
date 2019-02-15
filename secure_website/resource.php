<?php

if ($secure_website_settings['Load_CSS'] == 'Enabled')
{
add_action( 'theme-header', 'replaceL' );
function replaceL() {
  global $random; 
  global $secure_website_settings;
  global $TEMPLATE;
if ($handle = opendir(GSTHEMESPATH.'/'.$TEMPLATE.'/css')) {

    while (false !== ($entry = readdir($handle))) {

        if ($entry != "." && $entry != "..") { ?>
	    <link <?php if ($secure_website_settings['link_nonce'] == 'Enabled') { ?> nonce="<?php echo $random ?>" <?php } ?> rel="stylesheet" type="text/css" href="<?php get_theme_url(); ?>/css/<?php echo $entry?>" media="all" />
            <?php
        }
    }

    closedir($handle);
}

    if ($secure_website_settings['CSS_Resource'] != '') {
    $css_res = $secure_website_settings['CSS_Resource'];      
    foreach(preg_split("/[\s]+/", $css_res) as $line) {  
    if ($secure_website_settings['Subresource_Integrity'] == 'Enabled') {
    //sri
    $input = file_get_contents($line);
    $hash = hash('sha384', $input, true);
    $hash_base64 = base64_encode($hash);
    //sri end 
    }
?>
 <link <?php if ($secure_website_settings['link_nonce'] == 'Enabled') { ?> nonce="<?php echo $random ?>" <?php } ?> rel="stylesheet" type="text/css" href="<?php echo $line?>" <?php if ($secure_website_settings['Subresource_Integrity'] == 'Enabled') { ?> integrity="sha384-<?php echo $hash_base64; ?>" crossorigin="anonymous" <?php }?>  media="all" />
 <?php

   } 
  }
 } 
}



if ($secure_website_settings['Load_SCRIPT'] == 'Enabled')
{
add_action( 'theme-footer', 'replaceS' );
function replaceS() {
  global $random;
  global $secure_website_settings;
  global $TEMPLATE;
if ($handle = opendir(GSTHEMESPATH.'/'.$TEMPLATE.'/js')) {

    while (false !== ($entry = readdir($handle))) {

        if ($entry != "." && $entry != "..") { ?>
            <script <?php if ($secure_website_settings['script_nonce'] == 'Enabled') { ?> nonce="<?php echo $random ?>" <?php } ?> src="<?php get_theme_url(); ?>/js/<?php echo $entry?>"></script>
            <?php
        }
    }

    closedir($handle);
}
    if ($secure_website_settings['JS_Resource'] != '') {
    $js_res = $secure_website_settings['JS_Resource'];
    foreach(preg_split("/[\s]+/", $js_res) as $line){
    if ($secure_website_settings['Subresource_Integrity'] == 'Enabled') {
    //sri
    $input = file_get_contents($line);
    $hash = hash('sha384', $input, true);
    $hash_base64 = base64_encode($hash);
    //sri end
    }
 ?>
 <script <?php if ($secure_website_settings['script_nonce'] == 'Enabled') { ?> nonce="<?php echo $random ?>" <?php } ?> src="<?php echo $line?>" <?php if ($secure_website_settings['Subresource_Integrity'] == 'Enabled') { ?> integrity="sha384-<?php echo $hash_base64; ?>" crossorigin="anonymous" <?php }?>></script>
 <?php
   }
  } 
 }
}
