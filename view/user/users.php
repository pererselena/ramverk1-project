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
<?php foreach ($users as $user) : ?>
    <div class="users">
        <div class="user">
            <div class="user-img">
                <img src="<?= $user->image; ?>" alt="User">
            </div>
            <div class="user-small">
                <h3><?= $user->name; ?></h3>
            </div>
        </div>
    </div>

<?php endforeach; ?>