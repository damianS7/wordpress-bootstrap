<h1>Comments</h1>
<p>My viw</p>

<?php if (isset($data['reported_comments'])):?>
<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">comment_id</th>
            <th scope="col">reason</th>
            <th scope="col">manage</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data['reported_comments'] as $report): ?>
        <form class="form-inline" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
            <tr>
                <td><?php echo $report->id; ?></td>
                <td><input type="text" name="setting_value" value="<?php echo $report->comment_id; ?>"></td>
                <td><?php echo $report->reason; ?></td>
                <td>
                    <div class="input-group">
                        <span class="input-group-btn">
                            <button type="submit" name="delete_reported_comment_submit"
                                class="btn btn-success btn-sm">DELETE <i class="fa fa-angle-right"></i></button>
                        </span>
                    </div>
                    <input type="hidden" name="action" value="reported_comments">
                    <input type="hidden" name="repored_comment_id" value="<?php echo $report->id; ?>">
                </td>
            </tr>
        </form>
        <?php endforeach; ?>
    </tbody>
</table>


<?php endif; ?>

<form action="" method="post">
    <button type="submit">submit</button>
</form>