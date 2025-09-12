<?php

if (!function_exists('getProfileImage')) {
    function getProfileImage($userId) {
        try {
            $db = \Config\Database::connect();
            $query = $db->table('admin')->select('picture')->where('id', $userId)->get()->getRow();
            return $query ? base_url('public/dist/img/uploads/' . $query->picture) : base_url('public/dist/img/uploads/default.png');
        } catch (\Exception $e) {
            log_message('error', 'getProfileImage error: ' . $e->getMessage());
            return base_url('public/dist/img/uploads/default.png');
        }
    }
}