<?php $video_id = Xtube\Frontend\XtubeFrontend::get_query_var('xtb_video'); ?>
<?php $video = Xtube\Frontend\Models\Video::get_video($video_id);?>

<div class="container">
    <div class="row">
        <div class="col-sm-9">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <?php echo $video->iframe; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 text-center">
                    <a class="" href="<?php echo $video->url; ?>"><?php echo $video->title; ?></a>
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



        <div class="col-sm-3">
            <div class="row">
                <div class="col-sm">
                    WIDGET
                </div>
            </div>
            <div class="row">
                <div class="col-sm">
                    AD
                </div>
            </div>
        </div>

    </div>
</div>