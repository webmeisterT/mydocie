<?php
namespace App;
// require_once('ConnectDB.php');

use App\ConnectDB;

class CreateRecord extends ConnectDB
{
    
    // Create a record in the table
    public function create(string $table, string $column, string $value, array $data): bool
    {
        $query = "INSERT INTO $table($column) VALUES ($value) ";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute($data);
        // return $stmt->rowCount();
    }

}
