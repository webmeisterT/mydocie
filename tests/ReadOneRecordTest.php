<?php 
use PHPUnit\Framework\TestCase;
use App\ReadOneRecord;

final class ReadOneRecordTest extends TestCase
{
     // Test read records
     public function testReadOneRecord () {
        $rd = new ReadOneRecord;
        $this->assertIsArray($rd->read("*", "patients", "id=1", []));
    }

}