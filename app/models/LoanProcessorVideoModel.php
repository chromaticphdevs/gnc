<?php 
    class LoanProcessorVideoModel extends Base_model {
        public $table = 'loan_processor_videos';
        public $_fillables = [
            'loan_processor_id',
            'beneficiary_id',
            'video_file'
        ];

        public function add($processorId, $beneficiaryId, $videoFile) {
            $isExists = parent::dbget([
                'loan_processor_id' => $processorId,
                'beneficiary_id' => $beneficiaryId,
                'video_file'  => $videoFile
            ]);

            if($isExists) {
                $this->addError("Video is already uploaded for this user");
                return false;
            }

            $storedId =  parent::store([
                'loan_processor_id' => $processorId,
                'beneficiary_id' => $beneficiaryId,
                'video_file'  => $videoFile
            ]);

            return $storedId;
        }

        public function getAll($params = []) {
            $where = null;
            $order = null;
            $limit = null;

            if(!empty($params['where'])) {
				$where = " WHERE ".parent::convertWhere($params['where']);
			}

			if(!empty($params['order'])) {
				$order = " ORDER BY {$params['order']}";
			}

			if(!empty($params['limit'])) {
				$limit = " LIMIT {$params['limit']}";
			}

            $this->db->query(
                "SELECT user.*, 
					concat(user.firstname, ' ', user.lastname) as fullname,
					concat(loan_processor.firstname, ' ', loan_processor.lastname) as loan_processor_fullname,
					user_social_media.link as fb_link,
					lp_video.video_file as video_file,
					lp_video.id as lp_id

					FROM users as user 
					LEFT JOIN users as loan_processor
						ON user.loan_processor_id = loan_processor.id

					LEFT JOIN user_social_media
						on user.id = user_social_media.userid
						AND user_social_media.type = 'facebook'

					LEFT JOIN {$this->table} as lp_video
						ON lp_video.beneficiary_id = user.id
						AND lp_video.loan_processor_id = user.loan_processor_id
					{$where} {$order} {$limit}"
            );
            
            return $this->db->resultSet();
        }

        public function get($params = []) {
            return $this->getAll($params)[0] ?? false;
        }
    }