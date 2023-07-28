<?php
namespace App;

use App\ConnectDB;

class DeleteRecord extends ConnectDB
{    
    
    // Delete table record
    public function delete(string $table, string $where_clause, array $data = []) : bool
    {
        $query = "DELETE FROM $table WHERE $where_clause ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute($data);
        return $stmt->rowCount();
    }
}
