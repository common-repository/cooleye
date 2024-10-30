<?php

/**
 * @title TinyMCE V3 Button Integration (for Wp2.5+)
 * @author Alex Rabe
 */
class add_coolEye_button {

    var $pluginname = "coolEye";

    function add_coolEye_button() {
        // Modify the version when tinyMCE plugins are changed.
        add_filter('tiny_mce_version', array(&$this, 'ci_change_tinymce_version'));

        // init process for button control
        add_action('init', array(&$this, 'ci_addbuttons'));
    }

    function ci_addbuttons() {

        // Don't bother doing this stuff if the current user lacks permissions
        if (!current_user_can('edit_posts') && !current_user_can('edit_pages'))
            return;

        // Add only in Rich Editor mode
        if (get_user_option('rich_editing') == 'true') {

            // add the button for wp2.5 in a new way
            add_filter("mce_external_plugins", array(&$this, "ci_add_tinymce_plugin"), 5);
            add_filter('mce_buttons', array(&$this, 'ci_register_button'), 5);
        }
    }

    // used to insert button in wordpress 2.5x editor
    function ci_register_button($buttons) {

        array_push($buttons, "separator", $this->pluginname);

        return $buttons;
    }

    // Load the TinyMCE plugin : editor_plugin.js (wp2.5)
    function ci_add_tinymce_plugin($plugin_array) {

        $plugin_array[$this->pluginname] = coolEye_URLPATH . 'tinymce/editor_plugin.js';

        return $plugin_array;
    }

    function ci_change_tinymce_version($version) {
        return++$version;
    }

}

// Call it now
$tinymce_button = new add_coolEye_button ();
?>