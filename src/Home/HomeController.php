<?php

namespace Elpr\Home;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Elpr\Question\HTMLForm\CreateCommentForm;
use Elpr\Question\HTMLForm\UpdateCommentForm;
use Elpr\Question\HTMLForm\CreateQuestionForm;
use Elpr\Question\HTMLForm\UpdateQuestionForm;
use Elpr\Question\Question;
use Elpr\Question\TagToQuestion;
use Elpr\Tag\Tag;
use Elpr\User\User;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class HomeController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;



    /**
     * @var $data description
     */

    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function indexActionGet(): object
    {
        $page = $this->di->get("page");
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $questions = $question->findAll();
        $tagToQuestion = new TagToQuestion();
        $tagToQuestion->setDb($this->di->get("dbqb"));
        $usedTags = $tagToQuestion->findAll();
        $tagsId = array();
        foreach ($usedTags as $tag) {
            array_push($tagsId, $tag->tid);
        }
        $values = array_count_values($tagsId);
        arsort($values);
        $popular = array_slice(array_keys($values), 0, 5, true);

        foreach ($questions as $quest) {
            $quest->tags = [];
            $tags = $tagToQuestion->findAllWhere("qid = ?", $quest->id);
            if ($tags) {
                $tagArr = $this->getTagsFromId($tags);
                $quest->tags = $tagArr;
            }
            $quest->numAns = sizeof($quest->getAnswers($this->di));
            $user = new User();
            $user->setDb($this->di->get("dbqb"));
            $quest->user = $user->findById($quest->uid);
            $quest->user->getReputation($this->di);
        }
        usort($questions, function ($first, $second) {
            return $first->created < $second->created;
        });
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $users = $user->findAll();
        foreach ($users as $curUser) {
            $curUser->getReputation($this->di);
        }
        usort($users, function($first, $second){
            return $first->activityScore < $second->activityScore;
        });

        $page->add("home/flash", [], "flash");

        $page->add("home/index", [
            "users" => $users,
            "questions" => $questions,
            "popular" => $this->getTagsFromId($popular),
        ]);
        return $page->render([
            "title" => "A index page",
        ]);
    }

    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return array 
     */
    public function getTagsFromId($tags)
    {
        $tagArr = array();
        foreach ($tags as $item) {
            $tag = new Tag();
            $tag->setDb($this->di->get("dbqb"));
            if (isset($item->tid)) {
                array_push($tagArr, $tag->findWhere("id = ?", $item->tid));
            } else {
                array_push($tagArr, $tag->findWhere("id = ?", $item));
            }
            
        }
        return $tagArr;
    }

    
}
