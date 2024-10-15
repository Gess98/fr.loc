<?php

namespace PHPFramework;

use Valitron\Validator;

abstract class Model extends \Illuminate\Database\Eloquent\Model
{
    protected array $loaded = [];
    // Поля для заполнения
    protected $fillable = [];
    // Поля для заполнения с данными
    public $attributes = [];
    // Правила валидации
    protected array $rules = [];
    // Названия полей, которые будут выводиться пользователб после валидации
    protected array $labels = [];
    // Ошибки валидации
    protected array $errors = [];


    public function save(array $options = [])
    {
        foreach ($this->attributes as $k => $v) {
            if (!in_array($k, $this->fillable)) {
                unset($this->attributes[$k]);
            }
        }
        return parent::save($options);
    }

    public function loadData(): void 
    {
        $data = request()->getData();
        foreach($this->loaded as $field) {
            if(isset($data[$field])) {
                $this->attributes[$field] = $data[$field];
            } else {
                $this->attributes[$field] = '';
            }
        }
    }

    public function validate($data = [], $rules = [], $labels = []) : bool
    {
        if(!$data) {
            $data = $this->attributes;
        }

        if(!$rules) {
            $rules = $this->rules;
        }

        if(!$labels) {
            $labels = $this->labels;
        }

        Validator::langDir(WWW . '/lang');
        Validator::lang('ru');
        $validator = new Validator($data);
        $validator->rules($rules);
        $validator->labels($labels);
        if($validator->validate()){
            return true;
        } else {
            $this->errors = $validator->errors();
            return false;
        }
    }

    public function getErrors(): array 
    {
        return $this->errors;
    }
}
