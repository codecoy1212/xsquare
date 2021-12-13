@extends('scripts')

@section('up_title', 'Dashboard')
@section('first_ref', 'Dashboard')
@section('pg_act', 'breadcrumb--active')
@section('pg_act_da', 'side-menu--active')

<?php $add = route('dash');?>
@section('first_add',$add)

@section('main_content')

    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 xxl:col-span-9 grid grid-cols-12 gap-6">
            <!-- BEGIN: General Report -->
            <div class="col-span-12 mt-8">
                <div class="intro-y flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        Dashboard
                    </h2>
                    {{-- <a href="" class="ml-auto flex text-theme-1 dark:text-theme-10"> <i data-feather="refresh-ccw" class="w-4 h-4 mr-3"></i> Reload Data </a> --}}
                </div>
                <div class="grid grid-cols-12 gap-6 mt-5">
                    <a class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y" href="{{ route('sch') }}">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <i data-feather="user" class="report-box__icon text-theme-10"></i>
                                </div>
                                <div class="text-3xl font-bold leading-8 mt-6">Schools</div>
                                <div class="text-base text-gray-600 mt-1">{{$vbl4[0];}}</div>
                            </div>
                        </div>
                    </a>
                    <a class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y" href="{{ route('stu') }}">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <i data-feather="user" class="report-box__icon text-theme-11"></i>

                                </div>
                                <div class="text-3xl font-bold leading-8 mt-6">Students</div>
                                <div class="text-base text-gray-600 mt-1">{{$vbl4[1];}}</div>
                            </div>
                        </div>
                    </a>
                    <a class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y" href="{{ route('exe') }}">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <i data-feather="list" class="report-box__icon text-theme-12"></i>

                                </div>
                                <div class="text-3xl font-bold leading-8 mt-6">Exercises</div>
                                <div class="text-base text-gray-600 mt-1">{{$vbl4[2];}}</div>
                            </div>
                        </div>
                    </a>

                </div>
            </div>
        </div>
    </div>


@endsection()
