


<?php
/**
 * Created by PhpStorm.
 * User: dhaval
 * Date: 10/6/18
 * Time: 11:22 PM
 */

function readCSV($csvFile){
    $file_handle = fopen($csvFile, 'r');
    while(!feof($file_handle)){
        $line_of_text[] = fgetcsv($file_handle);
    }
    fclose($file_handle);
    return $line_of_text;
}

$csvFile = "excel.csv";
$csv = readCSV($csvFile);
print_r($csv);
echo '</pre>';