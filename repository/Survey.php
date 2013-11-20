<?php
/**
 * Created by PhpStorm.
 * User: Robin
 * Date: 14.11.13
 * Time: 18:36
 */

namespace Repository;

use Entity\Question;

require_once './entity/Question.php';

class Survey {

    private static $questions;

    private static function reloadSurvey(){
        if (!isset(self::$questions)) {
            $questions = file_get_contents('./data/survey.json');
            $questions = json_decode($questions, true);
            foreach($questions as $question){
                self::$questions[] = new Question($question);
            }
        }
        return self::$questions;
    }

    /**
     * @return \Entity\Question[]
     */
    public static function getQuestions(){
        return self::reloadSurvey();
    }
} 