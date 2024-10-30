<?php
/*
  +----------------------------------------------------------------+
  +	tdPix-tinymce V1.60 CoolIris Embed Button in Wordpress Editor
  +	by Tony Asch
  +     required for CoolEye and WordPress 2.6+
  +     revised for CoolEye 1.1.3
  +----------------------------------------------------------------+
 */

// look up for the path
require_once( dirname(dirname(__FILE__)) . '/coolEye-config.php');

global $wpdb;

// check for rights
if (!is_user_logged_in() || !current_user_can('edit_posts'))
    wp_die(__("You are not allowed to be here"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>CoolEye - CoolIris Embed</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
        <script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
        <script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
        <script language="javascript" type="text/javascript">
            function init() {
                tinyMCEPopup.resizeToInnerSize();
            }
	
            function insertcoolEyeLink() {
		
                var tagtext = '';
                var coolEyeWall;
                var tempWall;
                var theMode = 'youtube';
				var hiRes = '';
				var featured = '';

                tempWall = document.getElementById('coolEyeRss_panel');
                if (tempWall.className.indexOf('current') != -1)  {
                    theMode = 'mediarss';
                    coolEyeWall = document.getElementById('coolEyeRss_panel');
                }
                tempWall = document.getElementById('coolEyeYT_panel');
                if (tempWall.className.indexOf('current') != -1)  {
                    theMode = 'youtube';
                    coolEyeWall = document.getElementById('coolEyeYT_panel');
                }
                tempWall = document.getElementById('coolEyePicasa_panel');
                if (tempWall.className.indexOf('current') != -1)  {
                    theMode = 'picasa';
                    coolEyeWall = document.getElementById('coolEyePicasa_panel');
                }

                tempWall = document.getElementById('coolEyeFlickr_panel');
                if (tempWall.className.indexOf('current') != -1)  {
                    theMode = 'flickr';
                    coolEyeWall = document.getElementById('coolEyeFlickr_panel');
                }

                // who is active ?
                if (coolEyeWall.className.indexOf('current') != -1) {
                    var coolEyeHowid = document.getElementById('coolEyeHowtag').value;
                    var coolEyePicasaHowid = document.getElementById('coolEyePicasaHowtag').value;
                    var coolEyeFlickrHowid = document.getElementById('coolEyeFlickrHowtag').value;
                    var coolEyeSearchid = document.getElementById('coolEyeSearchtag').value;
                    var coolEyePicasaSearchid = document.getElementById('coolEyePicasaSearchtag').value;
                    var coolEyeFlickrSearchid = document.getElementById('coolEyeFlickrSearchtag').value;
                    var coolEyePicasaOwnerid = document.getElementById('coolEyePicasaOwnertag').value;
                    var coolEyeRssSearchid = document.getElementById('coolEyeRssSearchtag').value;
                    var coolEyeWidthid = document.getElementById('coolEyeWidtag').value;
                    var coolEyeHeightid = document.getElementById('coolEyeHitetag').value;
                    var coolEyeRowsid = document.getElementById('coolEyeRowstag').value;
                    var coolEyeThemeid = document.getElementById('coolEyeThemetag').value;
                    var coolEyeRGBid = document.getElementById('coolEyeRGBtag').value;
                    var coolEyeURLid = document.getElementById('coolEyeURLtag').value;
                    var coolEyeOpacityid = document.getElementById('coolEyeOpacitytag').value;
                    var coolEyeChromeid = document.getElementById('coolEyeChrometag').value;
                    var coolEyeTiltid = document.getElementById('coolEyeTilttag').value;
                    var coolEyeBrandid = document.getElementById('coolEyeBrandtag').value;
                    var coolEyeToolbarid = document.getElementById('coolEyeToolbartag').value;
                    var coolEyeExactfitid = document.getElementById('coolEyeExactfittag').value;
                    var coolEyeYtHrid = document.getElementById('coolEyeYtHrtag').value;
                    var coolEyeFeaturedAlbumid = document.getElementById('coolEyeFeaturedAlbumtag').value;
                    var coolEyeFeaturedid = document.getElementById('coolEyeFeaturedtag').value; 

                    if (theMode == 'mediarss')  {
                        coolEyeHowid ='';
                        searchPhrase = coolEyeRssSearchid;
                    }

                    if (theMode == 'youtube')  {
                        searchPhrase = coolEyeSearchid;
                        if (coolEyeHowid != '' )
                            coolEyeHowid = " how=" + coolEyeHowid;
                    }
                    
                    if (theMode == 'picasa')  {
                        searchPhrase = coolEyePicasaSearchid;
                        if (coolEyePicasaHowid != '' )  {
                            coolEyeHowid = " how=" + coolEyePicasaHowid;
                            if (coolEyePicasaOwnerid != '' )
                                coolEyeHowid = coolEyeHowid + " puser=" + coolEyePicasaOwnerid;
                        }
                    }
					if ((coolEyeFeaturedAlbumid != '') && (coolEyeFeaturedid != '') && (theMode == 'picasa'))  {
						featured = " featured=" + coolEyeFeaturedid + " featuredalbum=" + coolEyeFeaturedAlbumid;
					}


                    if (theMode == 'flickr')  {
                        searchPhrase = coolEyeFlickrSearchid;
                        if (coolEyeFlickrHowid != '' )
                            coolEyeHowid = " how=" + coolEyeFlickrHowid;
                    }

                    if (coolEyeWidthid != '' )
                        coolEyeWidthid = " width=" + coolEyeWidthid;

                    if (coolEyeHeightid != '' )
                        coolEyeHeightid = " height=" + coolEyeHeightid;
			
                    coolEyeModeid = " source=" + theMode;

                    if (coolEyeRowsid != '' )
                        coolEyeRowsid = " rows=" + coolEyeRowsid;

                    if (coolEyeThemeid != '' )
                        coolEyeThemeid = " theme=" + coolEyeThemeid;

                    if (coolEyeRGBid != '' )
                        coolEyeRGBid = " rgb=" + coolEyeRGBid;

                    if (coolEyeURLid != '' )
                        coolEyeURLid = " url=" + coolEyeURLid;

                    if (coolEyeOpacityid != '' )
                        coolEyeOpacityid = " opacity=" + coolEyeOpacityid;

                    if (coolEyeChromeid != '' )
                        coolEyeChromeid = " chrome=" + coolEyeChromeid;

                    if (coolEyeTiltid != '' )
                        coolEyeTiltid = " tilt=" + coolEyeTiltid;

                    if (coolEyeBrandid != '' )
                        coolEyeBrandid = " brand=" + coolEyeBrandid;

                    if (coolEyeToolbarid != '' )
                        coolEyeToolbarid = " toolbar=" + coolEyeToolbarid;

                    if (coolEyeExactfitid != '' )
                        coolEyeExactfitid = " exactfit=" + coolEyeExactfitid;
					
					if ((coolEyeYtHrid == 'hires' ) && (theMode == 'youtube'))  {
						hiRes = " ythiresthumbs=true";
					}
					
                    if (searchPhrase != '' )
                        tagtext = "[coolEye search=" + searchPhrase + coolEyeHowid + coolEyeWidthid + coolEyeHeightid + coolEyeModeid + coolEyeRowsid + coolEyeThemeid + coolEyeRGBid + coolEyeURLid + coolEyeOpacityid + coolEyeChromeid + coolEyeTiltid + coolEyeBrandid + coolEyeToolbarid + coolEyeExactfitid + hiRes + featured + "]";
                    else
                        tinyMCEPopup.close();
                }

                if(window.tinyMCE) {
                    window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, tagtext);
                    //Peforms a clean up of the current editor HTML.
                    //tinyMCEPopup.editor.execCommand('mceCleanup');
                    //Repaints the editor. Sometimes the browser has graphic glitches.
                    tinyMCEPopup.editor.execCommand('mceRepaint');
                    tinyMCEPopup.close();
                }

                return;
            }

        </script>
        <base target="_self" />
    </head>

    <body id="link" onload="tinyMCEPopup.executeOnLoad('init();');document.body.style.display='';document.getElementById('coolEyeSearchtag').focus();" style="display: none">
        <!-- <form onsubmit="insertLink();return false;" action="#"> -->

        <form name="coolEye" action="#">
            <div class="tabs">
                <ul>
                    <li id="coolEyeYT_tab" class="current"><span><a href="javascript:mcTabs.displayTab('coolEyeYT_tab','coolEyeYT_panel');" onmousedown="return false;"><?php _e("YouTube", 'coolEye'); ?></a></span></li>
                    <li id="coolEyePicasa_tab"><span><a href="javascript:mcTabs.displayTab('coolEyePicasa_tab','coolEyePicasa_panel');" onmousedown="return false;"><?php _e("Picasa", 'coolEye'); ?></a></span></li>
                    <li id="coolEyeFlickr_tab"><span><a href="javascript:mcTabs.displayTab('coolEyeFlickr_tab','coolEyeFlickr_panel');" onmousedown="return false;"><?php _e("Flickr", 'coolEye'); ?></a></span></li>
                    <li id="coolEyeRss_tab"><span><a href="javascript:mcTabs.displayTab('coolEyeRss_tab','coolEyeRss_panel');" onmousedown="return false;"><?php _e("Media RSS", 'coolEye'); ?></a></span></li>
                </ul>
            </div>

            <div class="panel_wrapper" style='height:470px'>
                <!-- CoolIris YouTube Embed panel -->
                <div id="coolEyeYT_panel" class="panel current" style="height:auto;"><br/>
                    <fieldset>
                        <legend>YouTube Selection</legend>
                        <table border="0" cellpadding="4" cellspacing="0">

                            <tr>
                                <td nowrap="nowrap"><label for="coolEyeHowtag" title="Find media by keyword search, user, album, or group -- Flickr: search, user, album, group -- Picasa: search or user -- YouTube: search"><?php _e("Find By:", 'coolEye'); ?></label></td>
                                <td><select id="coolEyeHowtag" name="coolEyeHowtag">
                                        <option value="">(default from coolEye settings)</option>
                                        <option value="search">Search Keywords</option>
                                        <option value="user">User</option>
                                        <option value="channel">Channel</option>
                                        <option value="favorites">Favorites</option>
                                        <option value="subscriptions">Subscriptions</option>
                                        <option value="playlist">Playlist</option>
                                    </select>
                                </td></tr>


                            <tr>
                                <td nowrap="nowrap"><label for="coolEyeSearchtag" title="Keywords, or Username for user, channel, playlist, subscriptions, or playlist number:"><?php _e("Search keywords, user, playlist #:", 'coolEye'); ?></label></td>
                                <td><input type="text" id="coolEyeSearchtag" name="coolEyeSearchtag" style="width: 250px" />
                                </td></tr>
								<tr><td nowrap="nowrap"><label for="coolEyeYtHrtag" title="Choose high or low resolution thumbnails"><?php _e("Thumbnail Resolution:", 'coolEye'); ?></label></td>
								<td><select id="coolEyeYtHrtag" name="coolEyeYtHrtag">
                                        <option value="hires">High</option>
                                        <option value="lowres">Low</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </fieldset>
                </div>

                <!-- RSS Media -->
                <div id="coolEyeRss_panel" class="panel" style="height:auto;">
                    <fieldset>
                        <legend>Media RSS Selection</legend>
                        <table border="0" cellpadding="4" cellspacing="0">

                            <tr>
                                <td nowrap="nowrap"><label for="coolEyeRssSearchtag" title="Media RSS URL (beware of crossdomain.xml restrictions"><?php _e("Media RSS URL:", 'coolEye'); ?></label></td>
                                <td><input type="text" id="coolEyeRssSearchtag" name="coolEyeRssSearchtag" style="width: 250px" />
                                </td>
                            </tr>
                        </table>
                    </fieldset>
                </div>

                <!-- Picasa -->
                <div id="coolEyePicasa_panel" class="panel" style="height:auto;">
                    <fieldset>
                        <legend>Picasa Selection</legend>
                        <table border="0" cellpadding="4" cellspacing="0">

                            <tr>
                                <td nowrap="nowrap"><label for="coolEyePicasaHowtag" title="Find media by keyword search, user, or album"><?php _e("Find By:", 'coolEye'); ?></label></td>
                                <td><select id="coolEyePicasaHowtag" name="coolEyePicasaHowtag">
                                        <option value="">(default from coolEye settings)</option>
                                        <option value="search">Search Keywords</option>
                                        <option value="user">User</option>
                                        <option value="album">Album (must set owner Username)</option>
                                    </select>
                                </td></tr>

                            <tr>
                                <td nowrap="nowrap"><label for="coolEyePicasaSearchtag" title="Search keywords, username, or album id"><?php _e("Keywords, Username, or Album ID:", 'coolEye'); ?></label></td>
                                <td><input type="text" id="coolEyePicasaSearchtag" name="coolEyePicasaSearchtag" style="width: 250px" />
                                </td>
                            </tr>

                            <tr>
                                <td nowrap="nowrap"><label for="coolEyePicasaOwnertag" title="Picasa Album Owner User (just for albums)"><?php _e("Username who owns album:", 'coolEye'); ?></label></td>
                                <td><input type="text" id="coolEyePicasaOwnertag" name="coolEyePicasaOwnertag" style="width: 250px" />
                                </td>
                            </tr>

                            <tr>
                                <td nowrap="nowrap"><label for="coolEyeFeaturedtag" title="Picasa Featured Photo ID"><?php _e("ID # of featured image:", 'coolEye'); ?></label></td>
                                <td><input type="text" id="coolEyeFeaturedtag" name="coolEyeFeaturedtag" style="width: 250px" />
                                </td>
                            </tr>

                            <tr>
                                <td nowrap="nowrap"><label for="coolEyeFeaturedAlbumtag" title="ID of album that contains featured image"><?php _e("ID # of album containing featured image:", 'coolEye'); ?></label></td>
                                <td><input type="text" id="coolEyeFeaturedAlbumtag" name="coolEyeFeaturedAlbumtag" style="width: 250px" />
                                </td>
                            </tr>

                        </table>
                    </fieldset>
                </div>

                <!-- Flickr -->
                <div id="coolEyeFlickr_panel" class="panel" style="height:auto;">
                    <fieldset>
                        <legend>Flickr Selection</legend>
                        <table border="0" cellpadding="4" cellspacing="0">

                            <tr>
                                <td nowrap="nowrap"><label for="coolEyeFlickrHowtag" title="Find media by keyword search, user, album, or group"><?php _e("Find By:", 'coolEye'); ?></label></td>
                                <td><select id="coolEyeFlickrHowtag" name="coolEyeFlickrHowtag">
                                        <option value="">(default from coolEye settings)</option>
                                        <option value="search">Search Keywords</option>
                                        <option value="user">User</option>
                                        <option value="album">Album</option>
                                        <option value="group">Group</option>
                                    </select>
                                </td></tr>

                            <tr>
                                <td nowrap="nowrap"><label for="coolEyeFlickrSearchtag" title="Search keywords, username, or album id"><?php _e("Keywords, Username, Album, or Group:", 'coolEye'); ?></label></td>
                                <td><input type="text" id="coolEyeFlickrSearchtag" name="coolEyeFlickrSearchtag" style="width: 250px" />
                                </td>
                            </tr>
                        </table>
                    </fieldset>
                </div>

                <div id="coolEyeCommon_panel" class="panel" style="display:block;">
                    <br/><br/>
                    <fieldset>
                        <legend>CoolIris Wall Appearance</legend>
                        <table border="0" cellpadding="4" cellspacing="0">

                            <tr>
                                <td nowrap="nowrap"><label for="coolEyeWidtag"><?php _e("CoolIris Width In Pixels:", 'coolEye'); ?></label></td>
                                <td><input type="text" id="coolEyeWidtag" name="coolEyeWidtag" style="width: 100px" />
                                </td>
                            </tr>

                            <tr>
                                <td nowrap="nowrap"><label for="coolEyeHitetag"><?php _e("CoolIris Height In Pixels:", 'coolEye'); ?></label></td>
                                <td><input type="text" id="coolEyeHitetag" name="coolEyeHitetag" style="width: 100px" />
                                </td>
                            </tr>
                            <tr>
                                <td nowrap="nowrap"><label for="coolEyeRowstag"><?php _e("CoolIris Thumbnail Rows (1-7):", 'coolEye'); ?></label></td>
                                <td><input type="text" id="coolEyeRowstag" name="coolEyeRowstag" style="width: 100px" />
                                </td>
                            </tr>

                            <tr>
                                <td nowrap="nowrap"><label for="coolEyeThemetag"><?php _e("CoolIris Background Preset:", 'coolEye'); ?></label></td>
                                <td><select id="coolEyeThemetag" name="coolEyeThemetag">
                                        <option value="">(default from coolEye settings)</option>
                                        <option value="black">Black</option>
                                        <option value="white">White</option>
                                        <option value="light">Light</option>
                                        <option value="dark">Dark</option>
                                        <option value="customrgb">Custom RGB</option>
                                        <option value="customurl">Custom URL</option>
                                    </select>
                                </td></tr>

                            <tr>
                                <td nowrap="nowrap"><label for="coolEyeRGBtag" title="RRGGBB"><?php _e("Custom RGB Background <br/> (Hex 6 digits):", 'coolEye'); ?></label></td>
                                <td><input type="text" id="coolEyeRGBtag" name="coolEyeRGBtag" style="width: 100px" />
                                </td>
                            </tr>

                            <tr>
                                <td nowrap="nowrap"><label for="coolEyeURLtag" title="An image to use as a background for the gallery. Is stretched to fit."><?php _e("Custom URL Background", 'coolEye'); ?></label></td>
                                <td><input type="text" id="coolEyeURLtag" name="coolEyeURLtag" style="width: 250px" />
                                </td>
                            </tr>

                            <tr>
                                <td nowrap="nowrap"><label for="coolEyeOpacitytag" title="Opacity of the gallery background"><?php _e("Background Opacity (0.0-1.0)", 'coolEye'); ?></label></td>
                                <td><input type="text" id="coolEyeOpacitytag" name="coolEyeOpacitytag" style="width: 100px" />
                                </td>
                            </tr>

                            <tr>
                                <td nowrap="nowrap"><label for="coolEyeChrometag" title="Do you want a rectangular bar behind the CoolIris controls at the bottom of the gallery?"><?php _e("Show Controls Background", 'coolEye'); ?></label></td>
                                <td><select id="coolEyeChrometag" name="coolEyeChrometag">
                                        <option value="">(default from coolEye settings)</option>
                                        <option value="show">Show</option>
                                        <option value="hide">Hide</option>
                                    </select>
                                </td></tr>

                            <tr>
                                <td nowrap="nowrap"><label for="coolEyeBrandtag" title="CoolEye Logo?"><?php _e("CoolEye Logo", 'coolEye'); ?></label></td>
                                <td><select id="coolEyeBrandtag" name="coolEyeBrandtag">
                                        <option value="">(default from coolEye settings)</option>
                                        <option value="show">Show</option>
                                        <option value="hide">Hide</option>
                                    </select>
                                </td></tr>

                            <tr>
                                <td nowrap="nowrap"><label for="coolEyeToolbartag" title="CoolEye Toolbar?"><?php _e("CoolEye Toolbar", 'coolEye'); ?></label></td>
                                <td><select id="coolEyeToolbartag" name="coolEyeToolbartag">
                                        <option value="">(default from coolEye settings)</option>
                                        <option value="show">Show</option>
                                        <option value="hide">Hide</option>
                                    </select>
                                </td></tr>

                            <tr>
                                <td nowrap="nowrap"><label for="coolEyeExactfittag" title="Exact Fit Single Image?"><?php _e("Exact Fit Single Image", 'coolEye'); ?></label></td>
                                <td><select id="coolEyeExactfittag" name="coolEyeExactfittag">
                                        <option value="">(default from coolEye settings)</option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </td></tr>

                            <tr>
                                <td nowrap="nowrap"><label for="coolEyeTilttag" title="Wall Tilt (0-5)"><?php _e("Wall Tilt (0-5):", 'coolEye'); ?></label></td>
                                <td><input type="text" id="coolEyeTilttag" name="coolEyeTilttag" style="width: 100px" />
                                </td>
                            </tr>
                        </table>
                    </fieldset>


                </div>
                <!-- end coolEyeYT panel -->


            </div>


            <div class="mceActionPanel">
                <div style="float: left">
                    <input type="button" id="cancel" name="cancel" value="<?php _e("Cancel", 'coolEye'); ?>" onclick="tinyMCEPopup.close();" />
                </div>

                <div style="float: right">
                    <input type="submit" id="insert" name="insert" value="<?php _e("Insert", 'coolEye'); ?>" onclick="insertcoolEyeLink();" />
                </div>
            </div>
        </form>


    </body>
</html>
