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
    <p>There are no questions to show.</p>
<?php
    return;
endif;
?>
<?php foreach ($questions as $question) : ?>
    <div class="questions">
        <div class="question">
            <a href="questions/question/<?= $question->id ?>">
                <h3><?= $question->title; ?></h3>
            </a>
            <div>
                <p><?= $question->text; ?></p>
                <section class="user user-right">
                    <a href="user/userprofile/<?= $question->user->id ?>">
                        <div class="user-img">
                            <img src="<?= $question->user->image; ?>" alt="<?= $question->user->name; ?>">
                        </div>
                        <div class="user-small">
                            <h3><?= $question->user->name; ?></h3>
                        </div>
                    </a>
                </section>
            </div>
            <?php if ($question->tags) : ?>
                <?php foreach ($question->tags as $tag) : ?>
                    <p><?= $tag->tag; ?></p>
                <?php endforeach; ?>
            <?php
            endif;
            ?>
        </div>
    </div>
<?php endforeach; ?>