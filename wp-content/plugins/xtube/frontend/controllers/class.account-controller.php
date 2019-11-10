<?php

class PluginName_Frontend_AccountController {
    public function view_accounts() {
        $data = array('success_message' => 'view loaded!');
        return PluginName_Frontend::view('accounts.php', $data);
    }
}
