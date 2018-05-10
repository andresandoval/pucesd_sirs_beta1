<?php

/*
 * Developed by: Andres Sandoval Montoya
 * Date: 23/06/2014-09:40:17 AM
 * Contact: andresandoval992@gmail.com
 * 
 * userBL, part of spt
 */

namespace spt\logic\businessLogic;

require_once './data/userDA.php';

use spt\data;
use spt\logic\entities;

class userBL {

    private $DA;

    public function __construct() {
        $this->DA = new data\userDA();
    }

    public function isSessionAlive() {
        if (session_start()) {
            if (!isset($_SESSION['started_session'])) {
                session_destroy();
                return false;
            }
            return true;
        }
        return false;
    }

    public function login() {
        /* @var $user entities\userEntity */
        /* @var $userResult entities\userEntity */

        $user = new entities\userEntity();
        $user->postCast();
        $userResult = $this->DA->login($user);

        if (\is_null($userResult)) {
            if ($user->type == 1) { //usuario de tipo consultor
                \session_start();
                $_SESSION['started_session'] = md5((string) session_id());
                $_SESSION['user_new'] = true;
                return \json_encode(array('success' => true, 'content' => "Eres nuevo en el sistema, bienvenido..:)"));
            }
            return \json_encode(array('success' => false, 'content' => 'Error de usuario y/o contraseña!!'));
        }
        \session_start();
        $_SESSION['started_session'] = md5((string) session_id());
        $_SESSION['user_identifier'] = $userResult->identifier;
        $_SESSION['user_type'] = $userResult->type;
        $_SESSION['user_new'] = false;
        return \json_encode(array('success' => true, 'content' => "Bienvenido {$userResult->name}"));
    }

    public function logout() {
        if (\session_status() != \PHP_SESSION_ACTIVE) {
            \session_start();
        }
        if (\session_destroy()) {
            return \json_encode(array('success' => true, 'content' => 'Se ha cerrado sesion correctamente!\nAdios..'));
        }
        return \json_encode(array('success' => true, 'content' => 'Ocurrio un error al intentar cerrar sesión!!'));
    }

    public function getUserById($identifier) {
        /* @var $da data\user\user */

        $da = new data\user\user();
        return $da->getById($identifier);
    }

    public function getLogedUser() {
        /* @var $user entities\user\user */

        $user = $this->getUserById((int) $_SESSION['user_identifier']);
        return (!\is_null($user) && $user->active) ? $user : null;
    }

}

?>