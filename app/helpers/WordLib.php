<?php 

    class WordLib {

        static $init = null;

        public static function get($key) {
            if(is_null(self::$init)) {
                self::$init = _wordLib();
            }

            return self::$init[$key];
        }
    }