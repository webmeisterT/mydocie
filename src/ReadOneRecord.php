<?php
namespace App;
use App\ConnectDB;
// require('ConnectDB.php');

class ReadOneRecord extends ConnectDB {

    // Select One record from the table
    public function read(string $column, string $table, string $where, array $data)
    {
        $query = "SELECT $column FROM $table WHERE $where";
        $stmt = $this->conn->prepare($query);
        $stmt->execute($data);
        return $stmt->fetch();
    }

}
