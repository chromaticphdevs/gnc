<?php

  class API_Binary extends Controller
  {

    public function __construct()
    {
      $this->userGeneology = $this->model('UserGeneologyModel');
    }

    public function getDownlines()
    {
      $this->userGeneology->getDownlines($userid);
    }

    public function getBulkDownlines()
    {

    }
  }
