<?php 
use PHPUnit\Framework\TestCase;
use App\DeleteRecord;

final class DeleteRecordTest extends TestCase
{
     // Test read records
     public function testDeleteRecord () {
        $del = new DeleteRecord;
        // $this->assertIsBool($del->delete("doctors","id=1",[]));
    }

}
