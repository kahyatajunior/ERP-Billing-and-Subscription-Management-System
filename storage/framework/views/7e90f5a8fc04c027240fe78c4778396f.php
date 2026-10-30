

<?php $__env->startSection('content'); ?>
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">Subscriptions</h1>
    <a href="<?php echo e(route('subscriptions.create')); ?>" class="rounded bg-slate-900 px-4 py-2 text-white">New Subscription</a>
</div>

<div class="overflow-hidden rounded bg-white shadow">
    <table class="min-w-full text-left">
        <thead class="bg-slate-100 text-sm uppercase text-slate-600">
            <tr>
                <th class="px-4 py-3">Customer</th>
                <th class="px-4 py-3">Plan</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3">Starts</th>
                <th class="px-4 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $subscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="border-t">
                    <td class="px-4 py-3"><?php echo e($subscription->customer->name); ?></td>
                    <td class="px-4 py-3"><?php echo e($subscription->servicePlan->name); ?></td>
                    <td class="px-4 py-3"><?php echo e($subscription->status); ?></td>
                    <td class="px-4 py-3"><?php echo e($subscription->starts_at?->format('d M Y')); ?></td>
                    <td class="px-4 py-3 space-x-3">
                        <form action="<?php echo e(route('subscriptions.activate', $subscription)); ?>" method="POST" class="inline">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="text-emerald-600">Activate</button>
                        </form>
                        <form action="<?php echo e(route('subscriptions.generate-invoice', $subscription)); ?>" method="POST" class="inline">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="text-indigo-600">Generate Invoice</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center text-slate-500">No subscriptions found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php echo e($subscriptions->links()); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\kahya\Downloads\Programs\ERP\resources\views/subscriptions/index.blade.php ENDPATH**/ ?>