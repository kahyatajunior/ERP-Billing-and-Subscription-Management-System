

<?php $__env->startSection('content'); ?>
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">Customers</h1>
    <a href="<?php echo e(route('customers.create')); ?>" class="rounded bg-slate-900 px-4 py-2 text-white">New Customer</a>
</div>

<div class="overflow-hidden rounded bg-white shadow">
    <table class="min-w-full text-left">
        <thead class="bg-slate-100 text-sm uppercase text-slate-600">
            <tr>
                <th class="px-4 py-3">Name</th>
                <th class="px-4 py-3">Type</th>
                <th class="px-4 py-3">Email</th>
                <th class="px-4 py-3">Balance</th>
                <th class="px-4 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="border-t">
                    <td class="px-4 py-3"><?php echo e($customer->name); ?></td>
                    <td class="px-4 py-3"><?php echo e(ucfirst($customer->customer_type)); ?></td>
                    <td class="px-4 py-3"><?php echo e($customer->email); ?></td>
                    <td class="px-4 py-3">ZMW <?php echo e(number_format($customer->statement_balance(), 2)); ?></td>
                    <td class="px-4 py-3">
                        <a href="<?php echo e(route('customers.statement', $customer)); ?>" class="text-indigo-600">Statement</a>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center text-slate-500">No customers found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php echo e($customers->links()); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\kahya\Downloads\Programs\ERP\resources\views/customers/index.blade.php ENDPATH**/ ?>