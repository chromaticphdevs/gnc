<?php 
	require_once LIBS.DS.'qrcodereader'.DS.'vendor/autoload.php';
	use Libern\QRCodeReader;

	class ToolController extends Controller
	{

		/**
		 * QR CODE SCANNER
		 * */
		public function downloadApp() {
			if(isSubmitted()) {
				$post = request()->posts();
				if(!empty($post['qrValue'])) {
					try{
						$qrValueExtract = unseal($post['qrValue']);
						return header("Location:{$qrValueExtract}");
					}catch(Exception $e) {
						Flash::set("Only breakthrough-e QR-CODE are valid", 'danger');
						return request()->return();
					}

					Flash::set("QR-CODE is required");
					return request()->return();
				}

			}
			$data = [];
			return $this->view('tool/download_app', $data);
		}

		public function fbFriendsList() {
			$data = [
				'appId' => ''
			];
			return $this->view('tool/fb_friend_list', $data);
		}
	}