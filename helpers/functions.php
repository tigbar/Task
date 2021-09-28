<?php

public function insert($table, $params){
    $sql = "insert into " . $table .  "values (";

    foreach ($params as $param[$key]=>$value){
        $sql .= $value . ', ';
    }

    $sql .= ')';

    $query = $this->pdo->prepare($sql);
    $query->execute($params);
    return $query;
}
