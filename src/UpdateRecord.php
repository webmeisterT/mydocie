<?php
namespace App;

use App\ConnectDB;

class UpdateRecord extends ConnectDB
{    
    
    // Update table record
    public function update( string $table, string $column, string $where, array $data = []): bool
    {
        $query = "UPDATE $table SET $column WHERE $where";
        $stmt = $this->conn->prepare($query);
        $stmt->execute($data);
        return $stmt->rowCount();
    }

}

