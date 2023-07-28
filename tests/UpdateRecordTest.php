<?php
use PHPUnit\Framework\TestCase;
use App\UpdateRecord;

final class UpdateRecordTest extends TestCase
{
    // Test on construct
    public function testUpdate () {
        $up = new UpdateRecord;
        // $this->assertIsBool($up->update('patients', '*', 'id=:id', ['id'=>1]));
    }
   
}
