<div class="container">
    <div class="row">
        <div class="col">
            <h1>Reported videos</h1>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Reason</th>
                        <th scope="col">URL</th>
                        <th scope="col">Manage</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($data['reported_videos'])): ?>
                    <?php foreach ($data['reported_videos'] as $video): ?>
                    <form class="form-inline" action="<?php echo esc_url(admin_url('admin-post.php'));?>" method="post">
                        <tr>
                            <td> <textarea name="" id="" cols="30" rows="4"> <?php echo $video->reason; ?> </textarea></td>
                            <td> <a href="<?php echo $video->url; ?>"><?php echo $video->url; ?></a></td>
                            <td>
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <button type="submit" name="delete_report"
                                            class="btn btn-success btn-sm btn-block">IGNORE <i
                                                class="fa fa-angle-right"></i></button>

                                        <button type="submit" name="delete_video"
                                            class="btn btn-success btn-sm btn-block">DELETE VIDEO<i
                                                class="fa fa-angle-right"></i></button>
                                    </span>
                                </div>
                                <input type="hidden" name="action" value="reported_videos_controller">
                                <input type="hidden" name="report_id" value="<?php echo $video->report_id; ?>">
                                <input type="hidden" name="video_id" value="<?php echo $video->id; ?>">
                            </td>
                        </tr>
                    </form>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>