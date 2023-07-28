<?php
namespace App;

use App\ConnectDB;

class ReadRecords extends ConnectDB {

    // Select all records from the table
    public function read(string $column, string $table, string $where, array $data): array
    {
        $query = "SELECT $column FROM $table WHERE $where";
        $stmt = $this->conn->prepare($query);
        $stmt->execute($data);
        return $stmt->fetchAll();
    }

}
