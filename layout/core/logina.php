<?php
/*
 * Developed by: Andres Sandoval Montoya
 * Date: 04/11/2013, 01:41:31 PM
 * Contact: andresandoval992@gmail.com
 * 
 * login, part of sirs
 */

namespace stp\layout\core;

require_once './logic/businessLogic/user.php';
require_once './layout/base.php';

use sirs\logic;
use sirs\layout;

class login extends layout\base {

    public function runPage() {
        ?>
        <!DOCTYPE html>
        <html>
            <head>
                <title>SIRS - Iniciar sesion</title>
                <?php parent::runPage(); ?>
                <script type="text/javascript">
                    $(document).ready(function() {
                        handleAjaxForm('loginForm');
                    });
                </script>
            </head>
            <body silentclose="true">
                <div id="loginBox" align="center">
                    <form id="loginForm" action="" method="post" target="_self" post_success="window.location.reload();" ajax="true" wait_id="">
                        <input type="hidden" name="token" value="<?= businessLogic\tokens::getSYSTEM_BASIC_LOGIN(); ?>"/>
                        <table>
                            <tr>
                                <td><div class="userImg"></div></td>
                                <td><input type="text" name="login" value="" placeholder="Login" maxlength="32" autocomplete="off" required="required" title="Login de usuario" autofocus/></td>
                            </tr>
                            <tr>
                                <td><div class="passImg"></div></td>
                                <td><input type="password" name="password" value="" placeholder="Contraseña" autocomplete="off" required="required" title="Contraseña de usuario"/></td>
                            </tr>
                            <tr>
                                <td colspan="2" align="right">
                                    <button type="submit" class="submit">Entrar</button>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>

            </body>
        </html>
        <?php
    }

}
?>