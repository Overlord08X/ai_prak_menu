<?php if ($message = flash('success')): ?>
    <div class="alert alert-success alert-dismissible fade show flash-alert" role="alert">
        <?= e($message) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>
<?php if ($message = flash('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show flash-alert" role="alert">
        <?= e($message) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>
<?php if ($message = flash('warning')): ?>
    <div class="alert alert-warning alert-dismissible fade show flash-alert" role="alert">
        <?= e($message) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>
<?php if ($message = flash('info')): ?>
    <div class="alert alert-info alert-dismissible fade show flash-alert" role="alert">
        <?= e($message) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>
