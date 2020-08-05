<?php

  class Model {
      protected static $tableName = '';
      protected static $colunas = [];
      protected $values = [];

       function __construct($arr)
       {
           $this->loadFromArray($arr);
       }

       public function loadFromArray($arr){
            if($arr){
                foreach ($arr as $key => $value) {
                   $this->$key = $value;
                }
            }
       }

       public function __get($key){
            return $this->values[$key];
       }

       public function __set($key, $value){
           $this->values[$key] = $value;
       }

    public static function getOne($filters = [], $colums = '*')
    {
        $class = get_called_class();
        $result = static::getResultSetFromSelect($filters, $colums);
        return $result ? new $class($result->fetch_assoc()) : null;
    }

       public static function get($filters = [], $colums = '*'){
          $objects = [];
          $result = static::getResultSetFromSelect($filters, $colums);
           
           if($result){
              $class = get_called_class();
              while($row = $result->fetch_assoc()){
                  array_push($objects, new $class($row));
              }
           } 
            return $objects; 
    }

       public static function getResultSetFromSelect($filters =[], $colums = '*'){
           $sql = "SELECT {$colums} FROM ". static::$tableName . static::getFilters($filters);
           return $result = Database::getResultFromQuery($sql);
            if($result->num_rows === 0){
                return null;
            } else {
                return $result;
            }
       }

       private static function getFilters($filters){
           $sql = '';
             if(count($filters) > 0){
                 $sql .= " WHERE 1 = 1";
                  foreach($filters as $colum => $value){
                  $sql .= " AND {$colum} = " . static::getFormatedValue($value);
                  }
             }
           return $sql;
       }

       private static function getFormatedValue($value){
           if(is_null($value)){
               return "null";
           } else if(gettype($value) === 'string'){
               return "'{$value}'";
           } else {
               return $value;
           }

       }
  }


?>