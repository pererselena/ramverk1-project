<?php

namespace Elpr\Answer;

use Anax\DatabaseActiveRecord\ActiveRecordModel;
use phpDocumentor\Reflection\Types\Array_;
use Elpr\Tag\Tag;

/**
 * A database driven model.
 */
class Acomment extends ActiveRecordModel
{

    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Acomment";

    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $uid;
    public $aid;
    public $text;
    public $score;
    public $created;
    public $updated;
    public $deleted;
    public $active;

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
}
