<?php

namespace App\Traits;

trait GenerateUniqueId
{
    /**
     * Generate a unique alphanumeric ID.
     *
     * This method creates a random string of the specified length using
     * uppercase letters and numbers.
     *
     * @param int $length The length of the generated ID (default: 10).
     * @return string The generated unique ID.
     */
    protected function generateID($length = 10)
    {

        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}
