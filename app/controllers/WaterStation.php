<?php

  class WaterStation extends Controller
  {

    public function __construct()
    {
      $this->model = $this->model('WaterStationModel');
    }
    /*SHOW ALL LEGALITIES*/
    public function index()
    {

      $data = [
        'water_station_data' => $this->model->dball()
      ];

      return $this->view('water_station/index' , $data);
    }

    public function create()
    {
      /*
      *Legalities are documents or image
      *and other stuffs
      */

      //only admin can access this
      if(Auth::user_position() != '1')
        return redirect("WaterStation");

      $data = [
        'water_station_data' => $this->model->dball()
      ];

      return $this->view('water_station/create' , $data);
    }

    public function store()
    {
      $pathUpload = PATH_UPLOAD.DS.'water_station';

      $name = request()->input('name');

      $file = upload_file('file' , $pathUpload);

      if($file['status'] == 'failed')
      {
        Flash::set("File upload failed" , 'danger');
        return request()->return();
      }

      $result = $this->model->store([
        'filename' => $file['result']['name'],
        'path'     => $file['result']['path'],
        'name'     => $name
      ]);

      if(!$result) {
        Flash::set("Something went wrong on file uploading.." , 'danger');
        return request()->return();
      }

      Flash::set("Image Saved");

      return redirect("WaterStation/create");
    }

    public function update()
    {

      $file = $_FILES['file'];

      $id = request()->input('id');
      $name = request()->input('name');

      $res = $this->model->dbupdate([
        'name' => $name
      ] , $id);


      /*iF NOT EMPTY FILE THEN UPDATE IMAGE*/
      if(!empty($file['name'])){

        $pathUpload = PATH_UPLOAD.DS.'water_station';

        $file = upload_file('file' , $pathUpload);

        if($file['status'] == 'failed') {
          Flash::set("File upload failed" , 'danger');
          return request()->return();
        }

        $res = $this->model->dbupdate([
          'filename' => $file['result']['name'],
          'path' => $file['result']['path'],
        ], $id);
      }

      if(!$res) {
        Flash::set("Legal update failed" , 'danger');
      }

      return redirect("WaterStation");
    }

    public function edit($id)
    {
      //only admin can access this
      if(Auth::user_position() != '1')
        return redirect("WaterStation");

      $data = [
        'data' => $this->model->dbget($id)
      ];
  

      return $this->view('water_station/edit' , $data);
    }

    public function show($id)
    {
      $data = [
        'data' => $this->model->dbget($id)
      ];

      return $this->view('water_station/show' , $data);
    }
  }
