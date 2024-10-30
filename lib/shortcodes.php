<?php

/**
 * @author Tony Asch
 * @copyright 2010
 * @description Use WordPress Shortcode API for more features
 * @Docs http://codex.wordpress.org/Shortcode_API
 * Revised for CoolEye 1.1.3
 * This code translates the shortcode syntax into HTML in realtime as the page or post is displayed to the user.
 */
class coolEye_shortcodes {

    // register the new shortcodes
    function coolEye_shortcodes() {
        add_shortcode('coolEye', array(&$this, 'show_coolEye'));
    }

    function show_coolEye($atts) {

        global $coolEye;
        $out = '';
        $wmode = $wmode = '<param value="opaque" name="wmode"/>';
        $alpha = '';
        $wmodeem = '';
        extract(shortcode_atts(array(
                    'how' => get_option('coolEye_how'),
                    'search' => false,
                    'width' => get_option('coolEye_width'),
                    'height' => get_option('coolEye_height'),
                    'source' => get_option('coolEye_mode'),
                    'rows' => get_option('coolEye_rows'),
                    'theme' => get_option('coolEye_theme'),
                    'rgb' => get_option('coolEye_rgb'),
                    'url' => get_option('coolEye_url'),
                    'tilt' => get_option('coolEye_tilt'),
                    'puser' => get_option('coolEye_puser'),
                    'chrome' => get_option('coolEye_chrome'),
                    'brand' => get_option('coolEye_brand'),
                    'toolbar' => get_option('coolEye_toolbar'),
                    'opacity' => get_option('coolEye_opacity'),
                    'exactfit' => get_option('coolEye_exactfit'),
                    'featured' => '',
                    'featuredalbum' => '',
					'ythiresthumbs' => ''
                        ), $atts));

        // How the CoolIris looks
        if ($theme == 'customrgb')
            $theme = '&#038;backgroundcolor=#23' . $rgb;
        else {
            if ($theme == 'customurl')
                $theme = '&#038;backgroundimage=' . $url;
            else
                $theme = '&#038;style=' . $theme;
        }
        if ($opacity < 1.0)  {
            $wmode = '<param value="transparent" name="wmode"/>';
            $wmodeem = ' wmode="transparent"';
            $alpha = '&backgroundAlpha=' . $opacity;
        }
        $chromeit = '';
        if ($chrome == 'show')
            $chromeit = '&#038;showchrome=true';
        if ($chrome == 'hide')
            $chromeit = '&#038;showchrome=false';
        if ($brand == 'show')
            $chromeit = $chromeit . '&showCoolirisBranding=true';
        else
            $chromeit = $chromeit . '&showCoolirisBranding=false';
        if ($toolbar == 'show')
            $chromeit = $chromeit . '&showtoolbar=true';
        else
            $chromeit = $chromeit . '&showtoolbar=false';
        if ($exactfit == 'yes')
            $chromeit = $chromeit . '&contentScale=exactFit';

        $chromeit = $chromeit . $alpha;
		if (($source == "youtube") && ($ythiresthumbs == true))  {
			$chromeit .= '&amp;highres=true';
		}

        if ($tilt != '')
            $theme = $theme . '&tilt=' . $tilt;

        if ($source == 'mediarss') {
            $out = '<object id="o" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="' . $width . '" height="' . $height . '">  <param name="movie" value="http://apps.cooliris.com/embed/cooliris.swf" /> <param name="allowFullScreen" value="true" /> <param name="allowScriptAccess" value="always" />' . $wmode . '<param name="flashvars" value="feed=' . $search . '&numRows=' . $rows . $theme . $chromeit . '" /> <embed type="application/x-shockwave-flash" src="http://apps.cooliris.com/embed/cooliris.swf" flashvars="feed=' . $search . '&numRows=' . $rows . $theme . $chromeit . '"' . $wmodeem . ' width="' . $width . '" height="' . $height . '" allowFullScreen="true" allowScriptAccess="always"> </embed> </object>';
            return $out;
        }

        // Search
        if ($how == 'search') {
            if ($source == "flickr")
                $out = '<object id="o" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="' . $width . '" height="' . $height . '">  <param name="movie" value="http://apps.cooliris.com/embed/cooliris.swf" /> <param name="allowFullScreen" value="true" /> <param name="allowScriptAccess" value="always" />' . $wmode . '<param name="flashvars" value="feed=api://www.flickr.com/?search=' . $search . '&numRows=' . $rows . $theme . $chromeit . '" /> <embed type="application/x-shockwave-flash" src="http://apps.cooliris.com/embed/cooliris.swf" flashvars="feed=api://www.flickr.com/?search=' . $search . '&numRows=' . $rows . $theme . $chromeit . '"' . $wmodeem . ' width="' . $width . '" height="' . $height . '" allowFullScreen="true" allowScriptAccess="always"> </embed> </object>';

            if ($source == "youtube")
                $out = '<object id="o" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="' . $width . '" height="' . $height . '"' . '>  <param name="movie" value="http://apps.cooliris.com/embed/cooliris.swf" /> <param name="allowFullScreen" value="true" /> <param name="allowScriptAccess" value="always" />' . $wmode . '<param name="flashvars" value="feed=http://gdata.youtube.com/feeds/api/videos?q=' . $search . '&numRows=' . $rows . $chromeit . '" /> <embed type="application/x-shockwave-flash" src="http://apps.cooliris.com/embed/cooliris.swf" flashvars="feed=http://gdata.youtube.com/feeds/api/videos?q=' . $search . '&numRows=' . $rows . $theme . $chromeit . '"' . $wmodeem . ' width="' . $width . '" height="' . $height . '" allowFullScreen="true" allowScriptAccess="always"> </embed> </object>';

            if ($source == "picasa")
                $out = '<object id="o" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="' . $width . '" height="' . $height . '">  <param name="movie" value="http://apps.cooliris.com/embed/cooliris.swf" /> <param name="allowFullScreen" value="true" /> <param name="allowScriptAccess" value="always" />' . $wmode . '<param name="flashvars" value="feed=api://picasaweb.google.com/?search=' . $search . '&numRows=' . $rows . $theme . $chromeit . '" /> <embed type="application/x-shockwave-flash" src="http://apps.cooliris.com/embed/cooliris.swf" flashvars="feed=api://picasaweb.google.com/?search=' . $search . '&numRows=' . $rows . $theme . $chromeit . '"' . $wmodeem . ' width="' . $width . '" height="' . $height . '" allowFullScreen="true" allowScriptAccess="always"> </embed> </object>';

            return $out;
        }

        //
        // YouTube supports "how" = user, channel, subscriptions, and favorites - where "search" = username
        // YouTube also supports "how" = playlist - where "search" = playlist number
        //
        if ($source == 'youtube') {
            $userphrase = 'feed=api%3A%2F%2Fwww.youtube.com%2F%3Fuser%3D' . $search;
            if ($how == 'channel') {
                $how = 'user';
                $userphrase = 'feed=http%3A%2F%2Fgdata.youtube.com%2Ffeeds%2Fapi%2Fusers%2F' . $search . '%2Fuploads%3Fv%3D2';
            }
            if ($how == 'favorites') {
                $how = 'user';
                $userphrase = 'feed=api%3A%2F%2Fwww.youtube.com%2F%3Fuser%3D' . $search . '%26type%3Dfavorites';
            }
            if ($how == 'subscriptions') {
                $how = 'user';
                $userphrase = 'feed=api%3A%2F%2Fwww.youtube.com%2F%3Fuser%3D' . $search . '%26type%3Dsubscriptions';
            }
            if ($how == 'playlist') {
                $how = 'user';
                $userphrase = 'feed=http%3A%2F%2Fgdata.youtube.com%2Ffeeds%2Fapi%2Fplaylists%2F' . $search . '%3Fv%3D2';
            }
        }

        // User
        if ($how == 'user') {
            if ($source == "flickr")
                $out = '<object id="o" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="' . $width . '" height="' . $height . '">  <param name="movie" value="http://apps.cooliris.com/embed/cooliris.swf" /> <param name="allowFullScreen" value="true" /> <param name="allowScriptAccess" value="always" />' . $wmode . '<param name="flashvars" value="feed=api://www.flickr.com/?user=' . $search . '&numRows=' . $rows . $theme . $chromeit . '" /> <embed type="application/x-shockwave-flash" src="http://apps.cooliris.com/embed/cooliris.swf" flashvars="feed=api://www.flickr.com/?user=' . $search . '&numRows=' . $rows . $theme . $chromeit . '"' . $wmodeem . ' width="' . $width . '" height="' . $height . '" allowFullScreen="true" allowScriptAccess="always"> </embed> </object>';

            if ($source == "youtube") {
                $out = '<object id="o" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="' .
                        $width . '" height="' . $height . '">
                    <param name="movie" value="http://apps.cooliris.com/embed/cooliris.swf" />
                    <param name="allowFullScreen" value="true" />
                    <param name="allowScriptAccess" value="always" />
                    ' . $wmode . '
                    <param name="bgColor" value="#121212" />
                    <param name="flashvars" value="' . $userphrase .
                        $chromeit . '&#038;numrows=' . $rows . '" />
                    <embed id="o" type="application/x-shockwave-flash" src="http://apps.cooliris.com/embed/cooliris.swf"
                    width="' . $width . '" height="' . $height . '"' . $wmodeem . ' allowFullScreen="true" allowScriptAccess="always" bgColor="#121212"
                    flashvars = "' . $userphrase . $theme . $chromeit . '&#038;numrows=' . $rows . '"
                    > </embed> </object>';
            }
            if ($source == "picasa")
                $out = '<object id="o" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="' . $width . '" height="' . $height . '">  <param name="movie" value="http://apps.cooliris.com/embed/cooliris.swf" /> <param name="allowFullScreen" value="true" /> <param name="allowScriptAccess" value="always" />' . $wmode . '<param name="flashvars" value="feed=api://picasaweb.google.com/?user=' . $search . '&numRows=' . $rows . $theme . $chromeit . '" /> <embed type="application/x-shockwave-flash" src="http://apps.cooliris.com/embed/cooliris.swf" flashvars="feed=api://picasaweb.google.com/?user=' . $search . '&numRows=' . $rows . $theme . $chromeit . '"' . $wmodeem . ' width="' . $width . '" height="' . $height . '" allowFullScreen="true" allowScriptAccess="always"> </embed> </object>';

            return $out;
        }

        // Album
        if ($how == 'album') {
            if ($source == "flickr")
                $out = '<object id="o" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="' . $width . '" height="' . $height . '">  <param name="movie" value="http://apps.cooliris.com/embed/cooliris.swf" /> <param name="allowFullScreen" value="true" /> <param name="allowScriptAccess" value="always" />' . $wmode . '<param name="flashvars" value="feed=api://www.flickr.com/?album=' . $search . '&numRows=' . $rows . $theme . $chromeit . '" /> <embed type="application/x-shockwave-flash" src="http://apps.cooliris.com/embed/cooliris.swf" flashvars="feed=api://www.flickr.com/?album=' . $search . '&numRows=' . $rows . $theme . $chromeit . '"' . $wmodeem . ' width="' . $width . '" height="' . $height . '" allowFullScreen="true" allowScriptAccess="always"> </embed> </object>';

            if ($source == "picasa")  {
                if (($featured != '') && (featuredalbum != ''))  {
                    $chromeit .= '&itemGUID=http://photos.googleapis.com/data/entry/api/user/' . $puser . '/albumid/' . $featuredalbum . '/photoid/' . $featured;
                }
                $out = '<object id="o" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="' . $width . '" height="' . $height . '">  <param name="movie" value="http://apps.cooliris.com/embed/cooliris.swf" /> <param name="allowFullScreen" value="true" /> <param name="allowScriptAccess" value="always" />' . $wmode . '<param name="flashvars" value="feed=api%3A%2F%2Fpicasaweb.google.com%2F%3Fuser%3D' . $puser . '%26album%3D' . $search . '&numRows=' . $rows . $theme . $chromeit . '" /> <embed type="application/x-shockwave-flash" src="http://apps.cooliris.com/embed/cooliris.swf" flashvars="feed=api%3A%2F%2Fpicasaweb.google.com%2F%3Fuser%3D' . $puser . '%26album%3D' . $search . '&numRows=' . $rows . $theme . $chromeit . '"' . $wmodeem . ' width="' . $width . '" height="' . $height . '" allowFullScreen="true" allowScriptAccess="always"> </embed> </object>';
            }
            return $out;
        }

        // Group
        if ($how == 'group') {
            if ($source == "flickr")
                $out = '<object id="o" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="' . $width . '" height="' . $height . '">  <param name="movie" value="http://apps.cooliris.com/embed/cooliris.swf" /> <param name="allowFullScreen" value="true" /> <param name="allowScriptAccess" value="always" />' . $wmode . '<param name="flashvars" value="feed=api://www.flickr.com/?group=' . $search . '&numRows=' . $rows . $theme . $chromeit . '" /> <embed type="application/x-shockwave-flash" src="http://apps.cooliris.com/embed/cooliris.swf" flashvars="feed=api://www.flickr.com/?group=' . $search . '&numRows=' . $rows . $theme . $chromeit . '"' . $wmodeem . ' width="' . $width . '" height="' . $height . '" allowFullScreen="true" allowScriptAccess="always"> </embed> </object>';

            return $out;
        }
        return $out;
    }

}

// let's use it
$coolEyeShortcodes = new coolEye_Shortcodes;
?>