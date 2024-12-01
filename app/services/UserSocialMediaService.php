<?php
    namespace Services;

    class UserSocialMediaService  {
        
        const FACEBOOK = 'Facebook';
        const INSTAGRAM = 'Instagram';
        const TWITTER = 'Twitter';
        const TELEGRAM = 'Telegram';
        const WHATSAPP = 'Whatsapp';
        const TIKTOK = 'Tiktok';
        const MESSENGER = 'Messenger';


        public function getTypes() {
            return [self::FACEBOOK, self::INSTAGRAM, self::TWITTER, self::TELEGRAM, self::WHATSAPP, self::TIKTOK, self::MESSENGER];
        }
    }