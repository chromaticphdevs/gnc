<?php namespace BKTK;

    use BKTK\Base;

    require_once __DIR__.'/Base.php';

    class Wallet extends Base
    {
        protected $controller = 'wallet';

        public function getAll()
        {
            return $this->fetch('getUsersWallet');
        }
        
    }