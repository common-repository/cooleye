<?php
/*
  Plugin Name: coolEye 
  Plugin URI: http://nductiv.com/plugins
  Description: This plugin adds the shortcode [coolEye] which embeds a CoolIris Wall into your post or page. It also adds a CoolIris Embed icon to the tinymce editor to insert that shortcode and set options. See the Settings page for the shortcode syntax.
  Author: Tony Asch
  Version: 1.1.4
  Author URI: http://nductiv.com/

  Copyright (c) 2010-2011 Tony Asch

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

class coolEye {

    function coolEye() {
        global $wp_version;
        // The current version
        define('coolEye_VERSION', '1.1.4');

        // Check for WP2.6 installation
        if (!defined('IS_WP26'))
            define('IS_WP26', version_compare($wp_version, '2.6', '>='));

        //This works only in WP2.6 or higher
        if (IS_WP26 == FALSE) {
            add_action('admin_notices', create_function('', 'echo \'<div id="message" class="error fade"><p><strong>' . __('Sorry, CoolIris Embed works only under WordPress 2.6 or higher', "cetsHW") . '</strong></p></div>\';'));
            return;
        }

        // define URL
        define('coolEye_ABSPATH', WP_PLUGIN_DIR . '/' . plugin_basename(dirname(__FILE__)) . '/');
        define('coolEye_URLPATH', WP_PLUGIN_URL . '/' . plugin_basename(dirname(__FILE__)) . '/');
        //define('tdPix_TAXONOMY', 'wt_tag');

        include_once (dirname(__FILE__) . "/lib/shortcodes.php");
        include_once (dirname(__FILE__) . "/tinymce/tinymce.php");
    }

}

function coolEye_settings() {
    add_options_page('CoolEye', 'CoolEye', 9, basename(__FILE__), 'coolEye_settings_page');
}

function coolEye_settings_page() {
?>
    <div class="wrap">
        <h2>CoolEye - Embed a CoolIris Gallery in a Page or Post</h2>
                                    		by: <a target="_blank" href="http://nductiv.com/plugins">Nductiv</a><br/><br/>
                                    		Shortcode to embed a <a href="http://www.cooliris.com/" target="_blank">CoolIris</a> Wall into a post or page.<br/><br/>
                                    		Notice that there's a button <img src="../wp-content/plugins/coolEye/tinymce/cooleye.png" alt="coolEye editor button icon" /> in the page and post editors to insert this shortcode and set the parameters.<br/>
        <br/>
        <a href="#syntax">Read about the coolEye shortcode syntax</a><br/><br/>
        <h3>Default Settings for CoolEye</h3>
        <form action="options.php" method="post">
        <?php wp_nonce_field('update-options'); ?>

        <fieldset style="border: solid 1px #000; width:700px;">
            <legend style="margin:10px;"><strong>Search Method</strong></legend>
            <table class="form-table">
                <tr><th>Search How?: </th> <td>
                        <select name="coolEye_how">
                            <option value="search" <?php if (get_option('coolEye_how') == 'search')
            echo 'selected="selected"'; ?>>Search Keywords</option>
                            <option value="user" <?php if (get_option('coolEye_how') == 'user')
                                        echo 'selected="selected"'; ?>>User</option>
                        </select>
                    </td></tr>
                <tr><th>Picasa User: </th> <td>  <input type="text" name="coolEye_puser" size="30" id="coolEye_puser" value="<?php echo get_option('coolEye_puser') ?>" /></td></tr>
            </table><br/>
        </fieldset><br/><br/>

        <fieldset style="border: solid 1px #000; width:700px;">
            <legend style="margin:10px;""><strong>CoolIris Appearance</strong></legend>
            <table class="form-table" >

                <tr><th width="300px">Gallery Width: </th> <td> <input type="text" name="coolEye_width" id="coolEye_width" size="5" value="<?php echo get_option('coolEye_width') ?>" />px</td></tr>
                <tr><th>Gallery Height: </th> <td>  <input type="text" name="coolEye_height" size="5" id="coolEye_height" value="<?php echo get_option('coolEye_height') ?>" />px</td></tr>
                <tr><th>Rows of Thumbnails: </th> <td>  <input type="text" name="coolEye_rows" size="5" id="coolEye_rows" value="<?php echo get_option('coolEye_rows') ?>" /></td></tr>
                <tr><th>Gallery Background Color?: </th> <td>
                        <select name="coolEye_theme">
                            <option value="black" <?php if (get_option('coolEye_theme') == 'black')
                                        echo 'selected="selected"'; ?>>Black</option>
                            <option value="white" <?php if (get_option('coolEye_theme') == 'white')
                                        echo 'selected="selected"'; ?>>White</option>
                            <option value="light" <?php if (get_option('coolEye_theme') == 'light')
                                        echo 'selected="selected"'; ?>>Light</option>
                            <option value="dark" <?php if (get_option('coolEye_theme') == 'dark')
                                        echo 'selected="selected"'; ?>>Dark</option>
                            <option value="customrgb" <?php if (get_option('coolEye_theme') == 'customrgb')
                                        echo 'selected="selected"'; ?>>Custom RGB</option>
                            <option value="customurl" <?php if (get_option('coolEye_theme') == 'customurl')
                                        echo 'selected="selected"'; ?>>Custom URL</option>
                        </select>
                    </td></tr>
                <tr><th>Gallery Opacity<br/>(0.0 - 1.0)<br/>where 1.0 is opaque : <br/>Must be used<br/>with Custom RGB<br/>Does not work in IE</th> <td>  <input type="text" name="coolEye_opacity" size="5" id="coolEye_opacity" value="<?php echo get_option('coolEye_opacity') ?>" /></td></tr>
                <tr><th>Gallery Custom<br/>Background RGB<br/>(i.e. #123456): </th> <td>  <input type="text" name="coolEye_rgb" size="7" id="coolEye_rgb" value="<?php echo get_option('coolEye_rgb') ?>" /></td></tr>
                <tr><th>Gallery Custom <br/>Background URL: </th> <td>  <input type="text" name="coolEye_url" size="70" id="coolEye_url" value="<?php echo get_option('coolEye_url') ?>" /></td></tr>
                <tr><th>Display Opaque Bar<br/>Under Gallery Controls: </th> <td>
                        <select name="coolEye_chrome">
                            <option value="show" <?php if (get_option('coolEye_chrome') == 'show')
                                        echo 'selected="selected"'; ?>>Show</option>
                            <option value="hide" <?php if (get_option('coolEye_chrome') == 'hide')
                                        echo 'selected="selected"'; ?>>Hide</option>
                        </select>
                    </td></tr>
                 <tr><th>CoolIris Branding?: </th> <td>
                        <select name="coolEye_brand">
                            <option value="show" <?php if (get_option('coolEye_brand') == 'show')
                                        echo 'selected="selected"'; ?>>Show</option>
                            <option value="hide" <?php if (get_option('coolEye_brand') == 'hide')
                                        echo 'selected="selected"'; ?>>Hide</option>
                        </select>
                    </td></tr>
                 <tr><th>CoolIris Toolbar?: </th> <td>
                        <select name="coolEye_toolbar">
                            <option value="show" <?php if (get_option('coolEye_toolbar') == 'show')
                                        echo 'selected="selected"'; ?>>Show</option>
                            <option value="hide" <?php if (get_option('coolEye_toolbar') == 'hide')
                                        echo 'selected="selected"'; ?>>Hide</option>
                        </select>
                    </td></tr>
                 <tr><th>Exact Fit CoolIris Content: </th> <td>
                        <select name="coolEye_exactfit">
                            <option value="yes" <?php if (get_option('coolEye_exactfit') == 'yes')
                                        echo 'selected="selected"'; ?>>Yes</option>
                            <option value="no" <?php if (get_option('coolEye_exactfit') == 'no')
                                        echo 'selected="selected"'; ?>>No</option>
                        </select>
                    </td></tr>
               <tr><th>Wall Tilt (0-5): </th> <td>  <input type="text" name="coolEye_tilt" size="7" id="coolEye_tilt" value="<?php echo get_option('coolEye_tilt') ?>" /></td></tr>
            </table><br/>
        </fieldset>
        <p class="submit">
            <input type="hidden" value="update" name="action">
            <input type="hidden" value="coolEye_height,coolEye_width,coolEye_rows,coolEye_mode,coolEye_theme,coolEye_rgb,coolEye_url,coolEye_chrome,coolEye_fuser,coolEye_puser,coolEye_yuser,coolEye_falbum,coolEye_fgroup,coolEye_palbum,coolEye_tilt,coolEye_ytype,coolEye_how,coolEye_brand,coolEye_toolbar,coolEye_exactfit,coolEye_opacity" name="page_options">
            <input type="submit" value="<?php _e('Save Changes') ?>" name="Submit">
        </p>
    </form>
</div>
<br/><br/>

<div>
    <fieldset style="border: solid 1px #000; width:700px; padding:10px;">
        <legend><strong><a name="syntax">Shortcode Syntax</a></strong></legend>

<?php
        include_once (dirname(__FILE__) . "/howto.php");
 ?>
        
    </fieldset>
</div>
<?php
                                }

                                /**
                                 * Add Settings link to plugin
                                 */
                                function coolEye_add_settings_link($links, $file) {
                                    static $this_plugin;

                                    if (!$this_plugin)
                                        $this_plugin = plugin_basename(__FILE__);

                                    if ($file == $this_plugin) {
                                        $settings_link = '<a href="admin.php?page=coolEye.php">' . __("Settings", "coolEye") . '</a>';
                                        array_unshift($links, $settings_link);
                                    }
                                    return $links;
                                }

                                function coolEye_install() {
                                    add_option('coolEye_how', 'search');
                                    add_option('coolEye_puser', '');
                                    add_option('coolEye_height', '400');
                                    add_option('coolEye_width', '500');
                                    add_option('coolEye_rows', '3');
                                    add_option('coolEye_theme', 'dark');
                                    add_option('coolEye_rgb', '');
                                    add_option('coolEye_url', '');
                                    add_option('coolEye_chrome', 'hide');
                                    add_option('coolEye_tilt', '2');
                                    add_option('coolEye_brand', 'hide');
                                    add_option('coolEye_toolbar', 'show');
                                    add_option('coolEye_exactfit', 'yes');
                                    add_option('coolEye_opacity', '1.0');
                                }

                                function coolEye_uninstall() {
                                    delete_option('coolEye_how');
                                    delete_option('coolEye_puser');
                                    delete_option('coolEye_height');
                                    delete_option('coolEye_width');
                                    delete_option('coolEye_rows');
                                    delete_option('coolEye_theme');
                                    delete_option('coolEye_rgb');
                                    delete_option('coolEye_url');
                                    delete_option('coolEye_chrome');
                                    delete_option('coolEye_tilt');
                                    delete_option('coolEye_brand');
                                    delete_option('coolEye_toolbar');
                                    delete_option('coolEye_exactfit');
                                    delete_option('coolEye_opacity');
                                }

// Start this plugin once all other plugins are fully loaded

                                add_action('plugins_loaded', create_function('', 'global $coolEye; $coolEye = new coolEye();'));

                                register_activation_hook(__FILE__, 'coolEye_install');
                                register_deactivation_hook(__FILE__, 'coolEye_uninstall');

                                add_action('admin_menu', 'coolEye_settings');
                                add_filter('plugin_action_links', 'coolEye_add_settings_link', 10, 2);
?>