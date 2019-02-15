<?php

// No direct access
defined('IN_GS') or die('Cannot load plugin directly.');
$thisfile = basename(__FILE__, '.php');
$secure_website_data_file = GSDATAOTHERPATH . 'SecureWebsiteSettings.xml';
// Register the plugin
register_plugin(
    $thisfile,
    'Protect your website',
    '1.0',
    'ITLOGE',
    'https://itloge.it/',
    'Protect your website',
    'plugins',
    'secure_website_admin_process'
);

// Run this hook everywhere before anything else is loaded in.
add_action('theme-header', 'secure_header');
add_action( 'plugins-sidebar', 'createSideMenu', array( $thisfile, 'Protect Your Website' ) );

$secure_website_settings = secure_website_read_settings();
include __DIR__.'/secure_website/common.php';
include __DIR__.'/secure_website/resource.php';
include __DIR__.'/secure_website/header.php';

function secure_website_admin_process() {
    global $random;
    global $secure_website_data_file;
    global $SITEURL;
    // Check for submitted data
    if( isset( $_POST['submit'] ) ) {
        
        // Save submitted data
        $secure_website_submitted_data['Load_SCRIPT'] = $_POST['Load_SCRIPT'];
        $secure_website_submitted_data['Load_CSS'] = $_POST['Load_CSS'];
        $secure_website_submitted_data['Force_HTTPS'] = $_POST['Force_HTTPS'];
        $secure_website_submitted_data['Subresource_Integrity'] = $_POST['Subresource_Integrity'];
        $secure_website_submitted_data['link_nonce'] = $_POST['link_nonce'];
        $secure_website_submitted_data['script_nonce'] = $_POST['script_nonce'];
        $secure_website_submitted_data['secure_cookie'] = $_POST['secure_cookie'];
        $secure_website_submitted_data['CSS_Resource'] = $_POST['CSS_Resource'];
        $secure_website_submitted_data['JS_Resource'] = $_POST['JS_Resource'];
        $secure_website_submitted_data['Strict_Transport_Security'] = $_POST['Strict_Transport_Security'];
        $secure_website_submitted_data['X_XSS_Protection'] = $_POST['X_XSS_Protection'];
        $secure_website_submitted_data['X_Frame_Options'] = $_POST['X_Frame_Options'];
        $secure_website_submitted_data['X_Content_Type_Options'] = $_POST['X_Content_Type_Options'];
        $secure_website_submitted_data['X_Powered_By'] = $_POST['X_Powered_By'];
        $secure_website_submitted_data['Referrer_Policy'] = $_POST['Referrer_Policy'];
        $secure_website_submitted_data['default_src'] = $_POST['default_src'];
        $secure_website_submitted_data['script_src'] = $_POST['script_src'];
        $secure_website_submitted_data['style_src'] = $_POST['style_src'];
        $secure_website_submitted_data['connect_src'] = $_POST['connect_src'];
        $secure_website_submitted_data['img_src'] = $_POST['img_src'];
        $secure_website_submitted_data['object_src'] = $_POST['object_src'];
        $secure_website_submitted_data['frame_src'] = $_POST['frame_src'];
        $secure_website_submitted_data['frame_ancestors'] = $_POST['frame_ancestors'];
        $secure_website_submitted_data['form_action'] = $_POST['form_action'];
        $secure_website_submitted_data['base_uri'] = $_POST['base_uri'];
        
        $result = secure_website_save_settings( $secure_website_submitted_data );
        
    }
    
    $secure_website_settings = secure_website_read_settings();
    echo '<h3><strong>Protect Your Website</strong></h3>';
    
    if( isset( $result ) ) {
        if( $result == true ) { 
            echo '<p class="updated">Settings saved.</p>';
        } elseif( $result == false ) { 
            echo '<p class="error">Error saving data. Check permissions.</p>';
        }
    }
    ?>
    <form method="post" action="<?php echo $_SERVER ['REQUEST_URI']; ?>">
	<div style="border:1px solid #ccc; padding: 10px; height:auto; align: center;">
	 <h3>Security Settings</h3>
	 <p><label for="Load_CSS">Load CSS</label><input type="checkbox" id="Load_CSS" name="Load_CSS" <?php if ($secure_website_settings['Load_CSS'] == 'Enabled') { echo 'checked="checked"'; }?> value="Enabled"> <span style="font-weight:bold; font-size: 1.1em;">&nbsp; Load all stylesheet files from local theme css folder and external stylesheet resource if defined</span></p>
	 <p><label for="Load_SCRIPT">Load SCRIPT</label><input type="checkbox" id="Load_SCRIPT" name="Load_SCRIPT" <?php if ($secure_website_settings['Load_SCRIPT'] == 'Enabled') { echo 'checked="checked"'; }?> value="Enabled"> <span style="font-weight:bold; font-size: 1.1em;">&nbsp; Load all javascript files from local theme js folder and external javascript resource if defined</span></p>
	<div style="padding: 10px; height:auto; align: center; margin-left:20px; display:block;">
         <div style="width:20%; float:left;"> <label for="Force_HTTPS">&nbsp;&nbsp;Force HTTPS<br /><br /></label>
            <select name="Force_HTTPS" id="Force_HTTPS">
            <option <?php if ($secure_website_settings['Force_HTTPS'] == 'Enabled') { echo 'selected="selected"'; }?> value="Enabled">Enabled</option>
            <option <?php if ($secure_website_settings['Force_HTTPS'] == 'Disabled') { echo 'selected="selected"'; }?> value="Disabled">Disabled</option></select><br />
            <?php if ($secure_website_settings['Force_HTTPS'] == 'Enabled') { echo '<div style="margin:10px; width:70px; height:10px; border-radius:5px;background-color: green;"></div>'; } else { echo '<div style="margin:10px; width:70px; height:10px; border-radius:5px;background-color: orange;"></div>'; } ?></div>
         <div style="width:20%; float:left;">   
        <label for="Subresource_Integrity"> &nbsp;&nbsp;SRI Integrity<br /><br /></label>
            <select name="Subresource_Integrity" id="Subresource_Integrity">
            <option <?php if ($secure_website_settings['Subresource_Integrity'] == 'Enabled') { echo 'selected="selected"'; }?> value="Enabled">Enabled</option>
            <option <?php if ($secure_website_settings['Subresource_Integrity'] == 'Disabled') { echo 'selected="selected"'; }?> value="Disabled">Disabled</option></select><br />
            <?php if ($secure_website_settings['Subresource_Integrity'] == 'Enabled') { echo '<div style="margin:10px; width:70px; height:10px; border-radius:5px;background-color: green;"></div>'; } else { echo '<div style="margin:10px; width:70px; height:10px; border-radius:5px;background-color: orange;"></div>'; } ?></div>
         <div style="width:20%; float:left;">   
        <label for="link_nonce"> &nbsp;&nbsp;CSS nonce<br /><br /></label>
            <select name="link_nonce" id="link_nonce">
            <option <?php if ($secure_website_settings['link_nonce'] == 'Enabled') { echo 'selected="selected"'; }?> value="Enabled">Enabled</option>
            <option <?php if ($secure_website_settings['link_nonce'] == 'Disabled') { echo 'selected="selected"'; }?> value="Disabled">Disabled</option></select><br />
            <?php if ($secure_website_settings['link_nonce'] == 'Enabled') { echo '<div style="margin:10px; width:70px; height:10px; border-radius:5px;background-color: green;"></div>'; } else { echo '<div style="margin:10px; width:70px; height:10px; border-radius:5px;background-color: orange;"></div>'; } ?></div>
         <div style="width:20%; float:left;">   
        <label for="script_nonce">&nbsp;SCRIPT nonce<br /><br /></label>
            <select name="script_nonce" id="script_nonce">
            <option <?php if ($secure_website_settings['script_nonce'] == 'Enabled') { echo 'selected="selected"'; }?> value="Enabled">Enabled</option>
            <option <?php if ($secure_website_settings['script_nonce'] == 'Disabled') { echo 'selected="selected"'; }?> value="Disabled">Disabled</option></select><br />
            <?php if ($secure_website_settings['script_nonce'] == 'Enabled') { echo '<div style="margin:10px; width:70px; height:10px; border-radius:5px;background-color: green;"></div>'; } else { echo '<div style="margin:10px; width:70px; height:10px; border-radius:5px;background-color: orange;"></div>'; } ?></div>
         <div style="width:20%; float:left;">   
        <label for="secure_cookie">Secure cookie<br /><br /></label>
            <select name="secure_cookie" id="secure_cookie">
            <option <?php if ($secure_website_settings['secure_cookie'] == 'Enabled') { echo 'selected="selected"'; }?> value="Enabled">Enabled</option>
            <option <?php if ($secure_website_settings['secure_cookie'] == 'Disabled') { echo 'selected="selected"'; }?> value="Disabled">Disabled</option></select><br />
            <?php if ($secure_website_settings['secure_cookie'] == 'Enabled') { echo '<div style="margin:10px; width:70px; height:10px; border-radius:5px;background-color: green;"></div>'; } else { echo '<div style="margin:10px; width:70px; height:10px; border-radius:5px;background-color: orange;"></div>'; } ?></div>           
          <div style="clear:both;"></div>
          </div>
          </div>
          <p></p>
        <div style="border:1px solid #ccc; padding: 20px;">
        <h3>External CSS and JavaScript Resource</h3>
        <p><label for="CSS_Resource">External CSS Resource (Enable SRI to calculate sha-384 hash and add integrity attribute)<br /></label>
            <textarea name="CSS_Resource" id="CSS_Resource"  style="width:98%; height:80px; resize:none;"><?php echo $secure_website_settings['CSS_Resource']; ?></textarea></p>
        
        <p><label for="JS_Resource">External JavaScript Resource (Enable SRI to calculate sha-384 hash and add integrity attribute)<br /></label>
            <textarea name="JS_Resource" id="JS_Resource"  style="width:98%; height:80px; resize:none;"><?php echo $secure_website_settings['JS_Resource']; ?></textarea></p>
        </div>
        <p></p>
	<div style="border:1px solid #ccc; padding: 20px;">
        <h3>Header Security</h3>
        <p><label for="Strict_Transport_Security">Strict Transport Security<br /></label>
            <input name="Strict_Transport_Security" id="Strict_Transport_Security" class="text" value="<?php echo $secure_website_settings['Strict_Transport_Security']; ?>" style="width: 98%;" /></p>
        
        <p><label for="X_XSS_Protection">X XSS Protection<br /></label>
            <input name="X_XSS_Protection" id="X_XSS_Protection" class="text" value="<?php echo $secure_website_settings['X_XSS_Protection']; ?>" style="width: 98%;" /></p>
            
        <p><label for="X_Frame_Options">X Frame Options<br /></label>
            <input name="X_Frame_Options" id="X_Frame_Options" class="text" value="<?php echo $secure_website_settings['X_Frame_Options']; ?>" style="width: 98%;" /></p>
            
        <p><label for="X_Content_Type_Options">X Content Type Options<br /></label>
            <input name="X_Content_Type_Options" id="X_Content_Type_Options" class="text" value="<?php echo $secure_website_settings['X_Content_Type_Options']; ?>" style="width: 98%;" /></p>
            
        <p><label for="X_Powered_By">X Powered By<br /></label>
            <input name="X_Powered_By" id="X_Powered_By" class="text" value="<?php echo $secure_website_settings['X_Powered_By']; ?>" style="width: 98%;" /></p>
            
        <p><label for="Referrer_Policy">Referrer Policy<br /></label>
            <input name="Referrer_Policy" id="Referrer_Policy" class="text" value="<?php echo $secure_website_settings['Referrer_Policy']; ?>" style="width: 98%;" /></p>
        <div style="border:1px solid #ccc; padding: 20px;">  
            <h3>Content Security Policy</h3>
        <p><label for="default_src">default-src<br /></label>
            <input name="default_src" id="default_src" class="text" value="<?php echo $secure_website_settings['default_src']; ?>" style="width: 98%;" /></p>
        <p><label for="script_src">script-src (to enable nonce value add 'nonce')<br /></label>
            <input name="script_src" id="script_src" class="text" value="<?php echo $secure_website_settings['script_src']; ?>" style="width: 98%;" /></p>
        <p><label for="style_src">style-src (to enable nonce value add 'nonce')<br /></label>
            <input name="style_src" id="style_src" class="text" value="<?php echo $secure_website_settings['style_src']; ?>" style="width: 98%;" /></p>
        <p><label for="connect_src">connect-src<br /></label>
            <input name="connect_src" id="connect_src" class="text" value="<?php echo $secure_website_settings['connect_src']; ?>" style="width: 98%;" /></p>
        <p><label for="img_src">img-src<br /></label>
            <input name="img_src" id="img_src" class="text" value="<?php echo $secure_website_settings['img_src']; ?>" style="width: 98%;" /></p>
        <p><label for="object_src">object-src<br /></label>
            <input name="object_src" id="object_src" class="text" value="<?php echo $secure_website_settings['object_src']; ?>" style="width: 98%;" /></p>
        <p><label for="frame_src">frame-src<br /></label>
            <input name="frame_src" id="frame_src" class="text" value="<?php echo $secure_website_settings['frame_src']; ?>" style="width: 98%;" /></p>
        <p><label for="frame_ancestors">frame-ancestors<br /></label>
            <input name="frame_ancestors" id="frame_ancestors" class="text" value="<?php echo $secure_website_settings['frame_ancestors']; ?>" style="width: 98%;" /></p>
        <p><label for="form_action">form-action<br /></label>
            <input name="form_action" id="form_action" class="text" value="<?php echo $secure_website_settings['form_action']; ?>" style="width: 98%;" /></p>
        <p><label for="base_uri">base-uri<br /></label>
            <input name="base_uri" id="form_action" class="text" value="<?php echo $secure_website_settings['base_uri']; ?>" style="width: 98%;" /></p>
            
            </div>
        </div>
         <p></p>
        <p><input type="submit" id="submit" class="submit" value="<?php i18n('BTN_SAVESETTINGS'); ?>" name="submit" /></p>
        
    </form>
    <p>Analize Your Site <a href="https://observatory.mozilla.org/analyze.html" target="_blank">HTML OBSERVATORY</a><br />Check header <a href="https://quixapp.com/headers/?r=<?php echo $SITEURL; ?>">QIX Check Header</a></p>
    <?php
}

function secure_website_read_settings() {
    
    global $secure_website_data_file;
    
    if( file_exists( $secure_website_data_file ) ) {
        
        $data = getXML( $secure_website_data_file );
        $secure_website_settings['Load_SCRIPT'] = $data->Load_SCRIPT;
        $secure_website_settings['Load_CSS'] = $data->Load_CSS;
        $secure_website_settings['Force_HTTPS'] = $data->Force_HTTPS;
        $secure_website_settings['Subresource_Integrity'] = $data->Subresource_Integrity;
        $secure_website_settings['link_nonce'] = $data->link_nonce;
        $secure_website_settings['script_nonce'] = $data->script_nonce;
        $secure_website_settings['secure_cookie'] = $data->secure_cookie;
        $secure_website_settings['CSS_Resource'] = $data->CSS_Resource;
        $secure_website_settings['JS_Resource'] = $data->JS_Resource;
        $secure_website_settings['Strict_Transport_Security'] = $data->Strict_Transport_Security;
        $secure_website_settings['X_XSS_Protection'] = $data->X_XSS_Protection;
        $secure_website_settings['X_Frame_Options'] = $data->X_Frame_Options;
        $secure_website_settings['X_Content_Type_Options'] = $data->X_Content_Type_Options;
        $secure_website_settings['X_Powered_By'] = $data->X_Powered_By;
        $secure_website_settings['Referrer_Policy'] = $data->Referrer_Policy;
        $secure_website_settings['default_src'] = $data->default_src;
        $secure_website_settings['script_src'] = $data->script_src;
        $secure_website_settings['style_src'] = $data->style_src;
        $secure_website_settings['connect_src'] = $data->connect_src;
        $secure_website_settings['img_src'] = $data->img_src;
        $secure_website_settings['object_src'] = $data->object_src;
        $secure_website_settings['frame_src'] = $data->frame_src;
        $secure_website_settings['frame_ancestors'] = $data->frame_ancestors;
        $secure_website_settings['form_action'] = $data->form_action;
        $secure_website_settings['base_uri'] = $data->base_uri;
        
    } else {

        $secure_website_settings['Load_SCRIPT'] = null;
        $secure_website_settings['Load_CSS'] = null;
        $secure_website_settings['Force_HTTPS'] = null;
        $secure_website_settings['Subresource_Integrity'] = null;
	$secure_website_settings['link_nonce'] = null;
	$secure_website_settings['script_nonce'] = null;
	$secure_website_settings['secure_cookie'] = null;
	$secure_website_settings['CSS_Resource'] = null;
	$secure_website_settings['JS_Resource'] = null;
        $secure_website_settings['Strict_Transport_Security'] = null;
        $secure_website_settings['X_XSS_Protection'] = null;
        $secure_website_settings['X_Frame_Options'] = null;
        $secure_website_settings['X_Content_Type_Options'] = null;
        $secure_website_settings['X_Powered_By'] = null;
        $secure_website_settings['Referrer_Policy'] = null;
        $secure_website_settings['default_src'] = null;
        $secure_website_settings['script_src'] = null;
        $secure_website_settings['style_src'] = null;
        $secure_website_settings['connect_src'] = null;
        $secure_website_settings['img_src'] = null;
        $secure_website_settings['object_src'] = null;
        $secure_website_settings['frame_src'] = null;
        $secure_website_settings['frame_ancestors'] = null;
        $secure_website_settings['form_action'] = null;
        $secure_website_settings['base_uri'] = null;
        
        secure_website_save_settings( $secure_website_settings );
        
    }
    
    $secure_website_settings['site_root'] = '/';
    
    return $secure_website_settings;
    
}


function secure_website_save_settings( $settings ) {
    
    global $secure_website_data_file;
    
    $xml = @new simpleXMLElement( '<secure_website_settings></secure_website_settings>' );
        
    $xml->addChild( 'Load_SCRIPT', $settings['Load_SCRIPT'] );
    $xml->addChild( 'Load_CSS', $settings['Load_CSS'] );
    $xml->addChild( 'Force_HTTPS', $settings['Force_HTTPS'] );
    $xml->addChild( 'Subresource_Integrity', $settings['Subresource_Integrity'] );
    $xml->addChild( 'link_nonce', $settings['link_nonce'] );
    $xml->addChild( 'script_nonce', $settings['script_nonce'] );
    $xml->addChild( 'secure_cookie', $settings['secure_cookie'] );
    $xml->addChild( 'CSS_Resource', $settings['CSS_Resource'] );
    $xml->addChild( 'JS_Resource', $settings['JS_Resource'] );
    $xml->addChild( 'Strict_Transport_Security', $settings['Strict_Transport_Security'] );
    $xml->addChild( 'X_XSS_Protection', $settings['X_XSS_Protection'] );
    $xml->addChild( 'X_Frame_Options', $settings['X_Frame_Options'] );
    $xml->addChild( 'X_Content_Type_Options', $settings['X_Content_Type_Options'] );
    $xml->addChild( 'X_Powered_By', $settings['X_Powered_By'] );
    $xml->addChild( 'Referrer_Policy', $settings['Referrer_Policy'] );
    $xml->addChild( 'default_src', $settings['default_src'] );
    $xml->addChild( 'script_src', $settings['script_src'] );
    $xml->addChild( 'style_src', $settings['style_src'] );
    $xml->addChild( 'connect_src', $settings['connect_src'] );
    $xml->addChild( 'img_src', $settings['img_src'] );
    $xml->addChild( 'object_src', $settings['object_src'] );
    $xml->addChild( 'frame_src', $settings['frame_src'] );
    $xml->addChild( 'frame_ancestors', $settings['frame_ancestors'] );
    $xml->addChild( 'form_action', $settings['form_action'] );
    $xml->addChild( 'base_uri', $settings['base_uri'] );
    
    return $xml->asXML( $secure_website_data_file );
    
}

?>
