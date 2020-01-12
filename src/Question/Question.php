<?php

namespace Elpr\Question;

use Anax\DatabaseActiveRecord\ActiveRecordModel;
use phpDocumentor\Reflection\Types\Array_;
use Elpr\Tag\Tag;
use Elpr\Question\TagToQuestion;
use Elpr\Question\Qcomment;
use Elpr\Answer\Answer;
use Elpr\User\User;
use Elpr\Filter\TextFilter;

/**
 * A database driven model.
 */
class Question extends ActiveRecordModel
{

    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Questions";

    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $uid;
    public $title;
    public $text;
    public $score;
    public $created;
    public $updated;
    public $deleted;
    public $active;

    /**
     * Get all tags.
     *
     *
     * @return array
     */
    public function getAllTags($di)
    {
        $tag = new Tag();
        $tag->setDb($di->get("dbqb"));
        $tags = $tag->findAll();
        $allTags = array();
        foreach ($tags as $key => $value) {
            array_push($allTags, $value->tag);
        }

        return $allTags;
    }

    /**
     * Get all questions tags.
     *
     *
     * @return array
     */
    public function getTags($di, $id)
    {
        $tagQ = new TagToQuestion();
        $tagQ->setDb($di->get("dbqb"));
        $tags = $tagQ->findAllWhere("qid = ?", $id);
        $allTags = array();
        foreach ($tags as $key => $value) {
            $tag = new Tag();
            $tag->setDb($di->get("dbqb"));
            $tagText = $tag->findById($value->id)->tag;
            array_push($allTags, $tagText);
        }

        return $allTags;
    }

    /**
     * Get all questions tags.
     *
     *
     * @return void
     */
    public function deleteTags($di)
    {
        $tagQ = new TagToQuestion();
        $tagQ->setDb($di->get("dbqb"));
        $tags = $tagQ->findAllWhere("qid = ?", $this->id);
        foreach ($tags as $key => $value) {
            $value->setDb($di->get("dbqb"));
            $value->delete();
        }
    }

    /**
     * Get answers.
     *
     *
     * @return array
     */
    public function getAnswers($di, $sort = "date")
    {
        $answer = new Answer();
        $answer->setDb($di->get("dbqb"));
        $answers = $answer->findAllWhere("qid = ?", $this->id);
        foreach ($answers as $answer) {
            $user = new User();
            $user->setDb($di->get("dbqb"));
            $answer->user = $user->findById($answer->uid);
            $textFilter = new TextFilter();
            $answer->text = $textFilter->markdown($answer->text);
        }
        if ($sort == "score") {
            usort($answers, function ($first, $second) {
                return $first->score < $second->score;
            });
        } elseif ($sort == "date") {
            usort($answers, function ($first, $second) {
                return $first->created < $second->created;
            });
        }
        return $answers;
    }

    /**
     * Get comments.
     *
     *
     * @return array
     */
    public function getComments($di)
    {
        $comment = new Qcomment();
        $comment->setDb($di->get("dbqb"));
        $comments = $comment->findAllWhere("qid = ?", $this->id);
        foreach ($comments as $comment) {
            $user = new User();
            $user->setDb($di->get("dbqb"));
            $comment->user = $user->findById($comment->uid);
            $textFilter = new TextFilter();
            $comment->text = $textFilter->markdown($comment->text);
        }

        return $comments;
    }
}
