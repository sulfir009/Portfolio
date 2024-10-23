<?php $__env->startSection('title', 'Welcome to Partner Management System'); ?>
<?php $__env->startSection('header-title', 'Welcome to Partner Management System'); ?>
<?php $__env->startSection('header-subtitle', 'Manage your business partnerships with ease'); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <!-- Card 1: Manage Partners -->
        <div class="col-md-6 mb-4">
            <div class="card card-custom shadow-lg">
                <img src="https://via.placeholder.com/600x300" class="card-img-top" alt="Partners">
                <div class="card-body text-center">
                    <h5 class="card-title fw-bold">Manage Partners</h5>
                    <p class="card-text">Access and manage all your company's partners. Add, edit, view details, and track partner relationships.</p>
                    <a href="/partners" class="btn btn-custom">Go to Partners</a>
                </div>
            </div>
        </div>
        <!-- Card 2: Manage Contracts -->
        <div class="col-md-6 mb-4">
            <div class="card card-custom shadow-lg">
                <img src="https://via.placeholder.com/600x300" class="card-img-top" alt="Contracts">
                <div class="card-body text-center">
                    <h5 class="card-title fw-bold">Manage Contracts</h5>
                    <p class="card-text">Easily manage contracts with your partners. Create, track, and maintain all contractual details in one place.</p>
                    <a href="/contracts" class="btn btn-custom">Go to Contracts</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Authentication Links -->
    <div class="text-center mt-5">
        <?php if(Route::has('login')): ?>
            <?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(url('/dashboard')); ?>" class="btn btn-custom">Dashboard</a>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>" class="btn btn-custom me-3">Log in</a>
                <?php if(Route::has('register')): ?>
                    <a href="<?php echo e(route('register')); ?>" class="btn btn-custom">Register</a>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Portfolio\LARAVEL\partners-management\resources\views/welcome.blade.php ENDPATH**/ ?>