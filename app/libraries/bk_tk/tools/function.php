<?php 

    function load(array $pathOrClass , $path = null)
    {
        if(is_null($path)) {
            foreach($pathOrClass as $key => $row) {
            require_once $row.'.php';
            }
        }else{
            foreach($pathOrClass as $key => $row) {
            require_once $path.'/'.$row.'.php';
            }
        }
    }