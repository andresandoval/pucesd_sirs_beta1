<?php

/*
 * Developed by: Andres Sandoval Montoya
 * Date: 12/04/2014-11:48:59 AM
 * Contact: andresandoval992@gmail.com
 * 
 * user, part of sirs
 */
require_once './layout/base.php';

namespace sirs\layout\user;
use sirs\layout;

class user extends layout\base{

    protected function handleForegroundBodyAction($actionTag) {
        switch ($actionTag) {
            case businessLogic\tokens::$SYSTEM_BASIC_MAIN_PAGE:
                return $this->mainPage();
            default:
                return parent::switchPageBodyHandler($actionTag);
        }
    }    

}
?>