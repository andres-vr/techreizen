<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

  
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Laravel')); ?></title>


    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

   
    <?php echo app('Illuminate\Foundation\Vite')(['resources/sass/app.scss', 'resources/js/app.js','resources/css/app.css']); ?>
    
    <style>
        body {
            padding-top: 160px; 
        }
        .carousel-container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
        }
        .carousel-item img {
            width: 100%;
            height: auto;
            max-height: 200px;
            object-fit: contain;
        }
    </style>
</head>

<body>
    <!-- ENKEL DEZE fixed-top DIV HOUDEN -->
    <div class="fixed-top" style="z-index: 100; background: white;">
        <div class="d-flex flex-row bg-light">
            <div class="p-2"><img src="<?php echo e(asset('images/ucll_logo.png')); ?>" class="rounded" alt="logo ucll"></div>
            <div class="d-flex flex-column">
                <div class="pt-3">
                    <h1 class="text-danger">TECHNOLOGIE</h1>
                </div>
                <div class="pb-1">
                    <h3 class="text-success">internationalisering - studiereizen</h3>
                </div>
            </div>
        </div>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="<?php echo e(url('/home')); ?>" 
                   style="padding: 5px; color: black; white-space: nowrap; display: inline-block;">
                    <?php
                        $page = DB::table("pages")->find(1);
                        echo $page->name;
                    ?>
                </a>
                <a class="navbar-brand" href="<?php echo e(url('/voorbeeldreizen')); ?>" 
                   style="padding: 5px; color: black; white-space: nowrap; display: inline-block;">
                   <?php
                        $page = DB::table("pages")->find(2);
                        echo $page->name;
                    ?>
                </a>
                <a class="navbar-brand" href="<?php echo e(url('/home')); ?>" 
                   style="padding: 5px; color: black; white-space: nowrap; display: inline-block;">
                    <?php
                        $page = DB::table("pages")->find(3);
                        echo $page->name;
                    ?>
                </a>
                <a class="navbar-brand" href="<?php echo e(url('/home')); ?>" 
                   style="padding: 5px; color: black; white-space: nowrap; display: inline-block;">
                   <?php
                   if(Auth::user()){
                        echo Auth::user()->name;
                   }
                   ?>
                </a>
                


                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="<?php echo e(__('Toggle navigation')); ?>">
                    <span class="navbar-toggler-icon"></span>
                </button> 

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto">
                        <?php if(auth()->guard()->guest()): ?>
                            <?php if(Route::has('login')): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo e(route('login')); ?>"><?php echo e(__('inloggen')); ?></a>
                                </li>
                            <?php endif; ?>
                        <?php else: ?>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                   data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <?php echo e(Auth::user()->name); ?>

                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"
                                       onclick="event.preventDefault();
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
    </div>

<!-- Carrousel -->
<?php if(request()->routeIs('home')): ?> <!-- Carrousel alleen op de homepagina -->
    <div class="carousel-container mt-3">
        <div id="images" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="<?php echo e(asset('images/header1.jpg')); ?>" alt="header 1" class="img-fluid">
                </div>
                <div class="carousel-item">
                    <img src="<?php echo e(asset('images/header2.jpg')); ?>" alt="header 2" class="img-fluid">
                </div>
                <div class="carousel-item">
                    <img src="<?php echo e(asset('images/header3.jpg')); ?>" alt="header 3" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

    <!-- Main content -->
    <main class="container py-4" style="margin-top: 20px;">
        <?php echo e($slot); ?>

    </main>
</body>
</html><?php /**PATH C:\Users\ainsw\Downloads\ICTProject\laragon\www\techreizen\resources\views/components/layout/home.blade.php ENDPATH**/ ?>