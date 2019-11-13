
<div class="container mt-3 mb-3">
    <div class="row">
        <div class="col-sm-12">
        <?php $tags = Xtube\Frontend\Models\Tag::get_tags();  ?>
        <?php foreach ($tags as $tag): ?>
        <a class="badge badge-danger" href="<?php echo esc_url(home_url()) . '/tag/' . $tag->name; ?>">
            <?php echo $tag->name; ?>
        </a>
        <?php endforeach;  ?>
        </div>
    </div>
</div>