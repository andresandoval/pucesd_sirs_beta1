<?php

/*
 * Developed by: Andres Sandoval Montoya
 * Date: 23/12/2013, 07:07:17 AM
 * Contact: andresandoval992@gmail.com
 * 
 * eventListener, part of sirs
 */

namespace spt\layout\core;

require_once './layout/core/login.php';
//require_once './layout/core/main.php';
require_once './logic/businessLogic/userBL.php';

use spt\logic\businessLogic;
use spt\layout;

class listener {

    private $control;
    private $tokens;

    public function __construct() {
        $this->tokens = new businessLogic\tokens();

        $token = filter_input(INPUT_POST, 'token', FILTER_DEFAULT);
        if (is_null($token)) {
            $token = filter_input(INPUT_GET, 'token', FILTER_DEFAULT);
        }
        $this->control = new businessLogic\userBL();

        $action = null;
        if ($this->control->isSessionAlive()) {
            if (\is_null($token)) {
                $action = new main();
                $action->runPage();
            } else {
                $this->selectAction($token);
            }
        } elseif ($token == businessLogic\tokens::loginToken()) {
            $action = new businessLogic\userBL();
            $action->login();
        } else {
            $action = new login();
            $action->runPage();
        }
        unset($action);
    }

    private function selectAction($token) {
        switch ($token) {
            case businessLogic\tokens::getSYSTEM_BASIC_LOGOUT():
                $action = new businessLogic\user();
                $action->logOutUser();
                break;
            case businessLogic\tokens::isMainToken($token):
                $action = new layout\core\main();
                $action->getAction($token);
                unset($action);
                break;
            case businessLogic\tokens::isProfileToken($token):
                $action = new layout\user\profile();
                $action->getAction($token);
                unset($action);
                break;
            default :
                echo \json_encode(array('status' => 0, 'content' => 'No se a establecido accesso a la accion solicitada!<br/>No es posible continuar..'));
                break;
        }
    }

}

?>