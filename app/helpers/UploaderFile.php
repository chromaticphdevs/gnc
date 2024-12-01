<?php

  class UploaderFile extends UploaderHelper
  {
    protected $extensions = [
        'csv' , 'docx' , 'pdf' , 'txt',
        'jpeg' ,'jpg' , 'png' , 'pptx',
        'mp4','mp3'
    ];

    public function setFile($name)
    {
      parent::setFile($name);
        return $this;
    }

    /**Override function*/
    public function upload()
    {
        return parent::upload();
    }
  }
