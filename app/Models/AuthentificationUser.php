<?php

namespace App\Models;

use PHPFramework\Model;

class AuthentificationUser extends Model
{
    protected string $table = 'users';

    public bool $timestamps = false;

    protected array $loaded = ['email', 'password'];

    protected array $fillable = ['email', 'password'];

    protected array $rules = [
        'required' => ['email', 'password'],
        'email' => 'email',
    ];

    protected array $labels = [
        'email' => 'E-mail',
        'password' => 'Пароль',
    ];

}
