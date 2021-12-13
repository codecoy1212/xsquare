@extends('scripts')

@section('up_title', 'Students')
@section('first_ref', 'Students')
@section('pg_act', 'breadcrumb--active')
@section('pg_act_st', 'side-menu--active')

<?php $add = route('stu');?>
@section('first_add',$add)

@section('main_content')

<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto ml-2">
        List of Students
    </h2>
    {{-- <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
        <button class="button text-white bg-theme-1 shadow-md mr-2"><a href="">Add Student</a></button>
    </div> --}}
</div>
<!-- BEGIN: Datatable -->
<div class="intro-y datatable-wrapper box p-5 mt-5">
    <table class="table table-report table-report--bordered display datatable w-full">
        <thead>
            <tr>
                <th class="border-b-2 whitespace-no-wrap">ID</th>

                <th class="border-b-2 whitespace-no-wrap">Picture</th>

                <th class="border-b-2 whitespace-no-wrap">Name</th>

                <th class="border-b-2 whitespace-no-wrap">Email</th>

                <th class="border-b-2 whitespace-no-wrap">School</th>

                <th class="border-b-2 text-center whitespace-no-wrap">Actions</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
<!-- END: Datatable -->

@endsection()

