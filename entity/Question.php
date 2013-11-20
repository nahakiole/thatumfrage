<?php
/**
 * Created by PhpStorm.
 * User: Robin
 * Date: 15.11.13
 * Time: 21:02
 */

namespace Entity;


class Question
{
    public $id;
    public $question;
    public $answers = array();
    public $type;
    public $error = false;

    public function __construct($question)
    {
        $this->id = $question['id'];
        $this->question = $question['question'];
        $this->answers = $question['answers'];
        $this->type = $question['type'];
    }

    public function getAnswerHTML()
    {
        $error = true;
        switch ($this->type) {
        case 'radio':
            $html = '';
            foreach ($this->answers as $id => $answer) {
                $checked = '';
                if ($_SESSION['survey'][$this->id] == $id){
                    $checked =  'checked';
                    $error = false;
                }
                $html .= "<label><input value='$id' type='radio' name='survey[$this->id]' $checked/> $answer</label>";
            }
            break;
        case 'checkbox':
            $html = '';
            foreach ($this->answers as $id => $answer) {
                $checked = '';
                if (isset($_SESSION['survey'][$this->id][$id])){
                    $checked =  'checked';
                    $error = false;
                }

                $html .= "<label><input type='checkbox' name='survey[$this->id][$id]' $checked/> $answer</label>";
            }
            break;
        case 'input':
        default:
            $error = empty($_SESSION['survey'][$this->id]);
            $answertext = isset($_SESSION['survey'][$this->id]) ? $_SESSION['survey'][$this->id] : '';
            $html =  "<input type='text' value='$answertext' name='survey[$this->id]'/>";
        }
        $this->error = $error;
        return $html;
    }
} 