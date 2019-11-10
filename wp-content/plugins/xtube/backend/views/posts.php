<div class="container">
    <div class="row">
        <div class="col">
            <h1>Posts</h1>
        </div>
    </div>
    <hr>
    <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST">
        <div class="row">
            <div class="col-sm-6 form-group">
                <input type="text" class="form-control" name="title" placeholder="Post title">
            </div>
            <div class="col-sm-6 form-group">
                <input type="text" class="form-control" name="tags" placeholder="Tags">
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 form-group">
                <input type="text" class="form-control" name="img_src" placeholder="Image source">
            </div>
            <div class="col-sm-6 form-group">
                <input type="text" class="form-control" name="video_url" placeholder="Video url">
            </div>
        </div>

        <div class="row">
            <div class="col-sm-10 form-group">
                <textarea class="form-control" name="content" placeholder="Post content"></textarea>
            </div>

            <div class="col-sm-2 form-group">
                <button type="submit" name="create_post" class="btn btn-block btn-primary">NEW POST</button>
            </div>
        </div>

        <input type="hidden" name="action" value="posts_controller">
    </form>

</div>