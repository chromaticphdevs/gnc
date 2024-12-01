<?php
    function occupy($viewPath = 'templates/layout')
    {
        $viewPath = convertDotToDS($viewPath);
        require_once VIEWS.DS.$viewPath.'.php';
    }

    function endExtend(){

    }


    function combine($viewPath)
    {
        $viewPath = convertDotToDS($viewPath);

        $file = VIEWS.DS.$viewPath.'.php';
        if(file_exists($file)){
            require_once $file;
        }else{
            die(" NO FILE FOUND ");
        }

    }

    function grab($viewPath , $data = null)
    {
        $viewPath = convertDotToDS($viewPath);

        if(!is_null($data)){
          extract($data);
        }

        $viewPath = convertDotToDS($viewPath);

        require_once VIEWS.DS.$viewPath.'.php';

    }


    function build($buildName)
    {
        Render::$buildInstance++;
        Render::addBuild($buildName);

        ob_start();
    }


    function endbuild()
    {
        Render::$buildInstance;
        Render::build(ob_get_contents());

        ob_end_clean();
    }

    function section($section)
    {
        $_GLOBALS[$section] = " TEST ";
    }


    function endsection(){

    }

    function produce($varName)
    {
        Render::show($varName);
    }

    function convertDotToDS($path)
    {
        return str_replace('.' , DS , $path);
    }
