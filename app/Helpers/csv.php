<?php

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

function writeCSV($filename = '', $data = [])
{
    $file = fopen($filename, 'w');

    // Write remaining lines to file
    foreach ($data as $fields) {
        fputcsv($file, $fields);
    }
    fclose($file);
}
