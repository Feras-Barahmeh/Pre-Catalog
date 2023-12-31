<?php

namespace App\Models;

use App\Core\Database\DatabaseHandler;
use PDOStatement;

/**
 * Model Class Contain static method help you do action whit DB
 */
class Model
{
    /**
     * prepare sql query
     * @param $sql
     * @return mixed
     */
    public static function prepare(&$sql): mixed
    {
        return DatabaseHandler::factory()->prepare($sql);
    }

    /**
     * @param $query string the query you want execute
     * @param PDOStatement|null $returnType PDO constant to determine type return
     * @return false|array
     */
    public static function execute(string $query, mixed $returnType=null): false|array
    {
        $stmt = self::prepare($query);
        if ($stmt->execute()) {
            if ($returnType != '') {
                return $stmt->fetchAll($returnType);
            } else {
                return $stmt->fetchAll();
            }
        }
        return false;
    }


    /**
     * return count column from table
     * @param string $table name table contain this column
     * @param string $column name column you want count
     * @param $value
     * @return bool return true if equal false otherwise
     * @version 1.0
     * @author Feras Barahemeh
     */
    public static function equal(string $table, string $column, $value): bool
    {
        $sql = "
            SELECT 
                *
            FROM 
                " . $table ."
            WHERE
                $column = '$value'
        ";


        $stmt = self::prepare($sql);
        if ($stmt->execute()) {
            return  $stmt->rowCount();
        }
        return false;
    }

    public static function update(string $table, array|string $columns, array|string $values, string $condition): bool
    {
        $sql = "UPDATE $table SET ";


        if (is_array($columns) && is_array($values)) {
            if (count($columns) != count($values)) {
                throw new \Error("the columns not homogeneous with values");
            }

            $countAffectRows = count($columns);

            for ($i = 0; $i <= $countAffectRows - 1; $i++) {
                $temp = " {$columns[$i]} = {$values[$i]}";
                $sql .= $temp;
            }

            $sql .= " WHERE $condition";
        } else {
            $sql .= " {$columns} = $values WHERE {$condition}";
        }


        $stmt = self::prepare($sql);
        if ($stmt->execute()) return true;
        return false;

    }
}