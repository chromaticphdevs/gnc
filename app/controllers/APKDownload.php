<?php 	

	class APKDownload extends Controller
	{

		public function download()
		{
			$file = PUBLIC_ROOT.DS.'uploads/apk_file/app-release.zip';



            if(!file_exists($file)){ // file does not exist

                die('file not found');

            } else {

                header("Cache-Control: public");

                header("Content-Description: File Transfer");

                header("Content-Disposition: attachment; filename=$file");

                header("Content-Type: application/zip");

                header("Content-Transfer-Encoding: binary");

            

                // read the file from disk

                readfile($file);


                return request()->return();
            }
		}

		public function index()
		{
			if(isset($_POST['download'])) {

				//run download

	            $file = PUBLIC_ROOT.DS.'uploads/apk_file/app-release.zip';



	            if(!file_exists($file)){ // file does not exist

	                die('file not found');

	            } else {

	                header("Cache-Control: public");

	                header("Content-Description: File Transfer");

	                header("Content-Disposition: attachment; filename=$file");

	                header("Content-Type: application/zip");

	                header("Content-Transfer-Encoding: binary");

	            

	                // read the file from disk

	                readfile($file);

	            }
			}


			return $this->view('apk/download');
		}
	}