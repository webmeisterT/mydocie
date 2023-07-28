<?php
namespace App;
use \PDO;
use \PDOException;

class ConnectDB {
    // DB parameters
    private string $host = "localhost";
    private string $user = "root";
    private string $dbname = "mydocie";
    private string $password = "root";
    // protected $conn = null;
    protected $conn;

    // DB Connect
    public function __construct()
    {
        // if ($this->conn == null) {
            try {
                $this->conn = new PDO('mysql:host='.$this->host.';dbname='.$this->dbname,$this->user,$this->password);
// echo "hi";
                // SET ATTRIBUTES
                $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

                // DEFAULT MODES
                $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                return $this->conn;

            } catch (PDOException $th) {
                throw "Connection Error: ". $th->getMessage();
            }
        // }
    }
}

// PDOStatement::rowCount();
