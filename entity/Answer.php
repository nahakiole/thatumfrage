<?php
/**
 * Created by PhpStorm.
 * User: Robin
 * Date: 19.11.13
 * Time: 16:46
 */

namespace Entity;


class Answer {
    public $userId;
    public $answers = Array();

    public function __toString(){
        return json_encode(array(
                'userid' => $_SESSION['userId'],
                'answers' => $this->answers
            ), true);
    }

    /**
     * @param $question \Entity\Question
     * @param $answer
     */
    public function addAnswer($question,$answer){
        $arrAnswer = array(
            'id' => $question->id,
            'answer' => array(

            )
        );
        switch($question->type){
        case 'radio':
            $arrAnswer['answer'] = $answer;
            break;
        case 'checkbox':
            $arrAnswer['answer'] = $answer;
            break;
        case 'input':
        default:
            $arrAnswer['answer'] = $answer;
            break;
        }
        $this->answers['answer'][] = $arrAnswer;
    }

    public function saveAnswer(){
        $file = file_get_contents('./data/answer.json');
        $answers = json_decode($file, true);
        $answers[] =  $this->__toString();
        var_dump($answers);
        file_put_contents('./data/answer.json',$answers);
    }
} 