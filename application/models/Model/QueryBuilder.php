<?php
namespace App\Models\Model;

class QueryBuilder extends Connexion
{
    protected static $query;
    protected static $queryType;
    protected static $prepare;

    public function select($data, $table1, $joinFactor = null, $table2 = null, $whereParam = null, $whereValue = null, $orderBy = null) {
        self::$queryType = strtoupper('select');
        // QUERY
        $query = 'SELECT ' . $data . ' FROM ' . $table1;
        $query .= !empty($joinFactor) && !empty($table2) ? ' INNER JOIN ' . $table2 . ' ON ' . $table1 . '.' . $joinFactor . ' = ' . $table2 . '.' . $joinFactor : '';
        $query .= !empty($whereParam) && !empty($whereValue) ? ' WHERE ' . $whereParam . ' = ' . $whereValue : '';
        $query .= !empty($orderBy) ? ' ORDER BY ' . $orderBy : '';
        self::$query = $query;
        var_dump($query);
        // PREPARE AND EXECUTE QUERY
        $prepare = self::getConnexion()->prepare($query);
        self::$prepare = $prepare;
        $prepare->execute();
        $data = $prepare->fetchAll();

        return $data;
    }

    public function update($table, array $column, array $data, $whereParam, $whereValue) {

        self::$queryType = strtoupper('update');
        // QUERY
        $query = 'UPDATE ' . $table . ' SET ';
        $query .= '';
        for($i = 0; $i < count($column)-1; $i++) {
            $query .= $column[$i] . ' = "' . $data[$i] . '", ';
        }
        $query .= $column[count($column)-1] . ' = "' . $data[count($column)-1] . '"';

        $query .= ' WHERE ' . $whereParam . ' = ' . $whereValue;
        self::$query = $query;
        var_dump($query);
        // PREPARE AND EXECUTE QUERY
        $prepare = parent::getConnexion()->prepare($query);
        self::$prepare = $prepare;
        $prepare->execute();

        Log::access();
    }

    public function delete($table, $whereParam, $whereValue) {
        self::$queryType = strtoupper('delete');
        // QUERY
        $query = 'DELETE FROM ' . $table . ' WHERE ' . $whereParam . ' = ' . $whereValue;
        self::$query = $query;
        // PREPARE AND EXECUTE QUERY

        Log::access();

        if($this->exist($table, $whereParam, $whereValue)) {
            $prepare = parent::getConnexion()->prepare($query);
            self::$prepare = $prepare;
            $prepare->execute();

            return true;
        }
        else {
            return false;
        }
    }

    public function count($table) {
        self::$queryType = strtoupper('count');
        // QUERY
        $query = 'SELECT COUNT(*) FROM ' . $table;
        self::$query = $query;
        // PREPARE AND EXECUTE QUERY
        $prepare = parent::getConnexion()->prepare($query);
        self::$prepare = $prepare;
        $prepare->execute();
        $data = $prepare->fetchAll();

        return $data;
    }

    public function exist($table, $whereParam, $whereValue) {
        self::$queryType = strtoupper('exist');

        // QUERY
        $query = 'SELECT * FROM ' . $table . ' WHERE ' . $whereParam . ' = ' . $whereValue;
        self::$query = $query;
        // PREPARE AND EXECUTE QUERY
        $prepare = parent::getConnexion()->prepare($query);
        self::$prepare = $prepare;
        $prepare->execute();
        $data = $prepare->fetchAll();

        Log::access();

        if(empty($data)) {
            return false;
        }
        else {
            return true;
        }
    }

    public function getById($table, $id) {
        self::$queryType = strtoupper('SELECT BY ID');

        // QUERY
        $query = 'SELECT * FROM ' . $table . ' WHERE id = ' . $id;
        self::$query = $query;
        // PREPARE AND EXECUTE QUERY
        $prepare = parent::getConnexion()->prepare($query);
        self::$prepare = $prepare;
        $prepare->execute();
        $data = $prepare->fetchAll();

        return $data;
    }

    public function persist($obj) {
        $table = $obj->table;
        $columns = $obj->columns;
        $infos = $obj->infos;

        $exist = $this->getById($table, $obj->id);
        if(empty($exist)) {
            self::$queryType = strtoupper('insert');

            $query = 'INSERT INTO ' . $table;
            $query .= '(' . implode(', ', $columns);
            $query .= ') VALUE (';
            for($i = 0; $i < count($infos)-1; $i++) {
                $query .= '"' . $infos[$i] . '", ';
            }
            $query .= '"' . $infos[count($infos)-1] . '"';
            $query .= ');';

            $prepare = parent::getConnexion()->prepare($query);
            self::$prepare = $prepare;
            $prepare->execute();
        }
        else {
            $this->update($table, $columns, $infos, 'id', $infos[0]);
        }
    }
}