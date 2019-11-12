<ul class="pagination justify-content-center">
    <?php foreach ($data['pagination']['pages'] as $page): ?>
    <li class="page-item <?php echo (Xtube\Frontend\XtubeFrontend::get_page() == $page)  ? 'active' : ''; ?>">
        <?php if ($page == '...'): ?>
            <span class="page-link">...</span>
        <?php else: ?>
            <a class="page-link" href="<?php echo Xtube\Frontend\XtubeFrontend::pagination_url('', '', $page); ?>"><?php echo $page; ?></a>
        <?php endif; ?>
    </li>
    <?php endforeach; ?>
</ul>