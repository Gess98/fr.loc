<?php

namespace PHPFramework;

use Valitron\Validator;

abstract class Model
{
    // название таблицы
    protected string $table; 
    // свойство для формирования полей created_at и updated_at
    public bool $timestamps = true;

    protected array $loaded = [];
    // Поля для заполнения
    protected array $fillable = [];
    // Поля для заполнения с данными
    public array $attributes = [];
    // Правила валидации
    protected array $rules = [];
    // Названия полей, которые будут выводиться пользователб после валидации
    protected array $labels = [];
    // Ошибки валидации
    protected array $errors = [];


    // Метод отвечающий за сохранение вставки в базу данных
    public function save(): false|string
    {
        foreach ($this->attributes as $k => $v) {
            if (!in_array($k, $this->fillable)) {
                unset($this->attributes[$k]);
            }
        }

        // insert into (`f1`, `f2`) values (:f1, :f2);
        // Поля таблицы
        // Получение ключей из массива attributes
        $fields_keys = array_keys($this->attributes);
        // Пробегание по массиву $fields_keys и оборачивание каждого элемента в обратные кавычки
        $fields = array_map(fn($field) => "`{$field}`", $fields_keys);
        // Преобразование массива в строку
        $fields = implode(',', $fields);
        if($this->timestamps) {
            $fields .= ', `created_at`, `updated_at`';
        }

        // Тоже самое, но только для позиционных элементов запроса
        $placeholders = array_map(fn($field) => ":{$field}", $fields_keys);
        $placeholders = implode(',', $placeholders);
        if($this->timestamps) {
            $placeholders .= ', :created_at, :updated_at';
            $this->attributes['created_at'] = date("Y-m-d H:i:s");
            $this->attributes['updated_at'] = date("Y-m-d H:i:s");
        }

        $query = "insert into {$this->table} ({$fields}) values ({$placeholders})";
        // Выполнение запроса
        db()->query($query, $this->attributes);
        return db()->getInsertId();
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

        Validator::addRule('unique', function($field, $value, array $params, array $fields) {
            // Получение параметров для запроса
            $data = explode(',', $params[0]);
            // Инвертирует результат в false, если в базе есть пользователь и наоборот, если нет
            return !(db()->findOne($data[0], $value, $data[1]));
            // dd($field, $value, $params, $data, $user);
        }, 'Must be unique');

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
