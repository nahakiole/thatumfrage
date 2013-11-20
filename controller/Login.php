<?php
/**
 * Created by PhpStorm.
 * User: robin.glauser@gmail.com
 * Date: 29.10.13
 * Time: 11:08
 */

namespace Controller;


use Library\Logger;

require_once './controller/Page.php';
require_once './repository/User.php';
require_once './lib/Bootstrap.php';
class Login extends Page {

    public function getPage(){
        $this->pageTheme = 'login.html';
        if(isset($_POST['login'])){
            try  {
                $user = \Repository\User::checkUser($_POST['login']['username'],$_POST['login']['password']);
            }
            catch (\Repository\UserExceptionWrongPassword $e){
                $this->setVariable('LOGIN_ERROR', \Library\Bootstrap::getAlert($e->getMessage(),'danger'));
                $this->setVariable('LOGIN_USERNAME', $_POST['login']['username']);

            }
            catch (\Repository\UserExceptionNotFound $e){
                $user = \Repository\User::createUser($_POST['login']['username'],$_POST['login']['password']);
            }
            catch (\Repository\UserExceptionNoUsernameGiven $e){
                $this->setVariable('LOGIN_ERROR', \Library\Bootstrap::getAlert($e->getMessage(),'danger'));
            }
            if (isset($user)){
                $_SESSION['userId'] = $user->id;
            }
        }
    }


} 