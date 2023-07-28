<?php
namespace App;

use App\ConnectDB;

class JoinRecords extends ConnectDB {

    // Select all records from joint table
    public function join(string $column, string $table, string $table2, string $id1, string $id2, string $where, array $data): array
    {
        $query = "SELECT $column FROM $table t1 INNER JOIN $table2 t2 ON t1.$id1=t2.$id2 WHERE $where ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute($data);
        return $stmt->fetchAll();
    }

}
