<div class="wrap">
    <h1>TAGS</h1>
    <hr>
</div>
<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">Tag name</th>
            <th scope="col">Tag description</th>
            <th scope="col">Manage</th>
        </tr>
    </thead>
    <tbody>
        <?php if (is_array($data['tags'])): ?>
        <?php foreach ($data['tags'] as $tag): ?>
        <tr>
            <th scope="row"><?php echo $tag->id; ?></th>
            <td><?php echo $tag->name; ?></td>
            <td><?php echo $tag->description; ?></td>
            <td>
                <form class="form-inline" action="" method="post">
                    <div class="input-group">
                        <span class="input-group-btn">
                            <button type="submit" name="delete_tag" class="btn btn-success btn-sm">DELETE <i
                                    class="fa fa-angle-right"></i></button>
                        </span>
                    </div>
                    <input type="hidden" name="tag_id" value="<?php echo $tag->id; ?>">
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
<form method="POST">
    <fieldset>
        <div class="form-group">
            <input type="text" class="form-control" name="name" placeholder="Tag name">
        </div>
        <div class="form-group">
            <textarea type="text" class="form-control" name="description" placeholder="Tag description"></textarea>
        </div>
        <button type="submit" name="create_tag" class="btn btn-block btn-primary">NEW TAG</button>
    </fieldset>
</form>