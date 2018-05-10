<?php

/*
 * Developed by: Andres Sandoval Montoya
 * Date: 23/06/2014-09:44:08 AM
 * Contact: andresandoval992@gmail.com
 * 
 * userEntity, part of spt
 */

namespace spt\logic\entities;

class userEntity {

    public $identifier;
    public $type;
    public $name;
    public $lastName;
    public $query;
    public $queryDate;
    public $password;

    public function postCast() {
        $this->identifier = \trim((string) \filter_input(\INPUT_POST, 'identifier', \FILTER_DEFAULT));
        $this->type = (int) \filter_input(\INPUT_POST, 'type', \FILTER_DEFAULT);
        $this->name = \trim((string) \filter_input(\INPUT_POST, 'name', \FILTER_DEFAULT));
        $this->lastName = \trim((string) \filter_input(\INPUT_POST, 'lastName', \FILTER_DEFAULT));
        $this->query = (int) \filter_input(\INPUT_POST, 'query', \FILTER_DEFAULT);
        $this->queryDate = \trim((string) \filter_input(\INPUT_POST, 'queryDate', \FILTER_DEFAULT));
        $this->password = \trim((string) \filter_input(\INPUT_POST, 'password', \FILTER_DEFAULT));
    }

}

?>