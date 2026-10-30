

<?php $__env->startSection('content'); ?>
<div class="mb-6">
    <h1 class="text-2xl font-bold">Invoices</h1>
</div>

<div class="overflow-hidden rounded bg-white shadow">
    <table class="min-w-full text-left">
        <thead class="bg-slate-100 text-sm uppercase text-slate-600">
            <tr>
                <th class="px-4 py-3">Invoice</th>
                <th class="px-4 py-3">Customer</th>
                <th class="px-4 py-3">Total</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="border-t">
                    <td class="px-4 py-3"><?php echo e($invoice->invoice_number); ?></td>
                    <td class="px-4 py-3"><?php echo e($invoice->customer->name); ?></td>
                    <td class="px-4 py-3">ZMW <?php echo e(number_format($invoice->total, 2)); ?></td>
                    <td class="px-4 py-3"><?php echo e($invoice->status); ?></td>
                    <td class="px-4 py-3"><a href="<?php echo e(route('invoices.show', $invoice)); ?>" class="text-indigo-600">View</a></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center text-slate-500">No invoices found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php echo e($invoices->links()); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\kahya\Downloads\Programs\ERP\resources\views/invoices/index.blade.php ENDPATH**/ ?>