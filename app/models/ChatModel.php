<?php 
    class ChatModel extends Base_model
    {
        public function addNewOneToOneMessaage($recipientId, $senderId, $message) {
            $this->db->query(
                "CALL sendMessageOneToOne({$recipientId}, {$senderId}, '{$message}')"
            );
            return $this->db->execute();
        }

        public function getOneOnOneMessage($senderId, $recipientId) {
            $this->db->query(
                "SELECT * FROM x_chat_one_to_one
                    WHERE (
                        sender_id = '{$senderId}'
                        AND recipient_id = '{$recipientId}'
                    ) OR (
                        recipient_id = '{$senderId}'
                        AND sender_id = '{$recipientId}'
                    )
                    ORDER BY created_at asc"
            );
            return $this->db->resultSet();
        }

        public function addNewGroup($userId, $title) {
            $newGroupId = $this->dbHelper->insert('x_chat_sessions', [
                'title' => $title,
                'admin_id' => $userId,
                'date' => today(),
                'is_gc' => true
            ]);

            if($newGroupId) {
                $this->addGroupMember($newGroupId, $userId, $userId);
                return $newGroupId;
            } else {
                return false;
            }
        }

        public function addGroupMember($groupId, $memberId, $addedBy) {
            //check if user already exists
            $userExist = $this->dbHelper->resultSet('x_chat_members', '*', parent::convertWhere([
                'gc_id' => $groupId,
                'mem_id' => $memberId,
            ]));

            if($userExist) {
                $this->addError("User already exist.");
                return false;
            } else {
                return $this->dbHelper->insert('x_chat_members', [
                    'gc_id' => $groupId,
                    'mem_id' => $memberId,
                    'added_by' => $addedBy
                ]);
            }
        }

        /**
         * get user groups
         */
        public function getUserGroups($userId) {
            $this->db->query(
                "SELECT x_ses.*,
                    x_mem.added_by,
                    x_mem.mem_id
                    FROM x_chat_sessions as x_ses
                    LEFT JOIN x_chat_members as x_mem
                        ON x_mem.gc_id = x_ses.id
                    WHERE mem_id = '{$userId}' "
            );

            return $this->db->resultSet();
        }


        public function getGroup($id) {
            $this->db->query(
                "SELECT x_ses.*, concat(user.firstname, ' ', user.lastname) as admin_fullname 
                    FROM x_chat_sessions as x_ses
                    LEFT JOIN users as user
                        ON user.id = x_ses.admin_id"
            );
            return $this->db->single();
        }

        public function getGroupChatMessages($groupId) {
            $this->db->query("SELECT x_cgm.*, 
                concat(user.firstname,' ',user.lastname) as sender_fullname,
                user.firstname as sender_firstname,
                user.lastname as sender_lastname,
                user.selfie
                FROM x_chat_group_messages as x_cgm
                LEFT JOIN users as user 
                    ON user.id = x_cgm.sender_id
                WHERE gc_id = '{$groupId}' ORDER BY id asc");
            return $this->db->resultSet();
        } 

        public function getMembers($groupId) {
            $this->db->query(
                "SELECT x_mem.*, user.username,
                    user.firstname, user.lastname,
                    selfie, CONCAT(user.firstname, ' ', user.lastname) as fullname
                    FROM x_chat_members as x_mem
                        INNER JOIN users as user
                        ON x_mem.mem_id = user.id
                    WHERE x_mem.gc_id = '{$groupId}' "
            );

            return $this->db->resultSet();
        }

        public function removeGroupMember($id) {
            $this->dbHelper->delete('x_chat_members', parent::convertWhere([
                'id' => $id
            ]));
        }
        
        public function addNewGroupMessage($gcId, $senderId, $chat, $link = false, $isAttachment = false, $replyTo = false) {

            return $this->dbHelper->insert('x_chat_group_messages', [
                'gc_id' => $gcId,
                'sender_id' => $senderId,
                'chat' => $chat,
                'link' => $link,
                'is_attachment' => $isAttachment,
                'reply_to' => $replyTo,
                'created_at' => today()
            ]);
        }
    }