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
            <a href="../../questions/vote/<?= $question->id; ?>?vote=1" class="vote-up"><i class="up"></i></a>
            <div class="vote-count"><?= $question->score; ?></div>
            <a href="../../questions/vote/<?= $question->id; ?>?vote=-1" class="vote-down"><i class="down"></i></a>
        </div>
        <div class="text"><?= $question->text; ?></div>
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
                    <a href="../../questions/votecomment/<?= $comment->id; ?>?vote=1" class="vote-up"><i class="up"></i></a>
                    <div class="vote-count"><?= $comment->score; ?></div>
                    <a href="../../questions/votecomment/<?= $comment->id; ?>?vote=-1" class="vote-down"><i class="down"></i></a>
                </div>
                <div class="text"><?= $comment->text; ?></div>
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
                    <a href="../updatecomment/<?= $comment->id ?>">Edit comment</a>
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
        <div class="sort">
            <a href="<?= $question->id; ?>?sort=date">Newest</a>
            <a href="<?= $question->id; ?>">Oldest</a>
            <a href="<?= $question->id; ?>?sort=score">Score</a>
        </div>
        <?php foreach ($question->answers as $answer) : ?>
            <h4>Answer</h4>
            <p>Created <?= date('Y/m/d H:i:s', $answer->created); ?></p>
            <div class="question">
                <div class="score">
                    <a href="../../answer/vote/<?= $answer->id; ?>?vote=1" class="vote-up"><i class="up"></i></a>
                    <div class="vote-count"><?= $answer->score; ?></div>
                    <a href="../../answer/vote/<?= $answer->id; ?>?vote=-1" class="vote-down"><i class="down"></i></a>
                    <a href="../../answer/accepted/<?= $answer->id ?>">
                        <?php if ($answer->accepted == "1") : ?>
                            <div class="check"></div>
                        <?php
                        else : ?>
                            <div class="check gray"></div>
                        <?php
                        endif;
                        ?>
                    </a>
                </div>
                <div class="text"><?= $answer->text; ?></div>
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
                                <a href="../../answer/votecomment/<?= $comment->id; ?>?vote=1" class="vote-up"><i class="up"></i></a>
                                <div class="vote-count"><?= $comment->score; ?></div>
                                <a href="../../answer/votecomment/<?= $comment->id; ?>?vote=-1" class="vote-down"><i class="down"></i></a>
                            </div>
                            <div class="text"><?= $comment->text; ?></div>
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