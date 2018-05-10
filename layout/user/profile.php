<?php
/*
 * Developed by: Andres Sandoval Montoya
 * Date: 21/04/2014-07:00:23 PM
 * Contact: andresandoval992@gmail.com
 * 
 * profile, part of sirs
 */

namespace sirs\layout\user;

require_once './layout/base.php';

use sirs\layout;
use sirs\logic\businessLogic;
use sirs\logic\entities;

class profile extends layout\base {

    private function profileTemplate($identifier = null) {
        /* @var $control businessLogic\user */
        /* @var $action entities\user\action */
        /* @var $profile entities\user\profile */

        $control = new businessLogic\user();

        $actionsArray = $control->getActionsArray($control->getActionsByProfileIdentifier(((int)$identifier)));
        $profile = $control->getProfileById((int) $identifier);
        if (\is_null($profile) && \is_null($identifier)) {
                $profile = new entities\user\profile();
        }
        if (\is_null($profile) || \is_null($actionsArray)){
            exit("Error no controlado : identificador incorrectp o nulo");
        }
        $token = (\is_null($identifier)) ? businessLogic\tokens::getUSER_ADMIN_PROFILES_SAVE_PROFILE() : businessLogic\tokens::getUSER_ADMIN_PROFILES_UPDATE_PROFILE();
        \ob_start();
        ?>
        <div class="html_tab">
            <form id="<?= $token; ?>" action="" method="post" target="_self" post_success="" ajax="true" wait_id="">
                <input type="hidden" name="token" value="<?= $token; ?>"/>
                <input type="hidden" name="identifier" value="<?= $profile->identifier; ?>"/>
                <table class="header">
                    <tbody>	
                        <tr>
                            <th>Nombre :</th>
                            <td><input type="text" name="name" maxlength="32" required="required" autofocus="autofocus" value="<?= $profile->name; ?>"/></td>
                        </tr>
                        <tr>
                            <th>Descripcion :</th>
                            <td><textarea name="description" maxlength="500" required="required"><?= $profile->description; ?></textarea></td>
                        </tr>
                        <tr>
                            <th>Observacion :</th>
                            <td><textarea name="observation" maxlength="500"><?= $profile->observation; ?></textarea></td>
                        </tr>
                    </tbody>
                </table>
                <div style="font-size: 13px; text-align: center; color: #333333; font-weight: bolder; background-color: #cccccc;">Acciones</div>
                <div id="newProfileActionList">
                    <?php
                    if (!\is_null($actionsArray)) {
                        foreach ($actionsArray as $moduleKey => $module) {
                            echo "<h3>$moduleKey</h3><div>";
                            foreach ($module as $groupKey => $group) {
                                echo "<table class='details'><tbody><tr><th rowspan='" . (\count($group) + 1) . "'>$groupKey</th></tr>";
                                foreach ($group as $action) {
                                    $a = $action->profileActive ? 'checked' : '';
                                    echo "<tr><td class='name'>{$action->name}</td><td class='descriprion'>{$action->description}</td><td style='width: 15px;'><input type='checkbox' name='action[]' value='{$action->tag}' {$a}/></td></tr>";
                                }
                                echo '</tbody></table>';
                            }
                            echo "</div>";
                        }
                    }
                    ?>
                </div>
                <hr/>
                <table>
                    <tr>
                        <td><input type ="checkbox" name="active" checked="true"/> Activo</td>
                    </tr>
                </table>
                <hr/>
                <div style="float: right">
                    <button type="submit" class="submit">Aceptar</button>
                    <button type="reset" class="reset">Reiniciar</button>
                    <button type="submit" class="print">Imprimir</button>
                </div>
            </form>
            <script type="text/javascript">
                $(document).ready(function() {
                    $("#newProfileActionList").accordion({
                        heightStyle: "content",
                        collapsible: true
                    });
                    handleAjaxForm("<?= $token; ?>");
                    handleButtonStyles();
                });
            </script>
        </div>
        <?php
        return \ob_get_clean();
    }

    private function processProfile($token) {
        $profile = new entities\user\profile();
        $profile->postCast();
        $actions = \filter_input(\INPUT_POST, 'action', \FILTER_DEFAULT, \FILTER_REQUIRE_ARRAY);
        
        $control = new businessLogic\user();
        $status = '';
        $new = (bool) ($token == businessLogic\tokens::getUSER_ADMIN_PROFILES_SAVE_PROFILE()) ? TRUE : FALSE;
        
        if ($control->validateProfile($profile, $actions, $status, $new)){
            return $new ?  $control->insertProfile($profile, $actions) : $control->updateProfile($profile, $actions);
        }
        return \json_encode(array("success" => false, "content" => "Ocurrio un problema al guardar el registro : $status"));
    }
    
    private function viewResultProfile() {
        /* @var $profile entities\user\profile */
        $parameters = parent::getViewResult();
        $control = new businessLogic\user();
        $profiles = $control->getProfile($parameters['filter'], $parameters['active'], $parameters['limit']);
        $count = (int) 1;
        $content = '';
        if (!\is_null($profiles)) {
            foreach ($profiles as $profile) {
                $mod = $count % 2;
                $content .= "<tr class='row_$mod'>";
                $content .= "<td>$count</td>";
                $content .= "<td>{$profile->name}</td>";
                $content .= "<td>{$profile->description}</td>";
                $content .= "<td>{$profile->observation}</td>";
                $content .= "<td>" . (( (bool) $profile->active) ? 'Si' : 'No') . "</td>";
                $content .= $this->getInnerButton('edit', businessLogic\tokens::getUSER_ADMIN_PROFILES_EDIT_PROFILE(), $profile->identifier);
                $content .= $this->getInnerButton('delete', businessLogic\tokens::getUSER_ADMIN_PROFILES_DELETE_PROFILE(), $profile->identifier);
                $content .= $this->getInnerButton('print', businessLogic\tokens::getUSER_ADMIN_PROFILES_PRINT_PROFILE(), $profile->identifier);
                $content .= '</tr>';
                $count++;
            }
        } else {
            $content = '<tr><td colspan="5">No hay resgistros para mostrar...</td></tr>';
        }
        return \json_encode(array('success' => true, 'content' => $content));
    }

    private function viewProfile() {
        $fields = array('Nombre', 'Descripcion', 'Observacion', 'Activo');
        $tokens = array(
            'new' => businessLogic\tokens::getUSER_ADMIN_PROFILES_NEW_PROFILE(),
            'edit' => businessLogic\tokens::getUSER_ADMIN_PROFILES_EDIT_PROFILE(),
            'result' => businessLogic\tokens::getUSER_ADMIN_PROFILES_VIEW_RESULT_PROFILE(),
            'delete' => businessLogic\tokens::getUSER_ADMIN_PROFILES_DELETE_PROFILE()
        );
        return parent::getViewPage($fields, $tokens);
    }

    private function newProfile() {
        return $this->profileTemplate();
    }

    private function editProfile() {
        return $this->profileTemplate((int) \filter_input(\INPUT_POST, 'value', \FILTER_DEFAULT));
    }

    //private function 

    protected function handleForegroundBodyAction($actionTag) {
        switch ($actionTag) {
            case businessLogic\tokens::getUSER_ADMIN_PROFILES_VIEW_PROFILE():
                return $this->viewProfile();
            case businessLogic\tokens::getUSER_ADMIN_PROFILES_NEW_PROFILE():
                return $this->newProfile();
            case businessLogic\tokens::getUSER_ADMIN_PROFILES_EDIT_PROFILE():
                return $this->editProfile();
        }
        return parent::handleForegroundBodyAction();
    }

    protected function handleBackgroundAction($action) {
        /* @var $action entities\user\action */

        switch ($action->tag) {
            case businessLogic\tokens::getUSER_ADMIN_PROFILES_VIEW_RESULT_PROFILE():
                return $this->viewResultProfile();
            case businessLogic\tokens::getUSER_ADMIN_PROFILES_SAVE_PROFILE() xor businessLogic\tokens::getUSER_ADMIN_PROFILES_UPDATE_PROFILE():
                return $this->processProfile($action->tag);
            default :
                return parent::handleBackgroundAction($action);
        }
        
    }

}
?>