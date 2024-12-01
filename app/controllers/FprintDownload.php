<?php 	

	class FprintDownload extends Controller
	{

		public function index()
		{
			$file = PUBLIC_ROOT.DS.'uploads/sqlite_db/user_login_info.sqlite';



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


		public function changeCommand($command)
		{	
			$commandStatus = $this->readCommand();

			if(!isEqual($commandStatus,$command))
			{
				$myfile = fopen("command.txt", "w") or die("Unable to open file!");
				fwrite($myfile, $command);
				fclose($myfile);	
			}

			return request()->return();		
		}


		public function readCommand()
		{	
			$command = "";
			$myfile = fopen("command.txt", "r") or die("Unable to open file!");
			
			$command = fread($myfile,filesize("command.txt"));


			fclose($myfile);

			echo $command;
		}
		
	}