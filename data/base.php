<?php

/*
 * Developed by: Andres Sandoval Montoya
 * Date: 23/12/2013, 09:16:10 PM
 * Contact: andresandoval992@gmail.com
 * 
 * base, part of spt
 */

namespace spt\data;

class base {

    private $server = '127.0.0.1:3306';
    private $user = 'root';
    private $password = 'AmaroK';
    private $dbName = 'spt';
    
    private function connect() {
        $mysqliConn = mysqli_connect($this->server, $this->user, $this->password, $this->dbName);
        return $mysqliConn;
    }

    protected function query($query) {
        $conn = $this->connect();
        $result = null;
        if (!is_null($conn)) {
            $result = mysqli_query($conn, $query);            
        }
        mysqli_close($conn);
        return $result;
    }
    
    protected function multiQuery($queries) {
        /*@var $queries array*/
        /*@var $results array*/
        
        $conn = $this->connect();
        $results = array();
        if (!is_null($conn)) {
            foreach ($queries as $query){
                $results[] = mysqli_query($conn, $query);
            }
            if(count($results) == 0){
                $results = null;
            }
        }
        mysqli_close($conn);
        return $results;
    }
    
    protected function cast($result) {
        if (mysqli_num_rows($result) == 0) {
            return false;
        }
        return true;
    }

}

?>
