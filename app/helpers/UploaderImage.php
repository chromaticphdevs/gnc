<?php
    class UploaderImage extends UploaderHelper
    {
        protected $extensions = [
            'jpeg' , 'jpg' , 'png' , 'bitmap'
        ];

        public function setImage($name)
        {
            $this->setFile($name);
            return $this;
        }

        /**Override function*/
        public function upload()
        {
            return parent::upload();
        }
    }
