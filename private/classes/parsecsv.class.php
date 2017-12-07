<?php

    class ParseCSV {

        public static $delimiter = ',';
        // Removes the ability to set the filename
        private $filename;
        private $header;
        private $data = [];
        private $row_count = 0;

        public function __construct($filename='') {
            if($filename != '') {
                $this->file($filename);
            }
        }

        public function file($filename) {
            if(!file_exists($filename)) {
                echo "File does not exist.";
                return false;
            }
            elseif(!is_readable($filename)) {
                echo "File is not readable.";
                return false;
            }
            $this->filename = $filename;
            return true;
        }

        public function parse() {
            if(!isset($this->filename)) {
                echo "File not set.";
                return false;
            }
        // Clear any previous results
            $this->reset();
            $file = fopen($this->filename, 'r');
            while(!feof($file)) {
                $row = fgetcsv($file, 0, self::$delimiter);
                if($row == [NULL] || $row === FALSE) { continue; }
                if(!$this->header) {
                    $this->header = $row;
                } else {
                    $this->data[] = array_combine($this->header, $row);
                    $this->row_count++;
                }
            }
            fclose($file);

            return $this->data;
        }

        // Reader function to display last results
        public function last_results() {
            return $this->data;
        }

        // makes row_count variable read-only
        public function row_count() {
            return $this->row_count;
        }
        // If we were to use the parse() more than once in a project,
        // it would add the data on top of the previously allocated data
        // reset() prevents against this.
        private function reset() {
            $this->header = NULL;
            $this->data = [];
            $this->row_count = 0;
        }
    }



?>
