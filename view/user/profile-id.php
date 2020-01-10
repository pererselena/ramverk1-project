<?php

namespace Anax\View;

/**
 * View to see profile.
 */



?><h2>User profile</h2>
<div class="profile-user">
    <div class="profile-img">
        <img src="<?= $profile->image; ?>" alt="User">
    </div>
    <div class="userinfo">
        <h3><?= $profile->name; ?></h3>
        <p><?= $profile->email; ?></p>
        <p>Score: <?= $profile->score; ?></p>
    </div>
</div>