<?php

namespace Elpr\Answer;

use Anax\DatabaseActiveRecord\ActiveRecordModel;
use phpDocumentor\Reflection\Types\Array_;
use Elpr\Tag\Tag;
use Elpr\User\User;
use Elpr\Answer\Acomment;

/**
 * A database driven model.
 */
class Answer extends ActiveRecordModel
{

    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Answer";

    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $uid;
    public $qid;
    public $text;
    public $score;
    public $created;
    public $updated;
    public $deleted;
    public $active;

    /**
     * Set the text.
     *
     * @param string $text the text to use.
     *
     * @return void
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * Update score.
     *
     * @param integer $questionId.
     * @param integer $score.
     *
     * @return void
     */
    public function updateScore($id, $score)
    {
        $this->findById($id);
        $this->score += $score;
    }

    /**
     * Get comments.
     *
     *
     * @return array
     */
    public function getComments($di)
    {
        $comment = new Acomment();
        $comment->setDb($di->get("dbqb"));
        $comments = $comment->findAllWhere("aid = ?", $this->id);
        foreach ($comments as $comment) {
            $user = new User();
            $user->setDb($di->get("dbqb"));
            $comment->user = $user->findById($comment->uid);
        }

        return $comments;
    }

}
