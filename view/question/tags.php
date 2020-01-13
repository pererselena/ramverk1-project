<?php

namespace Anax\View;

/**
 * View to see tags.
 */



?><h2>Tags</h2>

<?php if (!$tags) : ?>
    <p>There is no tags to show.</p>
    <?php
    return;
endif;
?>
<div class="tags">

    <?php foreach ($tags as $tag) : ?>
        <a href="tags/tag/<?= $tag->id ?>">
            #<?= $tag->tag; ?>
        </a>
    <?php endforeach; ?>
</div>