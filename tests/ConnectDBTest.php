<?php
use PHPUnit\Framework\TestCase;
use App\ConnectDB;

final class ConnectDBTest extends TestCase
{
    // Test on construct
    public function testConstruct () {
        $cn = new ConnectDB;
        $this->assertIsObject($cn->__construct());
    }
   
}
