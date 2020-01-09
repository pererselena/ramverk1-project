<?php

namespace Anax\View;

/**
 * View to see all questions.
 */



?><h2>Questions</h2>
<?php if (!$questions) : ?>
    <p>There are no questions to show.</p>
<?php
    return;
endif;
?>
<?php foreach ($questions as $question) : ?>
    <div class="questions">
        <div class="question">
            <h3><?= $question->title; ?></h3>
            <p><?= $question->text; ?></p>
        </div>
    </div>
<?php endforeach; ?>