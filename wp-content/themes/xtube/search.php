<?php $videos = Xtube\Frontend\Controllers\VideoController::get_videos_search(); ?>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <?php Xtube\Frontend\Controllers\VideoController::print_pagination_search(); ?>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <?php $count = 1; foreach ($videos as $video): ?>
        <?php if ($count % 4 == 1): ?>
        <div class="w-100 mb-3"></div>
        <?php endif; $count++; ?>

        <div class="col-sm">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <img class="img-fluid" src="<?php echo $video->img_src; ?>" alt="">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 text-center">
                    <a class=""
                        href="<?php echo Xtube\Frontend\XtubeFrontend::view_url('video', $video->id); ?>"><?php echo $video->title; ?></a>
                </div>
            </div>
            <div class="row">
                <div class="col-sm d-inline text-center">
                    <i class="far fa-clock d-inline"> <?php echo $video->duration;?></i>
                    <i class="far fa-eye d-inline"> <?php echo $video->views;?></i>
                    <i class="far fa-thumbs-up d-inline"> <?php echo $video->upvotes;?></i>
                    <i class="far fa-thumbs-down d-inline"> <?php echo $video->downvotes;?></i>
                </div>
            </div>
        </div>

        <?php endforeach;  ?>
        <div class="w-100 mb-3"></div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <?php Xtube\Frontend\Controllers\VideoController::print_pagination_search(); ?>
        </div>
    </div>
</div>