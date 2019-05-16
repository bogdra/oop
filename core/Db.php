<?php


namespace Core;


use App\Interfaces\PersistenceInterface;


class Db implements PersistenceInterface
{
    public static $instance;
    private $queryHolder;
    private $pdoConn;
    public $error, $result, $count;


    private function __construct()
    {
        try
        {
            $this->pdoConn = new \PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
            $this->pdoConn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->pdoConn->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        }
        catch(\PDOException $e)
        {
            die($e->getMessage());
        }
    }


    public static function init() :DB
    {
        if (!isset(self::$instance))
        {
            self::$instance = new DB();
        }
        return self::$instance;
    }


    public function query(string $query, $params = [])
    {
        $this->error = false;
        $this->queryHolder = $this->pdoConn->prepare($query);
        if (!empty($params))
        {
            $paramNo = 1;
            foreach($params as $param)
            {
                $this->queryHolder->bindValue($paramNo, $param);
                $paramNo++;
            }
        }
        if ($this->queryHolder->execute())
        {
            $this->result = $this->queryHolder->fetchAll(\PDO::FETCH_OBJ);
            $this->count = $this->queryHolder->rowCount();
            return true;
        }
        else
        {
            $this->error = true;
            return false;
        }


    }


    /**
     * @param $table
     * @param array $params
     * @param $class
     * @return bool
     *
     * Usage:  read($tableName, ['conditions' => ['USD > ?',RON > ?], 'bind' => [1 ,2]]
     */
    public function read(string $table, $params = []) {
        $conditionString = '';
        $bind = [];
        $order = '';
        $limit = '';

        // conditions
        if(isset($params['conditions'])) {
            if(is_array($params['conditions'])) {
                foreach($params['conditions'] as $condition) {
                    $conditionString .= ' ' . $condition . ' AND';
                }
                $conditionString = trim($conditionString);
                $conditionString = rtrim($conditionString, ' AND');
            } else {
                $conditionString = $params['conditions'];
            }
            if($conditionString != '') {
                $conditionString = ' WHERE ' . $conditionString;
            }
        }

        // bind
        if(array_key_exists('bind', $params)) {
            $bind = $params['bind'];
        }

        // order
        if(array_key_exists('order', $params)) {
            $order = ' ORDER BY ' . $params['order'];
        }

        // limit
        if(array_key_exists('limit', $params)) {
            $limit = ' LIMIT ' . $params['limit'];
        }
        $sql = "SELECT * FROM {$table}{$conditionString}{$order}{$limit}";
        if($this->query($sql, $bind)) {
            if(!count($this->_result)) return false;
            return true;
        }
        return false;
    }


    public function insert(string $table, $fields = []) {
        $fieldString = '';
        $valueString = '';
        $values = [];

        foreach($fields as $field => $value) {
            $fieldString .= '`' . $field . '`,';
            $valueString .= '?,';
            $values[] = $value;
        }
        $fieldString = rtrim($fieldString, ',');
        $valueString = rtrim($valueString, ',');
        $sql = "INSERT INTO {$table} ({$fieldString}) VALUES ({$valueString})";
        if($this->query($sql, $values)) {
            return true;
        }
        return false;
    }


    public function update(string $table, int $id, $fields = []) {
        $fieldString = '';
        $values = [];
        foreach($fields as $field => $value) {
            $fieldString .= ' ' . $field . ' = ?,';
            $values[] = $value;
        }
        $fieldString = trim($fieldString);
        $fieldString = rtrim($fieldString, ',');
        $sql = "UPDATE {$table} SET {$fieldString} WHERE id = {$id}";
        if(!$this->query($sql, $values)->error()) {
            return true;
        }
        return false;
    }


    public function delete(string $table, int $id) {
        $sql = "DELETE FROM {$table} WHERE id = {$id}";
        if(!$this->query($sql)->error()) {
            return true;
        }
        return false;
    }


    public function count()
    {
        return count($this->result);
    }


    public function getResult()
    {
        return $this->result;
    }
}