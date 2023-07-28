<?php 
use PHPUnit\Framework\TestCase;
use App\CreateRecord;

final class CreateRecordTest extends TestCase
{
     // Test read records
     public function testCreateRecord () {
        $cr = new CreateRecord;
        $this->assertIsBool($cr->create("patients","first_name,last_name,email,phone,password","'John', 'Doe', '3444', '909999','12345'",[]));
    }

}
