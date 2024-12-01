<?php 
    class ImageUploaderController extends Controller
    {
        public function imageCropper() {
            $req = request()->inputs();
            $q = unseal($req['q']);
            $data = [
                'returnURL' => $q['returnURL'] ?? '',
                'userId' => $q['userId'] ?? '',
                'sourceFor' => $q['sourceFor'] ?? '',
                'sourceId'  => $q['sourceId'] ?? ''
            ];
            
            return $this->view('image_uploader/image_cropper', $data);
        }
    }