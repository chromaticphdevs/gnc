<?php 	
	require_once HELPERS.DS.'StringHelper.php';
	require_once HELPERS.DS.'RequestHelper.php';
	require_once HELPERS.DS.'FormSession.php';

	use Core\Helpers\StringHelper;
	use Core\Helpers\RequestHelper;
	use Core\Helpers\FormSession;


	function redirect($location){
		header("Location:".URL.DS.$location);
	}

	function redirectRaw($location){
		header("Location:".$location);
	}
	
	function get_url($location = null){

		if($location == null) {

			return URL;
		}
		else{
			return URL.DS.$location;
		}
	}

	function get_cur_url() {
		$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		return $actual_link;
	}

	function print_url($location = null){

		if($location == null) {

			echo URL;
		}
		else{
			echo URL.DS.$location;
		}
	}

	function err_404()
	{
		redirect('SystemError/index');
	}

	function FireunAuthorize()
	{
		redirect('SystemError/unAuthorize');
	}

	function FireLoginDBBI(){
		redirect('LDUser/login');
	}
	function logo()
	{	
		/*wala munag logo*/
	}

	function showProfile()
	{
		$img = URL.DS.'assets';//path
		$selfie = null;
		if(Session::check('USERSESSION')) {
			$selfie = Session::get('USERSESSION')['selfie'];
		}
		
		//check if selfie is empty

		if(is_null($selfie)) {
			$img = URL.DS.'uploads/main_user_icon.png';
		}else{
			$img = GET_PATH_UPLOAD.DS.'profile'.DS.$selfie;
		}
		
	
        echo "<a href='/AccountProfile'>
            <img src='".$img."?>' 
                class='img-circle'
            style='width: 40px; height: 40px;'>
        </a>";
	
	}

	function unAuthorize()
	{
		die('You are not authorize');
	}

	function requestInvalid()
	{
		die('Invalid Page Request');
	}


	/******** new tools */

	function validationFailed()
	{
		FormSession::getInstance();

		return header("Location:".request()->referrer());
	}

	function request()
	{
		$request = $_REQUEST;

		$method  = $_SERVER['REQUEST_METHOD'];

		return RequestHelper::getInstance();
	}


	function urlCall($linkName , $parameters = [])
	{
		$link = LINKS[$linkName];

		$parameterString = '';

		if( ! empty($parameters)) {

			$count = 0;

			foreach($parameters as $key => $param) {

				if($count == 0) {
					$parameterString .= '?';
				}else{
					$parameterString .= '&';
				}

				$parameterString.= "{$key}={$param}";

				$count++;
			}
		}

		return $link.$parameterString;
	}

	function _urlCall($linkName , $parameters = [])
	{
		echo urlCall($linkName , $parameters);	
	}
?>