<?php $videos = Xtube\Frontend\Models\Video::get_top_videos(); ?>
<div id="top-widget" class="container">
    <?php foreach ($videos as $video): ?>
    <div class="row">
        <div class="col-sm">
            <div class="row no-gutters">
                <div class="col-sm-3">
                    <img class="img-fluid" src="<?php echo $video->img_src; ?>" alt="">
                </div>

                <div class="col-sm-9">
                    <a class="nav-link"
                        href="<?php echo Xtube\Frontend\XtubeFrontend::view_url('video', $video->id); ?>"><?php echo $video->title; ?></a>
                </div>
            </div>
            <div class="row no-gutters">
                <div class="col-sm d-inline text-center">
                    <i class="far fa-clock d-inline"> <?php echo $video->duration;?></i>
                    <i class="far fa-eye d-inline"> <?php echo $video->views;?></i>
                    <i class="far fa-thumbs-up d-inline"> <?php echo $video->upvotes;?></i>
                    <i class="far fa-thumbs-down d-inline"> <?php echo $video->downvotes;?></i>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <?php endforeach;  ?>
</div>