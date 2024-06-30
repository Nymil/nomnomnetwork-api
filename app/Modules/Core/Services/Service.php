<?php

namespace App\Modules\Core\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

abstract class Service {
    protected $model;
    protected $errors;
    protected $rules;


    public function __construct($model)
    {
        $this->model = $model;
    }

    public function getErrors(){
        return $this->errors;
    }

    public function hasErrors(){
        return $this->errors->isNotEmpty();
    }

    public function validate($data, $ruleKey = null) {
        $rules = $this->getRules($ruleKey);

        $this->errors = new MessageBag();
        $validator = Validator::make($data, $rules);
        if($validator->fails()){
            $this->errors = $validator->errors();
            return false;
        }
        return true;
    }

    private function getRules($ruleKey) {
        $rules = $this->rules;
        if (isset($this->rules[$ruleKey])) {
            $rules = $this->rules[$ruleKey];
        }

        return $rules;
    }
}
