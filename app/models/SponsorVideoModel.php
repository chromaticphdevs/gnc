<?php 
    /**
     * video link folder is
     * public/assets/user_videos
     */
    class SponsorVideoModel extends Base_model
    {
        public $table = 'sponsor_videos';
        public $_fillables = [
            'sponsor_id',
            'beneficiary_id',
            'video_file'
        ];

        public function add($sponsorId, $beneficiaryId, $videoFile) {
            $isExists = parent::dbget([
                'sponsor_id' => $sponsorId,
                'beneficiary_id' => $beneficiaryId,
                'video_file'  => $videoFile
            ]);

            if($isExists) {
                $this->addError("Video is already uploaded for this user");
                return false;
            }

            $storedId =  parent::store([
                'sponsor_id' => $sponsorId,
                'beneficiary_id' => $beneficiaryId,
                'video_file'  => $videoFile
            ]);

            return $storedId;
        }
    }