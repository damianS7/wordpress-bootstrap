<?php
namespace Xtube\Backend\Controllers;

class SettingsController {
    public function view_settings() {
        $data = array('success_message' => 'view loaded!');
        return \Xtube\Backend\XtubeBackend::view('settings.php', $data);
    }
}