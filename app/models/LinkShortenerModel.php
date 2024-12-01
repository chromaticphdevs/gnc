<?php 
    class LinkShortenerModel extends Base_model {
        public $table = 'link_shortener';
        public $_fillables = [
            'user_id',
            'shortened_key',
            'redirect_link',
            'visitors'
        ];
        
        public function add($redirectToLink, $key = null, $userId = null) {
            $link = parent::dbget([
                'shortened_key' => $key
            ]);

            if($link) {
                // $this->addError("Link Already Exists.");
                //fetch nalng
                return $link;
            }

            $key = strtoupper(is_null($key) ? get_token_random_char(5) : $key);

            $isOkay = parent::store([
                'redirect_link' => $redirectToLink,
                'shortened_key' => $key,
                'user_id' => $userId
            ]);

            if(!$isOkay) {
                $this->addError("Unable to save link");
                return false;
            }

            return parent::dbget($isOkay);
        }

        public function getShortenedLink($key) {
            return URL.DS.'refer/'.$key;
        }
    }
