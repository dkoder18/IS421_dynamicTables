<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<?php
/**
 * Created by PhpStorm.
 * User: dhaval
 * Date: 10/4/18
 * Time: 3:32 PM
 */


echo "This is dynamically generating tables project!";

main::start('new.csv');

class main{
    static public function start($filename){
        echo '<p>Filename: ' . $filename . '</p>';
        $records = csv::getRecords($filename);
        $page = html::createTable($records);
        system::printPage($page);
    }
}

class csv{
    static public function getRecords($filename)
    {
        $file = fopen($filename, "r");
        $fieldNames = array();
        $count = 0;
        while (!feof($file)) {
            $record = fgetcsv($file);
            if ($count == 0) {
                $fieldNames = $record;
            } else {
                if (empty($record)) {
                    break;
                }
                $records[] = recordFactory::create($fieldNames, $record);
            }
            $count++;
        }
        fclose($file);
        return $records;
    }
}

class recordFactory{
    public static function create(Array $fieldNames, Array $values){
        $record = new record($fieldNames, $values);
        return $record;
    }
}

class html{

    public static function createTable($records)
    {
        $count = 0;
        foreach($records as $record){
            if($count == 0){
                $array = $record->returnArray();
                $fields = array_keys($array);
                $values = array_values($array);

                $GLOBALS['html'] = '<table class="table">';

                $f = "";
                foreach ($fields as $field){
                    $f .= html::tableField($field);
                }
                $GLOBALS['html'] .= self::tableRow($f);

                $v = "";
                foreach($values as $value){
                    $v .= html::tableValue($value);
                }
                $GLOBALS['html'] .= self::tableRow($v);
            }
            else{
                $array = $record->returnArray();
                $values = array_values($array);

                $v = "";
                foreach($values as $value){
                    $v .= html::tableValue($value);
                }
                $GLOBALS['html'] .= self::tableRow($v);
            }
            $count++;
        }
        echo $GLOBALS['html'];
    }

    static public function tableField($field){
        $html = '<th>' . $field . '</th>';
        return $html;
    }

    static public function tableRow($row){
        $html = '<tr>' . $row . '</tr>';
        return $html;
    }

    static public function tableValue($value){
        $html = '<td>' . $value . '</td>';
        return $html;
    }


}

class record{
    public function __construct(Array $fieldNames, Array $values)
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

    public function createProperty($name = 'field', $value = 'value')
    {
        $this->{$name} = $value;
    }
}

class system{
    public static function printPage($page){
        echo $page;
    }
}


