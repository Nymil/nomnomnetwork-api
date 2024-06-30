<?php

namespace App\Modules\Users\Services;

use App\Models\User;
use App\Modules\Core\Services\Service;

class UserService extends Service {

    public function __construct(User $model)
    {
        parent::__construct($model);
    }

}
