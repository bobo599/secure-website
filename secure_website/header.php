<?php

if ($secure_website_settings['secure_cookie'] == 'Enabled') {
add_action('index-pretemplate', 'secure_cookies');
function secure_cookies()
{
    ini_set('session.cookie_secure', '1');
    ini_set('session.cookie_httponly', '1');
    ini_set('session.use_only_cookies', '1');
  }
}


if ($secure_website_settings['Force_HTTPS'] == 'Enabled') {
add_action('common', 'force_https');
function force_https()
{
    if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off") {
        $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        header('HTTP/1.1 301 Moved Permanently');
        header('Location: ' . $redirect);
    }
  }
}

function secure_header()
{
	global $random;
	global $secure_website_settings;
        $r1 = $secure_website_settings['Strict_Transport_Security'];
        $r2 = $secure_website_settings['X_XSS_Protection'];
        $r3 = $secure_website_settings['X_Frame_Options'];
        $r4 = $secure_website_settings['X_Content_Type_Options'];
        $r5 = $secure_website_settings['X_Powered_By'];
        $r6 = $secure_website_settings['Referrer_Policy'];
        
        //Content Security Policy start
        $csp1 = $secure_website_settings['default_src'];
       if ($csp1 != '') {  $v1 = "default-src $csp1; "; }
        $csp2 = $secure_website_settings['script_src'];
       if ($csp2 != '') {  $v2 = "script-src $csp2; "; }
        $csp3 = $secure_website_settings['style_src'];
       if ($csp3 != '') {  $v3 = "style-src $csp3; "; }
        $csp4 = $secure_website_settings['connect_src'];
       if ($csp4 != '') {  $v4 = "connect-src $csp4; "; }  
        $csp5 = $secure_website_settings['img_src'];
       if ($csp5 != '') {  $v5 = "img-src $csp5; "; }
        $csp6 = $secure_website_settings['object_src'];
       if ($csp6 != '') {  $v6 = "object-src $csp6; "; }
        $csp7 = $secure_website_settings['frame_src'];
       if ($csp7 != '') {  $v7 = "frame-src $csp7; "; }
        $csp8 = $secure_website_settings['frame_ancestors'];
       if ($csp8 != '') {  $v8 = "frame-ancestors $csp8; "; }
        $csp9 = $secure_website_settings['form_action'];
       if ($csp9 != '') {  $v9 = "form-action $csp9; "; }
        $csp0 = $secure_website_settings['base_uri'];
       if ($csp0 != '') {  $v0 = "base-uri $csp0; "; }
        
        $r7i = $v1.$v2.$v3.$v0.$v4.$v9.$v5.$v6.$v7.$v8;
        $r7 = str_replace("nonce","nonce-$random","$r7i");
        //Content Security Policy end
        
	//$r7 = $secure_website_settings['Content_Security_Policy'];


  if ($r1 != '') { header("Strict-Transport-Security: $r1"); }
  if ($r2 != '') { header("X-XSS-Protection: $r2"); }
  if ($r3 != '') { header("X-Frame-Options: $r3"); }
  if ($r4 != '') { header("X-Content-Type-Options: $r4"); }
  if ($r5 != '') { header("X-Powered-By: $r5"); }
  if ($r6 != '') { header("Referrer-Policy: $r6"); }
  if ($r7 != '') { header("Content-Security-Policy: $r7"); }
}

//function security_headers()
//{
//	global $random;
//	$random = randString();
//	header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
//	header("X-XSS-Protection: 1; mode=block");
//	header("X-Frame-Options: SAMEORIGIN");
//	header("X-Content-Type-Options: nosniff");
//	header("X-Powered-By: NULL");
//	header("Referrer-Policy: strict-origin");
//	header("Content-Security-Policy: default-src 'none'; script-src 'nonce-$random' 'strict-dynamic'; style-src 'nonce-$random'; base-uri 'self'; connect-src 'self' https:; form-action 'self'; img-src 'self' https:; object-src //'none'; frame-src https://www.google.com/maps/d/embed; frame-ancestors https://www.google.com/maps/d/embed");
//}
//