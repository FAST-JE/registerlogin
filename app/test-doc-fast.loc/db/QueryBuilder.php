<?php

namespace App\Db;
use \PDO, Aura\SqlQuery;

class QueryBuilder
{
    protected static $instance = null;
    protected static $queryFactory = null;

    const DB_HOST = 'db';
    const DB_USER = 'db_user';
    const DB_PASSWORD = 'pass';
    const DB_NAME = 'db_test';
    const CHARSET = 'utf8';
    const DB_PREFIX = '';

    /*
     * Returns instance or creates instance
     */
    public static function getInstance()
    {
        if (self::$instance !== null) {
            return self::$instance;
        }

        return new self;
    }

    /*
     * Creates a database connection and initialize queryFactory component
     */
    private function __construct()
    {
        self::$instance = new PDO(
            'mysql:host=' . self::DB_HOST . ';dbname=' . self::DB_NAME,
            self::DB_USER,
            self::DB_PASSWORD,
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES " . self::CHARSET
            ]
        );

        self::$queryFactory = new SqlQuery\QueryFactory('mysql');
    }

    /*
     * Returns rows of table
     *
     * @param string $table
     * @param array $data
     * @param array $cols
     * @param array $where
     *
     * @return array
     */
    public static function getMany($table, $data, $cols, $where = [])
    {
        $select = self::$queryFactory->newSelect();
        $select
            ->from($table)
            ->cols($cols);

        foreach ($where as $item)
            $select->where($item);

        $select->bindValues($data);

        $sth = self::$instance->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        $result = $sth->fetchAll();
        return $result;
    }

    /*
     * Returns row of table
     *
     * @param string $table
     * @param array $data
     * @param array $cols
     * @param array $where
     *
     * @return array
     */
    public static function getOne($table, $data, $cols, $where = [])
    {
        $select = self::$queryFactory->newSelect();
        $select
            ->from($table)
            ->cols($cols)
            ->limit(1);

        foreach ($where as $item)
            $select->where($item);

        $select->bindValues($data);

        $sth = self::$instance->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        $result = $sth->fetchAll();
        return $result;
    }

    /*
     * Insert row to table
     *
     * @param string $table
     * @param array $data
     *
     * @return bool
     */
    public static function insert($table, $data)
    {
        $insert = self::$queryFactory->newInsert();
        $insert
            ->into($table)
            ->cols($data);

        $sth = self::$instance->prepare($insert->getStatement());
        $sth->execute($insert->getBindValues());
        return true;
    }

    /*
    * Update row(s) in table
    *
    * @param string $table
    * @param array $data
    * @param array $cols
    * @param array $where
    *
    * @return bool
    */
    public static function update($table, $data, $cols, $where = [])
    {
        $update = self::$queryFactory->newUpdate();

        $update
            ->table($table)
            ->cols($cols);

        foreach ($where as $item)
            $update->where($item);

        $update->bindValues($data);

        $sth = self::$instance->prepare($update->getStatement());
        $sth->execute($update->getBindValues());
        return true;
    }

    /*
    * Delete row(s) in table
    *
    * @param string $table
    * @param array $data
    * @param array $where
    *
    * @return bool
    */
    public static function delete($table, $data, $where = [])
    {
        $delete = self::$queryFactory->newDelete();

        $delete->from($table);

        foreach ($where as $item)
            $delete->where($item);

        $delete->bindValues($data);

        $sth = self::$instance->prepare($delete->getStatement());
        $sth->execute($delete->getBindValues());
        return true;
    }

}
