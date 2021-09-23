<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- CSRF Token -->
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

<title>Minut</title>
<link rel="icon" href="<?php echo e(asset('/storage/image/icon.png')); ?>" type="image/icon type">

<!-- Scripts -->
<script src="<?php echo e(asset('js/app.js')); ?>" defer></script>

<!-- Fonts -->
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
<!-- Styles -->
<link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">


<link type="text/css" rel="stylesheet" href="<?php echo e(asset('/storage/css/sidebar.css')); ?>" />
<script type="text/javascript" src="<?php echo e(asset('/storage/js/jquery.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('/storage/js/printThis.js')); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-jgrowl/1.4.8/jquery.jgrowl.min.js" integrity="sha512-h77yzL/LvCeAE601Z5RzkoG7dJdiv4KsNkZ9Urf1gokYxOqtt2RVKb8sNQEKqllZbced82QB7+qiDAmRwxVWLQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="<?php echo e(asset('/storage/js/datatables.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('/storage/js/basic.js')); ?>"></script>

<script type="text/javascript" src="<?php echo e(asset('/storage/js/extensions/fixed_columns.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('/storage/js/extensions/col_reorder.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('/storage/js/extensions/buttons.min.js')); ?>"></script>
<link rel="stylesheet" href="<?php echo e(asset('/storage/css/icons/icomoon/styles.min.css')); ?>">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/css/fontawesome.min.css" integrity="sha384-wESLQ85D6gbsF459vf1CiZ2+rr+CsxRY0RpiF1tLlQpDnAgg6rwdsUF1+Ics2bni" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.1/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">

</head>

<body>

    <div id="app">
        <nav class="navbar navbar-expand-md shadow-sm nav">
            <div class="container d-flex">
                <?php if(Auth::user()): ?>
                <div id="sidebar" class="d-flex justify-content-end" style="flex-grow:8;">
                    <a href="<?php echo e(route('groups.index')); ?>" style="color:<?php echo e(Route::is('groups.index')?'black':'white'); ?>"><?php echo e(__('sidebar.group')); ?></a>
                    <a href=""><?php echo e(__('sidebar.friend')); ?></a>
                    <a href=""><?php echo e(__('sidebar.schedule')); ?></a>
                </div>
                <?php endif; ?>
                <div class="collapse navbar-collapse" id="" style="flex-grow:4">
                    <!-- Left Side Of Navbar -->
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        <?php if(auth()->guard()->guest()): ?>
                        <?php if(Route::has('login')): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('login')); ?>"><?php echo e(__('Login')); ?></a>
                        </li>
                        <?php endif; ?>

                        <?php if(Route::has('register')): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('register')); ?>"><?php echo e(__('Register')); ?></a>
                        </li>
                        <?php endif; ?>
                        <?php else: ?>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <?php echo e(Auth::user()->name); ?>

                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <?php echo e(__('Logout')); ?>

                                </a>

                                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                                    <?php echo csrf_field(); ?>
                                </form>
                            </div>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
        <script>


        </script>
        <?php if(session()->has('message')): ?>
        <div class="alert alert-success" style="position:block;width:100%">
            <script>
                swal("<?php echo e(session()->get('message')); ?>", "", "success");
            </script>

        </div>
        <?php endif; ?>

        <?php if(session()->has('error')): ?>
        <div class="alert alert-danger" style="position:block;width:100%">
            <script>
                swal("<?php echo e(session()->get('error')); ?>", "", "error");
            </script>

        </div>
        <?php endif; ?>
        <main>
            <!-- Page Content -->
            <div id="page-content-wrapper">

                <?php echo $__env->yieldContent('content'); ?>
            </div>
    </div>
    </div>


    </main>
    </div>
</body>
<script>
    $(document).ready(function() {
        $('.alert').fadeIn().delay(1000).fadeOut();
    });
</script>

</html><?php /**PATH C:\xampp\htdocs\minut\resources\views/layouts/app.blade.php ENDPATH**/ ?>