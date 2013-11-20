<?php
namespace Controller;
require_once './model/User.php';
require_once './controller/Login.php';
require_once './controller/Template.php';
require_once './controller/Survey.php';
require_once './controller/Page.php';
require_once './controller/Finished.php';

class Request
{
    private $userModel;
    private $page;
    public  $templateController;

    public function __construct()
    {

        $this->templateController = new Template();
        $this->userModel = new \Model\User();
        if ($_SERVER['REDIRECT_URL'] == '/Logout') {
            $_SESSION['userId'] = null;
            $_SESSION['survey'] = null;
            header('Location: /Login');
        }
        if (!$this->userModel->isAuthenticated())  {
            if ($_SERVER['REDIRECT_URL'] != '/Login') {
                header('Location: /Login');
            }
            $this->page = new Login();
        }
        elseif (!$this->userModel->hasCompletedSurvey()) {
            if ($_SERVER['REDIRECT_URL'] != '/Survey') {
                header('Location: /Survey');
            }
            $this->page = new Survey();
        }
        else {
            if ($_SERVER['REDIRECT_URL'] != '/Finished') {
                header('Location: /Finished');
            }

//            $this->page = new Survey();
            $this->page = new Finished();
        }
        $this->page->getPage();
        $this->templateController->setPageTheme($this->page->pageTheme);
        $this->templateController->pageVariables = $this->page->variables;
        echo $this->templateController->render();
    }
}