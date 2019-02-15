# secure-website
content security plugin for GetSimple CMS


this plugin help to configure:


Security header settings

-Strict_Transport_Security

-X_XSS_Protection

-X_Frame_Options

-X_Content_Type_Options

-X_Powered_By

-Referrer_Policy

-Content-Security-Policy (default_src, script_src, style_src, connect_src, img_src, object_src, frame_src, frame_ancestors, form_action, base_uri)


If enabled load all css and/or js files from template css/js directory and add if enabled random code as 'nonce'


Load resources css or javascript from external url and add if enabled random code as 'nonce', if enabled SRI integrity calculate sha-384 hash and add integrity attribute


if Secure cookie enabled add cookie flag httponly and secure


if Force HTTPS enabled force https for all site url
