<?php

/*
 * Developed by: Andres Sandoval Montoya
 * Date: 21/06/2014-10:31:41 PM
 * Contact: andresandoval992@gmail.com
 * 
 * userDA, part of spt
 */
namespace spt\data;

include_once './data/base.php';
include_once './logic/entities/userEntity.php';

use spt\logic\entities;

class userDA extends base {

    public function login($user) {
        /* @var $user entities\userEntity */

        $result = $this->query("call loginUser('{$user->identifier}', '$user->password')");

        if (\mysqli_num_rows($result) == 1) {
            \session_start();
            $_SESSION['started_session'] = \md5((string) session_id());
            $_SESSION['user_identifier'] = \mysql_result($result, 0, 'identifier');

            $jsonResult['success'] = (bool) true;
            $jsonResult['content'] = (string) "Login exitoso!<br/>Bienvenido {$userResult->name}..";
        }
    }

    protected function cast($result) {
        /* @var $ent entites\userEntity */
        
        if (parent::cast($result)) {
            $ents = array();
            $ent = null;
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $ent = new entities\userEntity();
                $ent->identifier = \trim((string) $row['identifier']);
                $ent->type = (int) $row['type'];
                $ent->name = \trim((string) $row['name']);
                $ent->lastName = \trim((string) $row['lastName']);
                $ent->query = (int) $row['query'];
                $ent->queryDate = \trim((string) $row['queryDate']);
                $ent->password = \trim((string) $row['password']);
                $ents[] = $ent;
            }
            return $ents;
        }
        return null;
    }

}

?>