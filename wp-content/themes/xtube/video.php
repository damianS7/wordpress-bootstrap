<?php $video_id = Xtube\Frontend\XtubeFrontend::get_query_var('xtb_video'); ?>
<?php $video = Xtube\Frontend\Models\Video::get_video($video_id);?>

<div class="container">
    <div class="row">
        <div class="col-sm">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <iframe src="<?php echo $video->url; ?>" frameborder="0" width="560" height="315"
                        scrolling="no" allowfullscreen></iframe>
                    <iframe src="https://es.pornhub.com/embed/ph5d8d40c04fdf0" frameborder="0" width="560" height="315"
                        scrolling="no" allowfullscreen></iframe>
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

    </div>
</div>