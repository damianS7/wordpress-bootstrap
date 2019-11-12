
<div class="container mt-3 mb-3">
    <div class="row">
        <div class="col-sm-12">
        <?php $tags = Xtube\Frontend\Models\Tag::get_tags();  ?>
        <?php foreach ($tags as $tag): ?>
        <a class="" href="<?php echo esc_url(home_url()) . '/tag/' . $tag->name; ?>">
            <span class="badge badge-danger"><?php echo $tag->name; ?></span>
        </a>
        <?php endforeach;  ?>
        </div>
    </div>
</div>