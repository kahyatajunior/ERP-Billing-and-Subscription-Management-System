

<?php $__env->startSection('content'); ?>
<div class="grid grid-cols-1 md:grid-cols-4 gap-4">
    <div class="rounded bg-white p-5 shadow">
        <p class="text-sm text-slate-500">Customers</p>
        <p class="mt-2 text-3xl font-bold"><?php echo e($customers); ?></p>
    </div>
    <div class="rounded bg-white p-5 shadow">
        <p class="text-sm text-slate-500">Subscriptions</p>
        <p class="mt-2 text-3xl font-bold"><?php echo e($subscriptions); ?></p>
    </div>
    <div class="rounded bg-white p-5 shadow">
        <p class="text-sm text-slate-500">Invoices</p>
        <p class="mt-2 text-3xl font-bold"><?php echo e($invoices); ?></p>
    </div>
    <div class="rounded bg-white p-5 shadow">
        <p class="text-sm text-slate-500">Outstanding</p>
        <p class="mt-2 text-3xl font-bold">ZMW <?php echo e(number_format($outstanding, 2)); ?></p>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\kahya\Downloads\Programs\ERP\resources\views/dashboard.blade.php ENDPATH**/ ?>