<?php

namespace Elpr\User;

use Anax\DatabaseActiveRecord\ActiveRecordModel;
use Elpr\Question\Qcomment;
use Elpr\Question\Question;
use Elpr\Answer\Answer;
use Elpr\Answer\Acomment;

/**
 * A database driven model.
 */

class User extends ActiveRecordModel
{

    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "User";

    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $name;
    public $password;
    public $tel;
    public $email;
    public $birthdate;
    public $image;
    public $score;
    public $created;
    public $updated;
    public $deleted;
    public $active;
    public $votes;

    /**
     * Set the password.
     *
     * @param string $password the password to use.
     *
     * @return void
     */
    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Verify the email and the password, if successful the object contains
     * all details from the database row.
     *
     * @param string $email  email to check.
     * @param string $password the password to use.
     *
     * @return boolean true if email and password matches, else false.
     */
    public function verifyPassword($email, $password)
    {
        $this->find("email", $email);
        return password_verify($password, $this->password);
    }

    /**
     * Update score.
     *
     * @param integer $userId.
     * @param integer $score.
     *
     * @return void
     */
    public function updateScore($userId, $score)
    {
        $this->findById($userId);
        $this->score += $score;

    }

    /**
     * Get either a Gravatar URL or complete image tag for a specified email address.
     *
     * @param string $email The email address
     * @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
     * @param string $d Default imageset to use [ 404 | mp | identicon | monsterid | wavatar ]
     * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
     * @param boole $img True to return a complete IMG tag False for just the URL
     * @param array $atts Optional, additional key/value attributes to include in the IMG tag
     * @return String containing either just a URL or a complete image tag
     * @source https://gravatar.com/site/implement/images/php/
     */
    function gravatar($email, $s = 250, $d = 'monsterid', $r = 'g', $img = false, $atts = array())
    {
        $url = 'https://www.gravatar.com/avatar/';
        $url .= md5(strtolower(trim($email)));
        $url .= "?s=$s&d=$d&r=$r";
        if ($img) {
            $url = '<img src="' . $url . '"';
            foreach ($atts as $key => $val)
                $url .= ' ' . $key . '="' . $val . '"';
            $url .= ' />';
        }
        $this->image = $url;
    }

    /**
     * Calculate activity score.
     *
     * @param object $di 
     *
     * @return void
     */
    public function activityScore($di)
    {
        $question = new Question();
        $question->setDb($di->get("dbqb"));
        $questions = $question->findAllWhere("uid = ?", $this->id);
        $answer = new Answer();
        $answer->setDb($di->get("dbqb"));
        $answers = $answer->findAllWhere("uid = ?", $this->id);
        $acomment = new Acomment();
        $acomment->setDb($di->get("dbqb"));
        $acomments = $acomment->findAllWhere("uid = ?", $this->id);
        $qcomment = new Qcomment();
        $qcomment->setDb($di->get("dbqb"));
        $qcomments = $qcomment->findAllWhere("uid = ?", $this->id);
        $numQuest = count($questions);
        $numAnswer = count($answers);
        $numComments = count($acomments) + count($qcomments);

        $this->activityScore = $numAnswer + $numComments + $numQuest + $this->votes;
    }
    /**
     * Calculate reputation levels.
     *
     * @param object $di 
     *
     * @return void
     */
    public function getReputation($di)
    {
        $this->activityScore($di);
        $score = $this->activityScore;
        if ($score < 10) {
            $this->reputation = "Newcomer";
        } elseif ($score > 100) {
            $this->reputation = "Guru";
        } else {
            $this->reputation = "Regular";
        }
    }
}