<?php if (!empty($data['error'])): ?>
<div class="alert alert-danger">
    <?php echo $data['error']; ?>
</div>
<?php endif; ?>

<?php if (!empty($data['success'])): ?>
<div class="alert alert-success">
    <?php echo $data['success']; ?>
</div>
<?php endif; ?>