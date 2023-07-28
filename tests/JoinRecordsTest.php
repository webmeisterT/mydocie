<?php 
use PHPUnit\Framework\TestCase;
use App\JoinRecords;

final class JoinRecordsTest extends TestCase
{
     // Test read records
     public function testJoinRecords () {
        $jn = new JoinRecords;
        // $this->assertIsArray($jn->join("*", "doctors", "ekiti_clinics", "id1", "id2", "1", []));
    }

}