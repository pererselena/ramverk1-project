<?php

namespace Anax\View;

/**
 * View to see all questions.
 */



?><h2>Questions</h2>
<div class="profileBtn">
    <a href="questions/create">Create question</a>
</div>
<?php if (!$questions) : ?>
    <p><i>There are no questions to show.</i></p>
<?php
    return;
endif;
?>
<?php foreach ($questions as $question) : ?>
    <div class="question-container">
        <a href="../../questions/question/<?= $question->id ?>">
            <h3><?= $question->title; ?></h3>
        </a>
        <p>Created <?= date('Y/m/d H:i:s', $question->created); ?></p>
        <div class="question">
            <div class="score">
                <button class="vote-up"><i class="up"></i></button>
                <div class="vote-count"></div>
                <button class="vote-down"><i class="down"></i></button>
            </div>
            <p><?= $question->text; ?></p>

            <div class="user user-right">
                <a href="../../user/userprofile/<?= $question->user->id ?>">
                    <div class="user-img">
                        <img src="<?= $question->user->image; ?>" alt="<?= $question->user->name; ?>">
                    </div>
                    <div class="user-small">
                        <h3><?= $question->user->name; ?></h3>
                        <p>Score: <?= $question->user->score; ?></p>
                    </div>
                </a>
            </div>
        </div>
        <div class="tags">
            <?php if ($question->tags) : ?>
                <?php foreach ($question->tags as $tag) : ?>
                    <a href="<?= $tag->id ?>">
                        #<?= $tag->tag; ?>
                    </a>
                <?php endforeach; ?>
            <?php
            endif;
            ?>
        </div>
    </div>
<?php endforeach; ?>