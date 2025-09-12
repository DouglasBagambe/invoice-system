<?php

namespace App\Models;

use CodeIgniter\Model;

class User_signature_model extends Model
{
    protected $table = 'user_signatures';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'signature_name', 'signature_path', 'is_default', 'created_at'];

    public function getUserSignatures($userId)
    {
        return $this->where('user_id', $userId)
                   ->orderBy('is_default', 'DESC')
                   ->orderBy('created_at', 'DESC')
                   ->findAll();
    }

    public function getDefaultSignature($userId)
    {
        return $this->where('user_id', $userId)
                   ->where('is_default', 1)
                   ->first();
    }

    public function setDefaultSignature($userId, $signatureId)
    {
        // First, unset all defaults for this user
        $this->where('user_id', $userId)
             ->set('is_default', 0)
             ->update();

        // Then set the new default
        return $this->where('id', $signatureId)
                   ->where('user_id', $userId)
                   ->set('is_default', 1)
                   ->update();
    }

    public function addSignature($data)
    {
        return $this->insert($data);
    }

    public function deleteSignature($signatureId, $userId)
    {
        return $this->where('id', $signatureId)
                   ->where('user_id', $userId)
                   ->delete();
    }
}
