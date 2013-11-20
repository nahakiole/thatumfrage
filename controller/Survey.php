<?php
/**
 * Created by PhpStorm.
 * User: robin.glauser@gmail.com
 * Date: 29.10.13
 * Time: 11:08
 */

namespace Controller;

require_once './repository/Survey.php';
require_once './controller/Page.php';
require_once './entity/Answer.php';

/**
 * Class Survey
 *
 * @package Controller
 */
class Survey extends Page {

    private $completed = true;


    public function getPage()
    {
        $this->pageTheme = 'survey.html';
        if (isset($_POST['survey'])){
            $_SESSION['survey'] = null;
            $_SESSION['survey'] = $_POST['survey'];
        }
        $this->setVariable('QUESTIONS', self::renderQuestions());
        if ($this->completed){
            $questions = \Repository\Survey::getQuestions();
            $answer = new \Entity\Answer();
            foreach ($questions as $question){
                $answer->addAnswer($question,$_SESSION['survey'][$question->id]);
            }
            $answer->saveAnswer();
            $_SESSION['complete'] = 1;
            header('Location: /Finished');
        }
    }

    /**
     * @var \Entity\Question $question
     * @return string
     */
    public function renderQuestions(){
        /**
        * @var \Entity\Question $question
        */
        $questions = \Repository\Survey::getQuestions();
        $template = file_get_contents('./view/'.Template::$theme.'/question.html');

        foreach($questions as $key => $question){
            $renderedQuestions[$key] = $template;
            $renderedQuestions[$key] = str_replace('[[SURVEY_QUESTION_NAME]]',$question->question,$renderedQuestions[$key]);
            $renderedQuestions[$key] = str_replace('[[SURVEY_QUESTION_ANSWERS]]',$question->getAnswerHTML(),$renderedQuestions[$key]);

            if ($question->error && isset($_SESSION['survey'])){
                $this->completed = false;
                $renderedQuestions[$key] = str_replace('[[SURVEY_ERROR]]', \Library\Bootstrap::getAlert('Bitte fülle alle Felder aus.'),$renderedQuestions[$key]);
                $renderedQuestions[$key] = str_replace('[[SURVEY_QUESTION_ERROR]]',$question->error ? 'has-error' : '',$renderedQuestions[$key]);
            }

        }
        if (!isset($_SESSION['survey'])){
            $this->completed = false;
        }
        return join('', $renderedQuestions);
    }

}