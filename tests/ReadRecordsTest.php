<?php

use App\Model\ReadRecord;
use PHPUnit\Framework\TestCase;
use App\ReadRecords;

final class ReadRecordsTest extends TestCase
{
     // Test read records
     public function testReadRecords () {
        $rd = new ReadRecords;
        $this->assertIsArray($rd->read("*", "doctors", "1", []));
    }

}