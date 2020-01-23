<?php

function Autoload_Core_Aplication( $class ){
    $Archivo_Clase = APP_PATH . ucfirst(strtolower($class)) . '.php';


    if(file_exists( $Archivo_Clase  )){
        include_once $Archivo_Clase ;
    }
}

function autoloadLibs ( $class ){
    if(file_exists(ROOT . 'libs' . DS . 'class.' . strtolower($class) . '.php')){
        include_once ROOT . 'libs' . DS . 'class.' . strtolower($class) . '.php';
    }
}

//spl_autoload_register("Autoload_Core_Aplication");
//spl_autoload_register("autoloadLibs");

?>
