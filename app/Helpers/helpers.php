<?php

use Illuminate\Support\Str;

if (! function_exists('unique_random')) {
    /**
     * Generate a unique random string of characters
     * uses str_random() helper for generating the random string.
     *
     * @param     $table - name of the table
     * @param     $col - name of the column that needs to be tested
     * @param int $chars - length of the random string
     *
     * @return string
     */
    function unique_random($table, $col, $chars = 16)
    {
        $unique = false;

        // Store tested results in array to not test them again
        $tested = [];

        do {

            // Generate random string of characters
            $random = Str::random($chars);

            // Check if it's already testing
            // If so, don't query the database again
            if (in_array($random, $tested)) {
                continue;
            }

            // Check if it is unique in the database
            $count = DB::table($table)->where($col, '=', $random)->count();

            // Store the random character in the tested array
            // To keep track which ones are already tested
            $tested[] = $random;

            // String appears to be unique
            if ($count == 0) {
                // Set unique to true to break the loop
                $unique = true;
            }

            // If unique is still false at this point
            // it will just repeat all the steps until
            // it has generated a random string of characters
        } while (! $unique);

        return $random;
    }
}

if (! function_exists('readCSV')) {
    function readCSV($filename = '', $delimiter = ',')
    {
        // Read the file
        $file = fopen($filename, 'r');

        // Iterate over it to get every line
        while (($line = fgetcsv($file)) !== false) {
            // Store every line in an array
            $data[] = $line;
        }
        fclose($file);

        return $data;
    }
}

if (! function_exists('writeCSV')) {
    function writeCSV($filename = '', $data = [])
    {
        $file = fopen($filename, 'w');

        // Write remaining lines to file
        foreach ($data as $fields) {
            fputcsv($file, $fields);
        }
        fclose($file);
    }
}
