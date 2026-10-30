

<?php $__env->startSection('content'); ?>
<div class="mx-auto max-w-2xl rounded bg-white p-6 shadow">
    <h1 class="mb-6 text-2xl font-bold">Create Customer</h1>
    <form method="POST" action="<?php echo e(route('customers.store')); ?>" class="space-y-4">
        <?php echo csrf_field(); ?>
        <div>
            <label class="mb-1 block font-medium">Organization</label>
            <select name="organization_id" class="w-full rounded border px-3 py-2">
                <?php $__currentLoopData = $organizations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $organization): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($organization->id); ?>"><?php echo e($organization->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div>
            <label class="mb-1 block font-medium">Name</label>
            <input type="text" name="name" class="w-full rounded border px-3 py-2" required>
        </div>
        <div>
            <label class="mb-1 block font-medium">Customer Type</label>
            <select name="customer_type" class="w-full rounded border px-3 py-2">
                <option value="business">Business</option>
                <option value="individual">Individual</option>
            </select>
        </div>
        <div>
            <label class="mb-1 block font-medium">Email</label>
            <input type="email" name="email" class="w-full rounded border px-3 py-2">
        </div>
        <div>
            <label class="mb-1 block font-medium">Phone</label>
            <input type="text" name="phone" class="w-full rounded border px-3 py-2">
        </div>
        <div>
            <label class="mb-1 block font-medium">Status</label>
            <select name="status" class="w-full rounded border px-3 py-2">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>
        <div>
            <label class="mb-1 block font-medium">Credit Limit</label>
            <input type="number" step="0.01" name="credit_limit" class="w-full rounded border px-3 py-2" value="0">
        </div>
        <button type="submit" class="rounded bg-slate-900 px-4 py-2 text-white">Save</button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\kahya\Downloads\Programs\ERP\resources\views/customers/create.blade.php ENDPATH**/ ?>