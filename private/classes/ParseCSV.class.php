<?php

class ParseCSV
{

    private static $delimiter = ',';
    private $filename;
    private $header;
    private $data = [];
    private $row_count = 0;

    public function __construct($filename = '')
    {
        if ($filename != '') {
            $this->file($filename);
        }
    }

    public function file($filename)
    {
        if (!file_exists($filename)) {
            echo "File Not Found.";
            return false;
        } elseif(!is_readable($filename)) {
            echo "File Not Readable.";
            return false;
        }
        $this->filename = $filename;
        return true;
    }

    public function parse()
    {
        if(!isset($this->filename)){
            echo "File Not Set.";
            return false;
        }
        // Clear any previous result
        $this > $this->reset();
        $file = fopen($this->filename, 'r');
        while (!feof($file)) {
            $row = fgetcsv($file, 0, self::$delimiter);
            if ($row == [NULL] || $row === FALSE) {
                continue;
            }
            if (!$this->header) {
                $this->header = $row;
            } else {
                $this->data[] = array_combine($this->header, $row);
                $this->row_count++;
            }
        }
        fclose($file);
        return $this->data;
    }

    public function row_count()
    {
        return $this->row_count;
    }

    private function reset()
    {
        $this->header = null;
        $this->data = [];
        $this->row_count = 0;
    }

    public function last_data(){
        return $this->data;
    }
}

?>
