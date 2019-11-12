<?php $videos = Xtube\Frontend\Controllers\VideoController::get_videos(); ?>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <?php Xtube\Frontend\Controllers\VideoController::print_pagination(); ?>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <?php $count = 1; foreach ($videos as $video): ?>
        <?php if ($count % 4 == 1): ?>
        <div class="w-100"></div>
        <?php endif; $count++; ?>

        <div class="col-sm">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <img class="img-fluid" src="<?php echo $video->img_src; ?>" alt="">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 text-center">
                    <a class="" href="<?php echo Xtube\Frontend\XtubeFrontend::view_url('video', $video->id); ?>"><?php echo $video->title; ?></a>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 text-center">
                    <p><?php echo $video->duration;?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 text-center">
                </div>
            </div>
        </div>

        <?php endforeach;  ?>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <?php Xtube\Frontend\Controllers\VideoController::print_pagination(); ?>
        </div>
    </div>
</div>