<?php

namespace Anax\View;

/**
 * View to see profile.
 */



?><h2>User profile</h2>
<div class="profile-user">
    <div class="profile-img">
        <img src="<?= $user->image; ?>" alt="User">
    </div>
    <div class="userinfo">
        <h3><?= $user->name; ?></h3>
        <p><?= $user->email; ?></p>
        <p>Tel: <?= $user->tel; ?></p>
        <p>Birthdate: <?= $user->birthdate; ?></p>
        <p>Score: <?= $user->score; ?></p>
        <p>Questions: <?= $numQuest; ?></p>
        <p>Answers: <?= $numAnswer; ?></p>
        <p>Comments: <?= $numComments; ?></p>
        <p>Votes: <?= $user->votes; ?></p>
    </div>
</div>
<div class="profileBtn">
    <a href="update">Update profile</a>
</div>
<div class="profile-questions">
    <h3>Questions</h3>
    <table>
        <thead>
            <tr>
                <th>Question</th>
                <th>Date</th>
                <th>Score</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($questions) : ?>
                <?php foreach ($questions as $question) : ?>
                    <tr>
                        <td><a href="../questions/question/<?= $question->id ?>"><?= $question->title; ?></a></td>
                        <td><?= date('Y/m/d H:i:s', $question->created); ?></td>
                        <td><?= $question->score; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php
            endif;
            ?>
        </tbody>
    </table>
    <!-- Answers -->
    <h3>Answers</h3>
    <table>
        <thead>
            <tr>
                <th>Answer</th>
                <th>Date</th>
                <th>Score</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($answers) : ?>
                <?php foreach ($answers as $answer) : ?>
                    <tr>
                        <td><a href="../questions/question/<?= $answer->qid ?>"><?= mb_substr($answer->text, 0, 20) . "..."; ?></a></td>
                        <td><?= date('Y/m/d H:i:s', $answer->created); ?></td>
                        <td><?= $answer->score; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php
            endif;
            ?>
        </tbody>
    </table>
    <!-- Questions comments -->
    <h3>Comments to question</h3>
    <table>
        <thead>
            <tr>
                <th>Comment</th>
                <th>Date</th>
                <th>Score</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($qcomments) : ?>
                <?php foreach ($qcomments as $qcomment) : ?>
                    <tr>
                        <td><a href="../questions/question/<?= $qcomment->qid ?>"><?= mb_substr($qcomment->text, 0, 20) . "..."; ?></a></td>
                        <td><?= date('Y/m/d H:i:s', $qcomment->created); ?></td>
                        <td><?= $qcomment->score; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php
            endif;
            ?>
        </tbody>
    </table>
    <!-- Answers comments -->
    <h3>Comments to answers</h3>
    <table>
        <thead>
            <tr>
                <th>Comment</th>
                <th>Date</th>
                <th>Score</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($acomments) : ?>
                <?php foreach ($acomments as $acomment) : ?>
                    <tr>
                        <td><a href="../questions/question/<?= $acomment->qid ?>"><?= mb_substr($acomment->text, 0, 20) . "..."; ?></a></td>
                        <td><?= date('Y/m/d H:i:s', $acomment->created); ?></td>
                        <td><?= $acomment->score; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php
            endif;
            ?>
        </tbody>
    </table>
</div>