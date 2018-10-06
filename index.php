<?php
/**
 * Created by PhpStorm.
 * User: dhaval
 * Date: 10/4/18
 * Time: 3:32 PM
 */

echo "This is dynamically generating tables project!";

main::start('excelFile.csv');

class main{
    static public function start($filename){
        echo $filename;
        $records = csv::getRecords($filename);
        $page = html::createTable($records);
        system::printPage($page);
    }
}

class csv{
    static public function getRecords($filename)
    {
        $file = fopen($filename, 'r');
        $fieldNames = array();
        $count = 0;

        while (!feof($file)) {
            echo $count;
            $record = fgetcsv($file);
            if ($count == 0) {
                $fieldNames = $record;
                echo "if";
            }
            else {
                echo "else";
                $records[] = recordFactory::create($fieldNames, $record);
            }
            $count++;
        }
        fclose($file);
    }
}

class recordFactory{
    public static function create(Array $fieldNames = null, Array $values = null){
        $record = new record($fieldNames, $values);
        return $record;
    }
}

class html{
    public static function createTable($records){
        $count = 0;

        foreach($records as $record){
            if($count == 0){
                $array = $record->returnArray();
                $fields = array_keys($array);
                $values = array_values($array);
//                print_r($fields);
//                print_r($values);
                echo "html";
                echo $fields;
                echo $values;
            }
            else{
                $array = $record->returnArray();
                $values = array_values($array);
                print_r($values);
            }
            $count++;
        }
    }
}

class record{
    public function __construct(Array $fieldNames = null, $values = null)
    {
        $record = array_combine($fieldNames, $values);

        foreach ($record as $property => $value) {
            $this->createProperty($property, $value);
        }
    }

    public function returnArray(){
        $array = (array) $this;
        return $array;
    }

    public function createProperty($name = 'first', $value = 'keith')
    {
        $this->{$name} = $value;
    }
}

class system{
    public static function printPage($page){
        echo $page;
    }
}

