<?php

namespace Anax\View;

/**
 * View to see question.
 */



?><h2>Question</h2>

<?php if (!$question) : ?>
    <p>There is no question to show.</p>
<?php
    return;
endif;
?>
<div class="profileBtn">
    <a href="../update/<?= $question->id ?>">Edit question</a>
</div>

<div class="question-container">
    <h3><?= $question->title; ?></h3>
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
                <a href="../../tags/tag/<?= $tag->id ?>">
                    #<?= $tag->tag; ?>
                </a>
            <?php endforeach; ?>
        <?php
        endif;
        ?>
    </div>
</div>
<div class="question-container answer-container">
    <h4>Answers</h4>
    <?php if ($question->answers) : ?>
        <?php foreach ($question->answers as $answer) : ?>
            <p>Created <?= date('Y/m/d H:i:s', $answer->created); ?></p>
            <div class="question">
                <div class="score">
                    <button class="vote-up"><i class="up"></i></button>
                    <div class="vote-count"></div>
                    <button class="vote-down"><i class="down"></i></button>
                    <div class="check"></div>
                </div>
                <p><?= $answer->text; ?></p>
                <div class="user user-right">
                    <a href="../../user/userprofile/<?= $answer->user->id ?>">
                        <div class="user-img">
                            <img src="<?= $answer->user->image; ?>" alt="<?= $answer->user->name; ?>">
                        </div>
                        <div class="user-small">
                            <h3><?= $answer->user->name; ?></h3>
                            <p>Score: <?= $answer->user->score; ?></p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="profileBtn">
                <a href="../../answer/update/<?= $answer->id ?>">Edit answer</a>
            </div>
        <?php endforeach; ?>
    <?php
    endif;
    ?>
</div>