<?php
namespace App\Validation;
use App\Models\UserModel;

class UserRules
{
    public function validateUser(string $str, string $fields, array $data) {
    
        $userModel = new UserModel();
        $user      = $userModel->where('nome', $data['login'])
                        ->where('senha', md5($data['password']))
                        ->first();

        if ($user) {
            return true;
        }

        return false;
    }
}