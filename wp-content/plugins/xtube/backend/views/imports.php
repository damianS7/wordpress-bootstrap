<div class="container">
    <div class="row">
        <div class="col">
            <h1>Imports</h1>
        </div>
    </div>
    <hr>
    <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST">
        <div class="row">
            <div class="col-sm-8 form-group">
                <input type="text" class="form-control" name="search" placeholder="String to search">
            </div>

            <div class="col-sm-2 form-group">
                <select class="form-control" name="server">
                    <option value="xvideos">Xvideos</option>
                    <option value="pornhub">Pornhub</option>
                    <option value="youtube">Youtube</option>
                </select>
            </div>

            <div class="col-sm-2 form-group">
                <input type="hidden" name="action" value="imports_controller">
                <button type="submit" name="search_submit" class="btn btn-primary">SEARCH</button>
            </div>
        </div>
    </form>

    <form action="<?php echo esc_url(admin_url('admin-post.php'));?>" method="POST">
        <div class="row">
            <?php if (isset($data['videos'])): ?>
            <?php $cols = 0; foreach ($data['videos'] as $index => $video): ?>
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
                        <p><?php echo $video->duration; ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" name="video_list[]"
                                    value="<?php echo $index; ?>" id="<?php echo $index; ?>">
                                <label class="custom-control-label" for="<?php echo $index; ?>">Import</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php $cols+=1; if ($cols == 4): ?>
            <div class="w-100"></div>
            <?php $cols = 0; ?>
            <?php endif;?>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="row">
            <div class="col-sm-8">
                <div class="form-group">
                    <input type="text" class="form-control" name="tags"
                        placeholder="Tags for the video split by a comma">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <input type="hidden" name="action" value="imports_controller">
                    <button class="btn btn-primary" type="submit" name="import_submit">Import</button>
                    <button class="btn btn-primary"
                        onClick="jQuery('.custom-control-input').click();return false;">Select ALL</button>
                </div>
            </div>
        </div>
    </form>

    <div class="row">
        <?php //echo $data['pagination'];?>
        <?php if (is_array($data['pagination'])): ?>
        <ul class="pagination">
            <?php foreach ($data['pagination'] as $link_data): ?>
            <li class="<?php echo $link_data['li-class']; ?>">                    
                <?php if ($link_data['tag'] == 'span'): ?>
                    <span class="<?php echo $link_data['link-class']; ?>">
                        <?php echo $link_data['value']; ?>
                    </span>
                <?php else: ?>
                    <a class="<?php echo $link_data['link-class']; ?>" href="<?php echo $link_data['href']; ?>">
                        <?php echo $link_data['value']; ?>
                    </a>
                <?php endif; ?>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </div>
</div>