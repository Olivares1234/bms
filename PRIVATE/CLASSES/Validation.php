<?php
    class Validation {
        /**
         * Author : Jasper Diongco
         * This my simple class for validation
         * This is open source and you can use it in your project
         * 
         *  How to use:
         *  1. instantiate this class
         *  -> $validation = new Validation();
         * 
         *  2. use the validate method and pass the fields and rules
         *  -> $data = [
         *      "name" => "John"
         *      "email" => "john@gmail.com"
         *      ];
         *  -> $validation->validate($data, [
         *          "name" => "required",
         *          "email" => "required|email"
         *      ]);
         * 
         *  3. use the getErrors to get the validation errors
         *  -> $errors = $validation->getErrors();
         *  // that's it :) so easy!
         * 
         *  //the $errors variable now contains associative array
         *  //the key is the field and the value is the error
         *  // example : ["name" => "The name field is required", "email" => "The email field must be a valid email"]
         * 
         * you can add your custom rules as you want
         * 
         */

        private $errors = [];
        private $data;

        public function getErrors() {
            return $this->errors;
        }

        /**
         * Here is the list of rules
         */

        // "field" => "required"
        public function required($key, $value) {
            if(empty(trim($value))) {
                $this->errors[$key] = 'The ' . $key . ' field is required.'; 
                return false;
            }
            return true;
        }

        // "field" => "email"
        public function email($key,$value) {
            $email_regex = '/\A[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}\Z/i';
            if(!preg_match($email_regex, $value)) {
                $this->errors[$key] = 'The '. $key .' field must be a valid email.';
                return false;
            }
            return true;
        }

        // "field" => "minlen:5"
        public function minlen($key,$value,$params) {
            if(!(strlen(trim($value)) >= $params)) {
                $this->errors[$key] = 'The '. $key .' field must be at least ' . $params . ' characters.';
                return false;
            }
            return true;
        }

        // "field" => "maxlen:10"
        public function maxlen($key,$value,$params) {
            if(strlen(trim($value)) > $params) {
                $this->errors[$key] = 'The '. $key .' field may not be greater than ' . $params . ' characters.';
                return false;
            }
            return true;
        }

        // "field" => "len_between:5,10"
        public function len_between($key,$value,$params) {
            /**
             * This method assumes that params should have 2 value
             * for example 5,10
             * we will explode it and make it array => [5,10]
             */
            $params = explode(",", $params);
            if(!(strlen($value) > $params[0] && strlen($value) < $params[1])) {
                $this->errors[$key] = 'The '. $key .' field must be between '. $params[0] .' and '. $params[1] .'.';
                return false;
            }
            return true;

        }

        // "confirm_password" => "confirm:password"
        public function confirm($key,$value,$params) {
            if($value != $this->data[$params]) {
                $this->errors[$key] = 'The '. $params .' confirmation does not match.';
                return false;
            }
            return true;
        }


        /**
         * This is the core validation
         */
        public function validate($data, $rules) {

            $this->data = $data;

            foreach($rules as $field => $rule_str) {

                $rules_arr = explode('|', $rule_str);// rule1|rule2|rule3 -> ["rule1","rule2","rule3"]

                foreach($rules_arr as $rule) {
                    //check if has parameter
                    if(preg_match('/:/', $rule)) {
                        $rule_with_params = explode(':', $rule);
                        //get the rule which is the first element
                        $rule = $rule_with_params[0];

                        //get the second element, this will be the params
                        $params = $rule_with_params[1];
                        
                        //test the field if valid
                        $is_valid = $this->$rule($field, $data[$field],$params);

                        //break the loop if not valid
                        if(!$is_valid) {
                            break;
                        }
                    } else {
                        //test the field if valid
                        $is_valid = $this->$rule($field, $data[$field]);

                         //break the loop if not valid
                        if(!$is_valid) {
                            break;
                        }
                    }

                    
                }
            }
        }   
    }