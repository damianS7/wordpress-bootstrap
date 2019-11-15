<?php $video_id = Xtube\Frontend\XtubeFrontend::get_query_var('xtb_video'); ?>
<?php $video = Xtube\Frontend\Models\Video::get_video($video_id);?>
<?php $tags = Xtube\Frontend\Models\Tag::get_tags_from_video($video_id);?>

<div class="container">
<?php if (is_object($video)): ?>
    <div class="row">
        <div class="col-sm-9">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <h3 class=""><?php echo $video->title; ?></h3>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 text-center">
                    <?php echo $video->iframe; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm d-inline text-center">
                    <i class="far fa-clock d-inline"> <?php echo $video->duration;?></i>
                    <i class="far fa-eye d-inline"> <?php echo $video->views;?></i>
                    <button onClick="vote('y');" class="btn btn-sm btn-success"><i class="far fa-thumbs-up d-inline">
                            <?php echo $video->upvotes;?></i></button>
                    <button onClick="vote('n');" class="btn btn-sm btn-danger"><i class="far fa-thumbs-down d-inline">
                            <?php echo $video->downvotes;?></i></button>
                </div>
            </div>

            <div class="row">
                <div class="col-sm">
                    <?php foreach ($tags as $tag): ?>
                    <a class="badge badge-danger" href="<?php echo esc_url(home_url()) . '/tag/' . $tag->name; ?>">
                        <?php echo $tag->name; ?>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="row">
                <div class="col-sm">
                    <?php dynamic_sidebar('widget_video_right'); ?>
                </div>
            </div>
        </div>

    </div>
<?php endif; ?>
<form name="vote_form">
    <input type="hidden" name="video_id" value="<?php echo $video_id; ?>">
</form>
</div>