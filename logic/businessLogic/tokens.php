<?php

/*
 * Developed by: Andres Sandoval Montoya
 * Date: 23/06/2014-10:30:30 AM
 * Contact: andresandoval992@gmail.com
 * 
 * tokens, part of spt
 */

namespace spt\logic\businessLogic;

class tokens {
    
    public static function loginToken(){
        return \md5('__login_user');
    }
    
}

?>