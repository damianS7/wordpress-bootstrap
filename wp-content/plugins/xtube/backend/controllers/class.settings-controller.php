<?php
namespace Xtube\Backend\Controllers;

use Xtube\Backend\XtubeBackend;
use Xtube\Backend\Models\Setting;

class SettingsController {
    public function view_settings() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            return $this->render($this->handle_forms());
        }
        return $this->render();
    }

    // Metodo para procesar los formularios (POST)
    public function handle_forms() {
        if (isset($_POST['update_setting'])) {
            $setting_name = sanitize_text_field($_POST['setting_name']);
            $setting_value = sanitize_text_field($_POST['setting_value']);
            if (Setting::update_setting($setting_name, $setting_value)) {
                return array('success' => 'The setting has been updated.');
            } else {
                return array('success' => 'The setting cannot be updated.');
            }
        }
    }

    // Metodo para renderizar la vista.
    public function render($data = array()) {
        $data['settings'] = Setting::get_settings();
        return XtubeBackend::view('settings.php', $data);
    }
}