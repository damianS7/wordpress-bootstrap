<div class="container">
    <div class="row">
        <div class="col">
            <h1>Tags</h1>
        </div>
    </div>
    <hr>

    <form class="form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
        <input type="hidden" name="action" value="tags_controller">
        <div class="row">
            <div class="col-sm-2 form-group">
                <input type="text" class="form-control" name="name" placeholder="Tag name">
            </div>
            <div class="col-sm-6 form-group">
                <input type="text" class="form-control" name="description" placeholder="Tag description">
            </div>
            <div class="col-sm-4 form-group">
                <button type="submit" name="create_tag" class="btn btn-block btn-primary">NEW TAG</button>
            </div>
        </div>
    </form>

    <div class="row">
        <div class="col">

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">Tag name</th>
                        <th scope="col">Manage</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (is_array($data['tags'])): ?>
                    <?php foreach ($data['tags'] as $tag): ?>
                    <tr>
                        <th scope="row"><?php echo $tag->id; ?></th>
                        <td><?php echo $tag->name; ?></td>
                        <td>
                            <form class="form-inline" action="<?php echo esc_url(admin_url('admin-post.php')); ?>"
                                method="post">
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <button type="submit" name="delete_tag" class="btn btn-success btn-sm">DELETE <i
                                                class="fa fa-angle-right"></i></button>
                                    </span>
                                </div>
                                <input type="hidden" name="action" value="tags_controller">
                                <input type="hidden" name="tag_id" value="<?php echo $tag->id; ?>">
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>