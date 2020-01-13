<?php

namespace Elpr\Answer;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Elpr\Answer\HTMLForm\CreateAnswerForm;
use Elpr\Answer\HTMLForm\CreateCommentForm;
use Elpr\Answer\HTMLForm\UpdateCommentForm;
use Elpr\Answer\HTMLForm\UpdateAnswerForm;
use Elpr\Answer\Answer;
use Elpr\User\User;
use Elpr\Question\Question;
use Elpr\Answer\Acomment;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class AnswerController implements ContainerInjectableInterface
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
        $page = $this->di->get("page");;
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
     * @return bool
     */
    private function isLoggedIn()
    {
        $session = $this->di->get("session");

        if ($session->get("userEmail")) {
            return true;
        }

        return false;
    }

    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function createcommentAction(int $aid): object
    {
        if (!$this->isLoggedIn()) {
            return $this->di->response->redirect("user/login");
        }
        $page = $this->di->get("page");
        $answer = new Answer();
        $answer->setDb($this->di->get("dbqb"));
        $qid = $answer->findById($aid)->qid;
        $form = new CreateCommentForm($this->di, $aid, $qid);
        $form->check();

        $page->add("anax/v2/article/default", [
            "content" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "A create comment page",
        ]);
    }

    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function updatecommentAction(int $id): object
    {
        if (!$this->isLoggedIn()) {
            return $this->di->response->redirect("user/login");
        }
        $page = $this->di->get("page");
        $answer = new Answer();
        $answer->setDb($this->di->get("dbqb"));
        $ans = $answer->findById($id);
        $qid = $answer->findById($ans->id)->qid;
        $comment = new AComment();
        $comment->setDb($this->di->get("dbqb"));
        $comment->findById($id);
        $session = $this->di->get("session");
        $userId = $session->get("userId");
        if ((int) $comment->uid == (int) $userId) {
            $form = new UpdateCommentForm($this->di, $id, $qid);
            $form->check();

            $page->add("anax/v2/article/default", [
                "content" => $form->getHTML(),
            ]);
            var_dump($userId);
            var_dump($ans->uid);

            return $page->render([
                "title" => "A update comment page",
            ]);
        }
        $page->add("anax/v2/article/default", [
            "content" => "OOPS!!! You are not the owner of this comment!",
        ]);

        return $page->render([
            "title" => "Error",
        ]);
    }
    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function createAction(int $qid): object
    {
        if (!$this->isLoggedIn()) {
            return $this->di->response->redirect("user/login");
        }
        $page = $this->di->get("page");
        $form = new CreateAnswerForm($this->di, $qid);
        $form->check();

        $page->add("anax/v2/article/default", [
            "content" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "A create answer page",
        ]);
    }

    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function updateAction(int $id): object
    {
        if (!$this->isLoggedIn()) {
            return $this->di->response->redirect("user/login");
        }
        $page = $this->di->get("page");
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $session = $this->di->get("session");
        $userId = $session->get("userId");
        $answer = new Answer();
        $answer->setDb($this->di->get("dbqb"));
        $ans = $answer->findById($id);
        if ((int)$ans->uid == (int)$userId) {
            $form = new UpdateAnswerForm($this->di, $id);
            $form->check();

            $page->add("anax/v2/article/default", [
                "content" => $form->getHTML(),
            ]);

            return $page->render([
                "title" => "Update answer",
            ]);
        }
        $page->add("anax/v2/article/default", [
            "content" => "OOPS!!! You are not the owner of this answer!",
        ]);

        return $page->render([
            "title" => "Error",
        ]);
    }

    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function acceptedAction(int $id): object
    {
        if (!$this->isLoggedIn()) {
            return $this->di->response->redirect("user/login");
        }
        $page = $this->di->get("page");
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $session = $this->di->get("session");
        $userId = $session->get("userId");
        $answer = new Answer();
        $answer->setDb($this->di->get("dbqb"));
        $ans = $answer->findById($id);
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $question->findById($ans->qid);
        if ((int)$question->uid == (int)$userId) {
            if ((int)$ans->accepted == 0) {
                $ans->unsetAccepted($this->di);
                $ans->accepted = true;
            } else {
                $ans->unsetAccepted($this->di);
                $ans->accepted = false;
            }
            
            $ans->save();
            return $this->di->response->redirect("questions/question/$ans->qid");
        }
        $page->add("anax/v2/article/default", [
            "content" => "OOPS!!! You are not the owner of this question!",
        ]);

        return $page->render([
            "title" => "Error",
        ]);
    }

    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function voteAction(int $id): object
    {
        $request = $this->di->get("request");
        $vote = (int) $request->getGet("vote") ?? 0;
        if (!$this->isLoggedIn()) {
            return $this->di->response->redirect("user/login");
        }
        $page = $this->di->get("page");
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $session = $this->di->get("session");
        $userId = $session->get("userId");
        $answer = new Answer();
        $answer->setDb($this->di->get("dbqb"));
        $answer->findById($id);
        if ((int)$answer->uid !== (int)$userId) {
            $answer->score += $vote;
            $user->findById($userId);
            $user->votes += 1;
            $user->save();
            $answer->save();
            $user->findById($answer->uid);
            $user->score += $vote;
            $user->save();
            return $this->di->response->redirect("questions/question/$answer->qid");
        }
        $page->add("anax/v2/article/default", [
            "content" => "OOPS!!! You are the owner of this answer! Cheater!!!",
        ]);

        return $page->render([
            "title" => "Error",
        ]);
    }

    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function votecommentAction(int $id): object
    {
        $request = $this->di->get("request");
        $vote = (int) $request->getGet("vote") ?? 0;
        if (!$this->isLoggedIn()) {
            return $this->di->response->redirect("user/login");
        }
        $page = $this->di->get("page");
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $session = $this->di->get("session");
        $userId = $session->get("userId");
        $comment = new Acomment();
        $comment->setDb($this->di->get("dbqb"));
        $comment->findById($id);
        $answer = new Answer();
        $answer->setDb($this->di->get("dbqb"));
        $answer->findById($comment->aid);
        if ((int)$comment->uid !== (int)$userId) {
            $comment->score += $vote;
            $user->findById($userId);
            $user->votes += 1;
            $user->save();
            $comment->save();
            $user->findById($comment->uid);
            $user->score += $vote;
            $user->save();
            return $this->di->response->redirect("questions/question/$answer->qid");
        }
        $page->add("anax/v2/article/default", [
            "content" => "OOPS!!! You are the owner of this comment! Cheater!!!",
        ]);

        return $page->render([
            "title" => "Error",
        ]);
    }

    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function deleteAction(int $id): object
    {
        if (!$this->isLoggedIn()) {
            return $this->di->response->redirect("user/login");
        }
        $page = $this->di->get("page");
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $session = $this->di->get("session");
        $userId = $session->get("userId");
        $answer = new Answer();
        $answer->setDb($this->di->get("dbqb"));
        $answer->findById($id);
        if ((int) $answer->uid == (int) $userId) {
            $answer->removeWithComments($this->di);
            return $this->di->response->redirect("questions/question/$answer->qid");
        }
        $page->add("anax/v2/article/default", [
            "content" => "OOPS!!! You are not the owner of this answer!",
        ]);

        return $page->render([
            "title" => "Error",
        ]);
    }

    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function deletecommentAction(int $id): object
    {
        if (!$this->isLoggedIn()) {
            return $this->di->response->redirect("user/login");
        }
        $page = $this->di->get("page");
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $session = $this->di->get("session");
        $userId = $session->get("userId");
        $aComment = new Acomment();
        $aComment->setDb($this->di->get("dbqb"));
        $aComment->findById($id);
        $answer = new Answer();
        $answer->setDb($this->di->get("dbqb"));
        $answer->findById($aComment->aid);
        if ((int) $aComment->uid == (int) $userId) {
            $aComment->delete();
            return $this->di->response->redirect("questions/question/$answer->qid");
        }
        $page->add("anax/v2/article/default", [
            "content" => "OOPS!!! You are not the owner of this comment!",
        ]);

        return $page->render([
            "title" => "Error",
        ]);
    }
}
