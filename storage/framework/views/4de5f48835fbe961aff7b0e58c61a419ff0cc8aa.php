<?php $__env->startSection('content'); ?>
<div class="card container d-flex flex-column justify-content-between align-items-center" style="max-width:400px;border-radius:12px">
  <form method="POST" action="<?php echo e(route('login')); ?>" style="margin-top:auto;margin-bottom:auto" > 
    <?php echo csrf_field(); ?>
    <div class="font-regular"><?php echo e(__('auth.welcome_back')); ?></div>
    <div class="font-big"><?php echo e(__('auth.login_text')); ?></div>
    <!-- email -->
    <div class="margin-tb-10">
      <label for="email" class="font-regular"><?php echo e(__('auth.email')); ?></label>
      <input id="email" type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email" value="<?php echo e(old('email')); ?>" required autocomplete="email" autofocus placeholder="123@gmail.com">
      <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
      <span class="invalid-feedback" role="alert">
        <strong><?php echo e($message); ?></strong>
      </span>
      <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>


    <!-- password -->
    <div class="margin-tb-10">
      <label for="password" class="font-regular"><?php echo e(__('auth.passowrd_text')); ?></label>
      <input id="password" type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" required autocomplete="current-password">
    </div>

    <!-- remember me and forget password -->
    <div class="d-flex justify-content-between margin-tb-10">
      <label for="remember_me"><input type="checkbox" value="remember_me" class="checkbox-round" <?php echo e(old('remember') ? 'checked' : ''); ?>><?php echo e(__('auth.remember_me')); ?></label>
      <label for="forget_password"><a href="<?php echo e(route('password.request')); ?>"><?php echo e(__('auth.forget_password')); ?></a></label>
    </div>

    <!-- Login button -->
    <div>
      <button class="btn btn-primary inter-bold" style="width:100%"><?php echo e(__('auth.login_now')); ?></button>
    </div>

  </form>
  <div>
    <label style="text-align:center;width:100%;"><?php echo e(__('auth.sign_up_text')); ?> <a href="<?php echo e(route('register')); ?>"><?php echo e(__('auth.sign_up_link')); ?></a></label>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\minut\resources\views/auth/login.blade.php ENDPATH**/ ?>