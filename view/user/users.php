<?php

namespace Anax\View;

/**
 * View to see all users.
 */



?><h2>Users</h2>
<?php if (!$users) : ?>
    <p>There are no users to show.</p>
<?php
    return;
endif;
?>
<div class="users">
    <?php foreach ($users as $user) : ?>
        <div class="user">
            <a href="user/userprofile/<?= $user->id ?>">
                <div class="user-img">
                    <img src="<?= $user->image; ?>" alt="User">
                </div>
                <div class="user-small">
                    <h3><?= $user->name; ?></h3>
                    <p>Score: <?= $user->score; ?></p>
                    <p>Activity score: <?= $user->activityScore; ?></p>
                    <p><?= $user->reputation; ?></p>
                </div>
            </a>
        </div>
    <?php endforeach; ?>
</div>