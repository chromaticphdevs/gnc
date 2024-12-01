<?php   

  class PageVisits extends Controller
  {

    public function __construct()
    {
      $this->PageVisitsModel = $this->model('PageVisitsModel');
    }


    public function save_page_visit()
    {

      $this->PageVisitsModel->save_browser_info();

    }

   
}