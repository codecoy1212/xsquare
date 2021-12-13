<!DOCTYPE html>

<html lang="en">
    <!-- BEGIN: Head -->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>X Square - @yield('up_title')</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/x-icon" href="dist/logof.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Midone admin is super flexible, powerful, clean & modern responsive tailwind admin template with unlimited possibilities.">
        <meta name="keywords" content="admin template, Midone admin template, dashboard template, flat admin template, responsive admin template, web app">
        <meta name="author" content="LEFT4CODE">
          <!-- BEGIN: CSS Assets-->
        <link rel="stylesheet" href="dist/css/app.css" />
        <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

        <!-- END: CSS Assets-->
    </head>
    <!-- END: Head -->
    <body class="app">
        <!-- BEGIN: Mobile Menu -->
        <div class="mobile-menu md:hidden">
            <div class="mobile-menu-bar">
                <a href="{{ route('dash') }}" class="flex mr-auto">
                    <div style="color: white; font-weight:bold; font-size:20px;" >X Square</div>
                </a>
                <a href="javascript:;" id="mobile-menu-toggler"> <i data-feather="bar-chart-2" class="w-8 h-8 text-white transform -rotate-90"></i> </a>
            </div>
            <ul class="border-t border-theme-24 py-5 hidden">
                <li>
                    <a href="{{ route('dash') }}" class="menu">
                        <div class="menu__icon"> <i data-feather="home"></i> </div>
                        <div class="menu__title"> Dashboard </div>
                    </a>
                </li>
               <li>
                        <a href="{{ route('sch') }}" class="menu">
                            <div class="menu__icon"> <i data-feather="users"></i> </div>
                            <div class="menu__title"> Schools </div>
                        </a>
                    </li>
                <li>
                        <a href="{{ route('stu') }}" class="menu">
                            <div class="menu__icon"> <i data-feather="file"></i> </div>
                            <div class="menu__title"> Students </div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('exe') }}" class="menu">
                            <div class="menu__icon"> <i data-feather="layout"></i> </div>
                            <div class="menu__title"> Categories </div>
                        </a>
                    </li>

            </ul>
        </div>
        <!-- END: Mobile Menu -->
        <div class="flex">
            <!-- BEGIN: Side Menu -->
            <nav class="side-nav">
                <a href="{{ route('dash') }}" class="intro-x flex items-center pl-5 pt-4">
                    <div style="color: white; font-weight:bold; font-size:20px;" >X Square</div>
                </a>
                <div class="side-nav__devider my-6"></div>
                <ul>
                    <li>
                        <a href="{{ route('dash') }}" class="side-menu @yield('pg_act_da')">
                            <div class="side-menu__icon"> <i data-feather="home"></i> </div>
                            <div class="side-menu__title"> Dashboard </div>
                        </a>
                    </li>
                  <li>
                        <a href="{{ route('sch') }}" class="side-menu @yield('pg_act_sc')">
                            <div class="side-menu__icon"> <i data-feather="users"></i> </div>
                            <div class="side-menu__title"> Schools </div>
                        </a>
                    </li>
                     <li>
                        <a href="{{ route('stu') }}" class="side-menu @yield('pg_act_st')">
                            <div class="side-menu__icon"> <i data-feather="file"></i> </div>
                            <div class="side-menu__title"> Students </div>
                        </a>
                    </li>

                   <li>
                        <a href="{{ route('exe') }}" class="side-menu @yield('pg_act_ex')">
                            <div class="side-menu__icon"> <i data-feather="layout"></i> </div>
                            <div class="side-menu__title"> Categories </div>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- END: Side Menu -->


            <!-- BEGIN: Content -->
            <div class="content">
                <!-- BEGIN: Top Bar -->
                <div class="top-bar">
                    <!-- BEGIN: Breadcrumb -->
                    <div class="-intro-x breadcrumb mr-auto hidden sm:flex">
                        <a href="{{ route('dash') }}" class="">X Sqaure &nbsp;</a>
                        <a href="@yield('first_add')" class="@yield('pg_act')">@yield('first_ref') &nbsp;</a>
                        <a href="@yield('second_add')" class="@yield('pg_act_2')">@yield('second_ref') &nbsp;</a>
                        <a href="@yield('third_add')" class="@yield('pg_act_3')">@yield('third_ref') &nbsp;</a>
                    </div>
                    <!-- END: Breadcrumb -->


                    <!-- BEGIN: Account Menu -->
                    <div class="intro-x dropdown w-8 h-8 relative ml-auto">
                        <div class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in">
                            <img alt="admin" src="/X_SQUARE/public/dist/images/profile-2.jpg">
                        </div>
                        <div class="dropdown-box mt-10 absolute w-56 top-0 right-0 z-20">
                            <div class="dropdown-box__content box bg-theme-1 dark:bg-dark-6 text-white">
                                <div class="p-4 border-b dark:border-dark-3">
                                    <div class="font-medium">Admin</div>
                                </div>
                                {{-- <div class="p-2">
                                    <a href="profile.php" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md"> <i data-feather="user" class="w-4 h-4 mr-2"></i> Profile </a>
                                </div> --}}
                                <div class="p-2 dark:border-dark-3">
                                    <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md"> <i data-feather="toggle-right" class="w-4 h-4 mr-2"></i> Logout </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END: Account Menu -->
                </div>
                <!-- END: Top Bar -->

            @yield('main_content')

            </div>
            <!-- END: Content -->
        </div>
        <script src="dist/js/app.js"></script>
        <!-- END: JS Assets-->
    </body>
</html>
