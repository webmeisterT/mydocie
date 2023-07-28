<?php 
use PHPUnit\Framework\TestCase;
use App\Sanitize;

final class SanitizeTest extends TestCase
{
     // Test read records
     public function testSanitize() {
        $this->assertIsString(Sanitize::sanitizeData("doctors"));
    }

}