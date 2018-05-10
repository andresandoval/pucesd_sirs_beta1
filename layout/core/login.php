<?php

/*
 * Developed by: Andres Sandoval Montoya
 * Date: 23/06/2014-10:25:38 AM
 * Contact: andresandoval992@gmail.com
 * 
 * login, part of spt
 */

namespace spt\layout\core;

require_once './layout/base.php';
require_once './logic/businessLogic/tokens.php';

use spt\layout;
use spt\logic\businessLogic;

class login extends layout\base{
    
    public function runPage() {
        ?>
        <!DOCTYPE html>
        <html>
            <head>
                <title>SPT - Iniciar sesion</title>
                <?= parent::runPage(); ?>
                <script type="text/javascript">
                    $(document).ready(function() {
                        handleAjaxForm('loginForm');
                    });
                </script>
            </head>
            <body silentclose="true">
                <div id="loginBox" align="center">
                    <form id="loginForm" action="" method="post" target="_self" post_success="window.location.reload();" ajax="true" wait_id="">
                        <input type="hidden" name="token" value="<?= businessLogic\tokens::loginToken(); ?>"/>
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