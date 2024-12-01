drop PROCEDURE if exists sendMessageOneToOne;
DELIMITER $$
CREATE PROCEDURE sendMessageOneToOne(IN senderId int(10), IN recipientId int(10), IN message text)
    BEGIN
        DECLARE connectionExist boolean default false;

        if (TRUE) THEN
            CALL addConnection(senderId, recipientId, '2024-03-08 12:30:pm');
        end if;
            CALL addChatOneToOne(senderId, recipientId, message);
    END $$
DELIMITER ;


DROP PROCEDURE fetchConnection;
DELIMITER $$
CREATE PROCEDURE fetchConnection(IN senderId int(10), IN recipientId int(10))
        BEGIN
            DECLARE connectionExist boolean default false;
            SELECT if(id = null, false, true) INTO connectionExist from x_chat_connection
                WHERE 
                    parent_id = senderId
                    AND child_id = child_id;
        END $$
DELIMITER ;

DROP PROCEDURE addConnection;
DELIMITER $$
CREATE PROCEDURE addConnection(IN senderId int(10), IN recipientId int(10), IN dateandtime datetime)
        BEGIN
            DECLARE response boolean default true;
            DECLARE uuid text;

            SET uuid = UUID();
                INSERT INTO x_chat_connection(parent_id, child_id,updated_at,connection_key)
                    VALUES(senderId, recipientId, dateandtime,uuid);

                INSERT INTO x_chat_connection(parent_id, child_id,updated_at, connection_key)
                    VALUES(recipientId, senderId, dateandtime,uuid);
        END $$
DELIMITER ;

DROP PROCEDURE addChatOneToOne;
DELIMITER $$
CREATE PROCEDURE addChatOneToOne(IN senderId int(10), IN recipientId int(10), IN message text)
        BEGIN
            DECLARE response boolean default true;
                INSERT INTO x_chat_one_to_one(sender_id, recipient_id, chat)
                    VALUES(senderId, recipientId, message);
        END $$
DELIMITER ;



CALL sendMessageOneToOne(1,3,'test');