<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(config('app.name')); ?></title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-slate-100 text-slate-800">
    <nav class="bg-slate-900 text-white shadow">
        <div class="mx-auto max-w-7xl px-4 py-3 flex gap-6 items-center">
            <a href="<?php echo e(route('dashboard')); ?>" class="font-bold text-lg">ERP</a>
            <a href="<?php echo e(route('customers.index')); ?>" class="text-sm hover:text-slate-300">Customers</a>
            <a href="<?php echo e(route('subscriptions.index')); ?>" class="text-sm hover:text-slate-300">Subscriptions</a>
            <a href="<?php echo e(route('invoices.index')); ?>" class="text-sm hover:text-slate-300">Invoices</a>
        </div>
    </nav>

    <main class="mx-auto max-w-7xl p-6">
        <?php if(session('success')): ?>
            <div class="mb-4 rounded bg-emerald-100 border border-emerald-300 px-4 py-3 text-emerald-800">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php echo $__env->yieldContent('content'); ?>
    </main>
</body>
</html>
<?php /**PATH C:\Users\kahya\Downloads\Programs\ERP\resources\views/layouts/app.blade.php ENDPATH**/ ?>