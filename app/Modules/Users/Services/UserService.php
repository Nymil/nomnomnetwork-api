<?php

namespace App\Modules\Users\Services;

use App\Models\User;
use App\Modules\Core\Services\Service;
use Illuminate\Support\Facades\Hash;

class UserService extends Service {

    protected $rules = [
        "add" => [
            'name' => 'required|unique:users,name',
            'password' => 'required|min:5',
        ],
    ];

    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function add($data, String $ruleKey = "add") {
        if (!$this->validate($data, $ruleKey)) {
            return;
        }

        $user = new User();
        $user->name = $data['name'];
        $user->password = Hash::make($data['password']);
        $user->save();
    }

}
