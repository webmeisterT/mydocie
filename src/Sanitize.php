<?php
namespace App;

class Sanitize {

    public static function sanitizeData(string $data): string
    {
        return htmlspecialchars(stripslashes(trim($data)));
    }

}

