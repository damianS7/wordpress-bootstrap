<?php
namespace Xtube\Backend\Controllers;

use Xtube\Backend\XtubeBackend;
use Xtube\Backend\Models\Setting;

class SettingsController {

    // Metodo para procesar los formularios (POST)
    public function handle_forms() {
        if (isset($_POST['update_setting'])) {
            $setting_name = sanitize_text_field($_POST['setting_name']);
            $setting_value = sanitize_text_field($_POST['setting_value']);
            if (Setting::update_setting($setting_name, $setting_value)) {
                $data['success'] = 'The setting has been updated.';
                set_transient('settings_view_data', $data, 60*60*2);
            } else {
                $data['error'] = 'The setting cannot be updated.';
                set_transient('settings_view_data', $data, 60*60*2);
            }
        }

        if (wp_redirect($_SERVER['HTTP_REFERER'])) {
            exit;
        }
    }

    // Metodo para renderizar la vista.
    public function render() {
        $data = array();
        $view_data = get_transient('settings_view_data');
        if (!empty($view_data)) {
            delete_transient('settings_view_data');
            $data = array_merge($view_data, $data);
        }

        $data['settings'] = Setting::get_settings();
        return XtubeBackend::view('settings.php', $data);
    }
}