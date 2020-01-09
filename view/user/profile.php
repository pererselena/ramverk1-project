<?php

namespace Anax\View;

/**
 * View to see profile.
 */



?><h2>User profile</h2>
<div class="profile-user">
    <div class="profile-img">
        <img src="<?= $user->image; ?>" alt="User">
    </div>
    <div class="userinfo">
        <h3><?= $user->name; ?></h3>
        <p><?= $user->email; ?></p>
        <p><?= $user->tel; ?></p>
        <p><?= $user->birthdate; ?></p>
    </div>
</div>
<div class="profileBtn">
    <a href="update">Update profile</a>
</div>