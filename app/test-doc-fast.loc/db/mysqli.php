<?php

final class MySQL
{
    private static $instance;

    private static $hasInstance = false;

    private $db_link;

    public $db_count = 0;


    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct()
    {

        if (!self::$hasInstance) {
            $this->db_link = new mysqli(BD_HOST, BD_USER, BD_PASS, BD_NAME);

            if ($this->db_link->connect_errno) {
                throw new \Exception($this->db_link->connect_error);
            }

            $this->db_link->set_charset("utf8");
        } else {
            throw new \Exception("Class is already instantiated.");
        }

        self::$hasInstance = true;
    }

    private function __clone()
    {
        throw new \Exception("Class could not be cloned.");
    }

    private function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public function query($sql)
    {
        $query = $this->db_link->query($sql);

        $this->db_count += 1;

        if ($this->db_link->errno) {
            throw new \Exception($this->db_link->error);
        }

        return $query;
    }

    private function fetch_assoc($result)
    {
        return $result->fetch_assoc();
    }

    public function insert_id()
    {
        return $this->db_link->insert_id;
    }

    private function num_rows($result)
    {
        return $result->num_rows;
    }

    public function __destruct()
    {
        $this->db_link->close();
    }
}

?>
