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
<div class="buttons-container">
    <div class="profileBtn">
        <a href="../../answer/create/<?= $question->id ?>">Add answer</a>
    </div>
    <div class="profileBtn">
        <a href="../update/<?= $question->id ?>">Edit question</a>
    </div>
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
    <div class="buttons-container">
        <div class="profileBtn">
            <a href="../createcomment/<?= $question->id ?>">Add comment</a>
        </div>
    </div>
</div>

<!-- Commen to question -->

<div class="question-container comment">
    <?php if ($question->comments) : ?>
        <h4>Comments to question</h4>
        <?php foreach ($question->comments as $comment) : ?>
            <p>Created <?= date('Y/m/d H:i:s', $comment->created); ?></p>
            <div class="question">
                <div class="score">
                    <button class="vote-up"><i class="up"></i></button>
                    <div class="vote-count"></div>
                    <button class="vote-down"><i class="down"></i></button>
                    <div class="check"></div>
                </div>
                <p><?= $comment->text; ?></p>
                <div class="user user-right">
                    <a href="../../user/userprofile/<?= $comment->user->id ?>">
                        <div class="user-img">
                            <img src="<?= $comment->user->image; ?>" alt="<?= $comment->user->name; ?>">
                        </div>
                        <div class="user-small">
                            <h3><?= $comment->user->name; ?></h3>
                            <p>Score: <?= $comment->user->score; ?></p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="buttons-container">
                <div class="profileBtn">
                    <a href="questions/updatecomment/<?= $comment->id ?>">Edit comment</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php
    endif;
    ?>
</div>

<!-- Answers -->

<div class="question-container answer-container">
    <?php if ($question->answers) : ?>
        <?php foreach ($question->answers as $answer) : ?>
            <h4>Answer</h4>
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
            <div class="buttons-container">
                <div class="profileBtn">
                    <a href="../../answer/update/<?= $answer->id ?>">Edit answer</a>
                </div>
                <div class="profileBtn">
                    <a href="../../answer/createcomment/<?= $answer->id ?>">Add comment</a>
                </div>
            </div>
            <!-- Commen to answer -->
            <div class="question-container comment">
                <?php if ($answer->comments) : ?>
                    <h4>Comments to answer</h4>
                    <?php foreach ($answer->comments as $comment) : ?>
                        <p>Created <?= date('Y/m/d H:i:s', $comment->created); ?></p>
                        <div class="question">
                            <div class="score">
                                <button class="vote-up"><i class="up"></i></button>
                                <div class="vote-count"></div>
                                <button class="vote-down"><i class="down"></i></button>
                                <div class="check"></div>
                            </div>
                            <p><?= $comment->text; ?></p>
                            <div class="user user-right">
                                <a href="../../user/userprofile/<?= $comment->user->id ?>">
                                    <div class="user-img">
                                        <img src="<?= $comment->user->image; ?>" alt="<?= $comment->user->name; ?>">
                                    </div>
                                    <div class="user-small">
                                        <h3><?= $comment->user->name; ?></h3>
                                        <p>Score: <?= $comment->user->score; ?></p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="buttons-container">
                            <div class="profileBtn">
                                <a href="../../answer/updatecomment/<?= $comment->id ?>">Edit comment</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php
                endif;
                ?>
            </div>
        <?php endforeach; ?>
    <?php
    endif;
    ?>
</div>