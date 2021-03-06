<?php

namespace Elpr\Tag;

use Anax\DatabaseActiveRecord\ActiveRecordModel;
use phpDocumentor\Reflection\Types\Array_;

/**
 * A database driven model.
 */
class Tag extends ActiveRecordModel
{

    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Tags";

    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $tag;

    /**
     * Get all tags.
     *
     *
     * @return array
     */
    public function getAllTags()
    {
        $tag = new Tag();
        $tag->setDb($this->di->get("dbqb"));
        $tags = $tag->findAll();
        $allTags = array();
        foreach ($tags as $key => $value) {
            array_push($allTags, $value->tag);
        }

        return $allTags;
    }
}
