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
    <a href="questions/update/<?= $question->id ?>">Edit question</a>
</div>
<div class="question">
    <div class="question">
        <h3><?= $question->title; ?></h3>
        <p><?= $question->text; ?></p>
        <p><?= $question->user->name; ?></p>
        <?php if ($question->tags) : ?>
            <?php foreach ($question->tags as $tag) : ?>
                <p><?= $tag->tag; ?></p>
            <?php endforeach; ?>
        <?php
        endif;
        ?>
    </div>
</div>