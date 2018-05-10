<?php
/*
 * Developed by: Andres Sandoval Montoya
 * Date: 04/11/2013, 01:44:52 PM
 * Contact: andresandoval992@gmail.com
 * 
 * main, part of sirs
 */

namespace sirs\layout\core;

require_once './layout/base.php';

use sirs\layout;
use sirs\logic\businessLogic;

class main extends layout\base {

    private $control;
    private $user;
    

    public function __construct() {
        $this->control = new businessLogic\user();
        $this->user = $this->control->getLogedUser();
    }

    public function runPage() {
        ?>
        <!DOCTYPE html>
        <html>
            <head>
                <title title="SIRS">SIRS</title>
                <?php parent::runPage(); ?>
                <script>
                    $(document).ready(function() {                        
                        $("#systemMenu").accordion({
                            heightStyle: "content",
                            collapsible: false
                        });
                    });
                </script>
            </head>
            <body silentclose="true">
                <div id="allForms">
                    <form id="logoutForm" action="" method="post" target="_self" post_success="window.location.reload();" ajax="true" wait_id="">
                        <input type="hidden" name="token" value="<?= businessLogic\tokens::getSYSTEM_BASIC_LOGOUT(); ?>"/>
                    </form>
                </div>
                <div id="userMenu" class="html" style="display: none;">
                    <button type="submit" form="logoutForm">Cerrar sesion</button>
                </div>
                <div id="topPannel">
                    <div id="userContainer">
                        <div id="userName" title="Opciones de usuario" contextmenu="namemenu">
                            <?=\is_null($this->user) ? "<span id='forcedLogOut' info='El usuario actual ya no esta disponible!<br/>La sesion actual se cerrara..'>#Error_1</span>" : '₪ ' . $this->user->name;?>
                        </div>
                    </div>
                </div>
                <div id="bottomPannel">
                    <div id="bottomLeftPannel">
                        <div class="title">Menu principal</div>
                        <div id="systemMenu">
                            <?= $this->control->getUserMenu();?>
                        </div>
                    </div>
                    <div id="bottomRightPannel" class="html">
                        <ul id="tabNames">                            
                        </ul>
                    </div>
                </div>                
            </body>
        </html>
        <?php
    }

    private function mainPage() {
        ob_start();
        ?>
        <div>
            Esta es la pagina principal de SIRS <b><i>(Sistema Integral de Registro y Seguimiento)</i></b>.<br/>
            Mediante el uso de SIRS podras gestionar el manejo y administracion del modo de llevar los casos en en el CCPD :)
        </div>
        <?php
        return ob_get_clean();
    }

    protected function handleForegroundBodyAction($actionTag) {
        switch ($actionTag) {
            case businessLogic\tokens::getSYSTEM_BASIC_START_PAGE():
                return $this->mainPage();
        }
        return parent::switchPageBodyHandler();
    }

}
?>

