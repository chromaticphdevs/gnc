<?php   

    class StreamCommentModel extends Base_model
    {
        private $table_name = 'stream_comments';

        public function make_comment($streamComment)
        {
            extract($streamComment);

            $data = [
                $this->table_name , 
                [
                    'streamid' => $streamid,
                    'userid'   => $userid,
                    'comment'  => $comment
                ]
            ];

            return $this->dbHelper->insert(...$data);
        }

        public function getAll($streamid)
        {
            $this->db->query(
                "SELECT sc.* , DATE_FORMAT(sc.created_at , '%Y %M, %d %h:%i:%s %p') as created_at ,  concat(u.firstname, ' ' , u.lastname) as fullname 
                FROM $this->table_name as sc

                left join users as u on
                u.id = sc.userid
                WHERE sc.streamid = '$streamid'
                order by created_at ASC"
            );

            return $this->db->resultSet('StreamComment');
        }
    }