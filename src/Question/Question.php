<?php

namespace Elpr\Question;

use Anax\DatabaseActiveRecord\ActiveRecordModel;
use phpDocumentor\Reflection\Types\Array_;
use Elpr\Tag\Tag;
use Elpr\Question\TagToQuestion;

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
    public function updateScore($questionId, $score)
    {
        $this->findById($questionId);
        $this->score += $score;
    }

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
    public function deleteTags($di, $id)
    {
        $tagQ = new TagToQuestion();
        $tagQ->setDb($di->get("dbqb"));
        $tags = $tagQ->findAllWhere("qid = ?", $id);
        foreach ($tags as $key => $value) {
            $value->setDb($di->get("dbqb"));
            $value->delete();
        }
    }
}
