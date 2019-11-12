<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <ul class="pagination justify-content-center">
                <li class="page-item disabled">
                    <a class="page-link" href="#">&laquo;</a>
                </li>
                <li class="page-item active">
                    <a class="page-link" href="#">1</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">2</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">3</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">4</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">5</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">&raquo;</a>
                </li>
            </ul>
        </div>

    </div>
</div>

<div class="container">
    <div class="row">
        <?php $tag = Xtube\Frontend\XtubeFrontend::get_tag(); ?>
        <?php $videos = Xtube\Frontend\Models\Video::get_videos_by_tag($tag);  ?>
        <?php $count = 1; foreach ($videos as $video): ?>
        <?php if ($count % 4 == 1):  ?>
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

        <?php endforeach;  ?>
    </div>
</div>



<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <ul class="pagination justify-content-center">
                <li class="page-item disabled">
                    <a class="page-link" href="#">&laquo;</a>
                </li>
                <li class="page-item active">
                    <a class="page-link" href="#">1</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">2</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">3</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">4</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">5</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">&raquo;</a>
                </li>
            </ul>
        </div>

    </div>
</div>