<div class="container">
    <?php if (is_object($data['video'])): $video = $data['video']; ?>
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
                            <?php echo $video->upvotes;?></i>
                    </button>
                    <button onClick="vote('n');" class="btn btn-sm btn-danger"><i class="far fa-thumbs-down d-inline">
                            <?php echo $video->downvotes;?></i>
                    </button>

                    <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target=".report-modal">
                        <i class="fas fa-exclamation-triangle d-inline"> Report video </i>
                    </button>
                </div>
            </div>

            <div class="row">
                <div class="col-sm">
                    <?php if (isset($data['tags'])): $tags = $data['tags']; ?>
                    <?php foreach ($tags as $tag): ?>
                    <a class="badge badge-danger" href="<?php echo esc_url(home_url()) . '/tag/' . $tag->name; ?>">
                        <?php echo $tag->name; ?>
                    </a>
                    <?php endforeach; ?>
                    <?php endif; ?>
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
        <input type="hidden" name="video_id" value="<?php echo $video->id; ?>">
    </form>
</div>

<div class="modal fade report-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Report this video</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" name="report_form" method="POST">
                    <div class="form-group">
                        <input class="form-control" name="reason" type="text"
                            placeholder="Write a reason for your report">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" onClick="report();">Send report</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>