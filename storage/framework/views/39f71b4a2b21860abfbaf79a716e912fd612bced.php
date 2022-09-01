<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- CSRF Token -->
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

<title>Minut</title>
<link rel="icon" href="<?php echo e(asset('/storage/image/icon.png')); ?>" type="image/icon type">

<!-- Scripts -->
<script src="<?php echo e(asset('js/app.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('/storage/js/jquery.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('/storage/js/printThis.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('/storage/js/sweetalert.min.js')); ?>"></script>

<!-- Fonts -->
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="<?php echo e(asset('/storage/css/fonts/nunito.css')); ?>" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<!-- Styles -->
<link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">

<!-- sidebar -->
<link type="text/css" rel="stylesheet" href="<?php echo e(asset('/storage/css/sidebar.css')); ?>" />
<link type="text/css" rel="stylesheet" href="<?php echo e(asset('/storage/css/custom.css')); ?>" />

<script type="text/javascript" src="<?php echo e(asset('/storage/js/datatables.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('/storage/js/basic.js')); ?>"></script>


<link rel="stylesheet" href="<?php echo e(asset('/storage/css/icons/icomoon/styles.min.css')); ?>">


<!-- bootstrap -->
<script src="<?php echo e(asset('/storage/js/dataTables.bootstrap5.min.js')); ?>"></script>

<link rel="stylesheet" href="<?php echo e(asset('/storage/css/bootstrap/bootstrap.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('/storage/css/bootstrap/dataTables.bootstrap5.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('/storage/css/bootstrap/bootstrap.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('/storage/css/bootstrap/font-awesome.min.css')); ?>">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

<style>
    .alert_position {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        width: fit-content;
        height: 50px;
        margin: auto;
    }
</style>
</head>

<body class="bg">

    <div id="app" class="d-flex">
        <?php if(Auth::user()): ?>

        <nav class="sidenav d-flex flex-column font-regular align-items-center" style="gap:70px;">

            <a href="<?php echo e(route('groups.index')); ?>" class="d-flex align-items-center justify-content-center" style="width:max-content;"><img src=" <?php echo e(asset('/storage/image/icon.png')); ?>" alt="icon.svg" style="width:40px;padding-top:50px"></a>

            <div class="d-flex flex-column" style="gap:50px;width:100%" >
                <?php if(Route::is('groups.*') || Route::is('pending_agendas.*')|| Route::is('agendas.*')|| Route::is('meetings.*')): ?>
                <a href="<?php echo e(route('groups.index')); ?>" class="d-flex align-items-center justify-content-center " style="width:100%;border-left:5px solid #007bff">
                    <i class="bi bi-house-door" style="font-size:40px;color:#007bff"></i></a>
                <?php else: ?>
                <a href="<?php echo e(route('groups.index')); ?>" class="d-flex align-items-center justify-content-center " style="width:100%">
                    <i class="bi bi-house-door" style="font-size:40px;color:black"></i></a>
                <?php endif; ?>

                <a href="<?php echo e(route('meeting_schedule.meeting_schedule')); ?>" class="d-flex align-items-center justify-content-center " style="width:100%;<?php echo e(Route::is('meeting_schedule.*')?'border-left:5px solid #007bff':''); ?>"><i class="bi bi-calendar" style="font-size:40px;color:<?php echo e(Route::is('meeting_schedule.*')?'#007bff':'black'); ?>;"></i></a>

                <a href="<?php echo e(route('settings.index')); ?>" class="d-flex align-items-center justify-content-center " style="width:100%;<?php echo e(Route::is('settings.*')?'border-left:5px solid #007bff':''); ?>"><i class="bi bi-gear" style="font-size:40px;color:<?php echo e(Route::is('settings.*')?'#007bff':'black'); ?>"></i>
                </a>
                <a href="<?php echo e(route("invitation.invitation")); ?>" class="d-flex align-items-center justify-content-center " style="width:100%;<?php echo e(Route::is('invitation.*')?'border-left:5px solid #007bff':''); ?>"><i class="bi bi-bell" style="font-size:40px;color:<?php echo e(Route::is('invitation.*')?'#007bff':'black'); ?>"></i>
                    <div class="align-self-start justify-content-center" style="color:white;background-color:red;border:1px solid white;border-radius:100%;width:25px;height:25px;display:none" id="notification">0</div>
                </a>
            </div>

        </nav>

        <?php endif; ?>
        <main style="width:100%;">
            <?php echo $__env->yieldContent('content'); ?>
        </main>


        <?php if(session()->has('message')): ?>
        <div class="alert alert-success alert-dismissible alert_position" role="alert" style="text-align:center">
            <button type="button" class="close" data-dismiss="alert" style="display:none">&times;</button>
            <strong><?php echo e(session()->get('message')); ?></strong>
        </div>
        <script>
            setTimeout(function() {
                $(".close").click();
            }, 1000);
        </script>


        <?php endif; ?>

        <?php if(session()->has('error')): ?>

        <div class="alert alert-danger alert-dismissible alert_position" role="alert" style="text-align:center">
            <button type="button" class="close" data-dismiss="alert" style="display:none">&times;</button>
            <strong><?php echo e(session()->get('error')); ?></strong>
        </div>
        <script>
            setTimeout(function() {
                $(".close").click();
            }, 1000);
        </script>

        <?php endif; ?>

    </div>
</body>
<script>
    if ($("#notification").length != 0) {

        var url = '/<?php echo e(env("base_url")); ?>' + 'notifications';
        $.ajax({
            type: "GET",
            url: url,
            success: function(data) {

                if (data != 0) {
                    $("#notification").css("display", "flex");
                    $("#notification").text(data);
                }
            },
            erros: function(data) {
                console.log(data);
            }
        });
    }
</script>

</html><?php /**PATH C:\xampp\htdocs\minut\resources\views/layouts/app.blade.php ENDPATH**/ ?>