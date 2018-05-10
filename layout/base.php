<?php
/*
 * Developed by: Andres Sandoval Montoya
 * Date: 23/06/2014-10:27:09 AM
 * Contact: andresandoval992@gmail.com
 * 
 * base, part of spt
 */

namespace spt\layout;

class base {

    protected function runPage() {
        \ob_start();
        ?>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="./layout/sources/own/css/images/icons/favicon.png" rel="shortcut icon"/>
        <link href="./layout/sources/apis/jquery-ui-1.10.4.custom/css/black-tie/jquery-ui-1.10.4.custom.css" rel="stylesheet" type="text/css"/>
        <link href="./layout/sources/own/css/style.css"rel="stylesheet" type="text/css"/>        
        <script src="./layout/sources/apis/jquery-ui-1.10.4.custom/js/jquery-1.10.2.js" type="text/javascript"></script>
        <script src="./layout/sources/apis/jquery-ui-1.10.4.custom/js/jquery-ui-1.10.4.custom.js" type="text/javascript"></script>
        <script src="./layout/sources/apis/jquery-form/js/jquery.form.js" type="text/javascript"></script>        
        <script src="./layout/sources/own/js/script.js" type="text/javascript"></script>
        <?php
        return \ob_get_clean();
    }

}
?>