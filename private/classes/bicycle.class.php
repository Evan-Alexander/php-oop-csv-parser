<?php

    class Bicycle {

      // ----- START OF ACTIVE RECORD CODE ------- //
      static protected $database;

      static public function set_database($database) {
        self::$database = $database;
      }

      static public function find_by_sql($sql) {
        $result = self::$database->query($sql);
        if(!$result) {
          exit("Database query failed.");
        }
        return $result;
      }

      static public function find_all() {
        $sql = "SELECT * FROM bicycles";
        return self::find_by_sql($sql);
      }


      // ----- END OF ACTIVE RECORD CODE ------- //

        public $brand;
        public $model;
        public $year;
        public $category;
        public $color;
        public $description;
        public $gender;
        public $price;
        protected $weight_kg;
        protected $condition_id;

        public const CATEGORIES = ['Road', 'Mtn', 'xCross', 'Cruiser', 'City', 'BMX'];
        public const GENDERS = ['Mens', 'Womans', 'Unisex'];

        protected const CONDITION_OPTIONS = [
            1 => 'Beat up',
            2 => 'Decent',
            3 => 'Good',
            4 => 'Great',
            5 => 'Great',
            6 => 'Like New'
        ];

        public function __construct($args = []) {
            //$this->brand = isset($args['brand']) ? args['brand'] : '';
            // These work the same as the ternary operator statment above
            // PHP 7 Null Coalesce Operator:
            $this->brand = $args['brand'] ?? '';
            $this->model = $args['model'] ?? '';
            $this->year = $args['year'] ?? '';
            $this->category = $args['category'] ?? '';
            $this->color = $args['color'] ?? '';
            $this->description = $args['description'] ?? '';
            $this->gender = $args['gender'] ?? '';
            $this->price = $args['price'] ?? 0;
            $this->weight_kg = $args['weight_kg'] ?? 0.0;
            $this->condition_id = $args['condition_id'] ?? 3;
            // WARNING FOR BELOW: Allows you to access private and protected values and treats them as public i.e. w/ get and set
            // Common pattern to set arguments:
            // Foreach of the arguments that have been passed in
            // Use each one as a key and a value
            // If the property K exists on this instance
            // Then set that K = V
            // foreach($args as $k => $v) {
            //     if(property_exists($this, $k)) {
            //          // dollar sign exists on k here because its a dynamic variable
            //         $this->$k = $v;
            //     }
            // }
        }

        public function weight_kg() {
            return number_format($this->weight_kg, 2) . 'kg';
        }

        public function set_weight_kg($value) {
            $this->weight_kg = floatval($value);
        }

        public function weight_lbs() {
            $weight_lbs = floatval($this->weight_kg) * 2.2046226218;
            return number_format($weight_lbs, 2) . ' lbs';
        }

        public function set_weight_lbs($value) {
            $this->weight_kg = floatval($value) / 2.2046226218;
        }

        public function condition() {
            if($this->condition_id > 0) {
                return self::CONDITION_OPTIONS[$this->condition_id];
            } else {
                return "Unknown";
            }
        }

    }

?>
