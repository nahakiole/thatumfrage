<?php
/**
 * Created by PhpStorm.
 * User: robin.glauser@gmail.com
 * Date: 29.10.13
 * Time: 11:16
 */

namespace Model;


class User
{

    private $authenticated;
    private $hasCompletedSurvey;

    public function __construct()
    {
        $id = isset($_SESSION['userId']) ? $_SESSION['userId'] : null;
        if (!isset($id)) {
            $this->authenticated = false;
        } else {
            $this->authenticated = true;
        }
        $complete = isset($_SESSION['complete']) ? $_SESSION['complete'] : null;
        if (!isset($complete)) {
            $this->hasCompletedSurvey = false;
        } else {
            $this->hasCompletedSurvey = true;
        }
    }

    /**
     * @return boolean
     */
    public function isAuthenticated()
    {
        return $this->authenticated;
    }

    public function Authenticate()
    {
        $this->authenticated = true;
        return $this->authenticated;
    }

    public function hasCompletedSurvey()
    {
        return $this->hasCompletedSurvey;
    }

    public function completedSurvey()
    {
        $this->hasCompletedSurvey = true;
        return $this->hasCompletedSurvey;
    }

} 