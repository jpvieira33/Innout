<?php

 class User extends Model {
    protected static $tableName = 'users';
    protected static $colunas = [
        'id',
        'name',
        'password',
        'email',
        'start_date',
        'end_date',
        'is_admin',
    ];
 }

?>