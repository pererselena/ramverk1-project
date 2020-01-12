<?php

namespace Anax\View;

/**
 * View for index.
 */
?>

<h2>Most active users</h2>
<?php if (!$users) : ?>
    <p>There are no users to show.</p>
<?php
    return;
endif;
$count = 0;
?>
<div class="users">
    <?php foreach ($users as $user) : ?>
        <?php if ($count >= 5) : break;
        endif;
        ?>
        <div class="user">
            <a href="user/userprofile/<?= $user->id ?>">
                <div class="user-img">
                    <img src="<?= $user->image; ?>" alt="User">
                </div>
                <div class="user-small">
                    <h3><?= $user->name; ?></h3>
                    <p>Activity score: <?= $user->activityScore; ?></p>
                </div>
            </a>
        </div>
    <?php $count++;
    endforeach; ?>
</div>

<h2>Recent questions</h2>
<?php if (!$questions) : ?>
    <p><i>There are no questions to show.</i></p>
<?php
    return;
endif;
$count = 0;
?>
<?php foreach ($questions as $question) : ?>
    <?php if ($count >= 3) : break;
    endif;
    ?>
    <div class="question-container">
        <a href="questions/question/<?= $question->id ?>">
            <h3><?= $question->title; ?></h3>
        </a>
        <p>Created <?= date('Y/m/d H:i:s', $question->created); ?></p>
        <p>Answers: <?= $question->numAns ?></p>
        <div class="question">
            <div class="score">
                <div class="vote-count">Score: <?= $question->score; ?></div>
            </div>
            <div class="text"><?= $question->text; ?></div>

            <div class="user user-right">
                <a href="user/userprofile/<?= $question->user->id ?>">
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
                    <a href="tags/tag/<?= $tag->id ?>">
                        #<?= $tag->tag; ?>
                    </a>
                <?php endforeach; ?>
            <?php
            endif;
            ?>
        </div>
    </div>
<?php $count++;
endforeach; ?>
<h2>Popular tags</h2>

<?php if (!$popular) : ?>
    <p>There is no tags to show.</p>
<?php
    return;
endif;
?>
<div class="tags">

    <?php foreach ($popular as $tag) : ?>
        <a href="tags/tag/<?= $tag->id ?>">
            #<?= $tag->tag; ?>
        </a>
    <?php endforeach; ?>
</div>