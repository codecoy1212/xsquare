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
    <table id="students_table" class="table table-report table-report--bordered display w-full">
        <thead>
            <tr>
                <th class="border-b-2 whitespace-no-wrap">ID</th>

                <th class="border-b-2 text-center whitespace-no-wrap">Picture</th>

                <th class="border-b-2 whitespace-no-wrap">Name</th>

                <th class="border-b-2 whitespace-no-wrap">Email</th>

                <th class="border-b-2 whitespace-no-wrap">School</th>

                <th class="border-b-2 whitespace-no-wrap">Actions</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
<!-- END: Datatable -->

<script src="{{asset('plugins/toastr/toastr.min.js')}}"></script>


<script>

    $(document).ready(function(){

        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        $('#students_table').DataTable({
            "processing": false,
            "serverSide": false,
            "responsive": true,
            "autoWidth": false,
            "ajax": "students/show",
            "columns": [

            { "data": "id" },
            { "data": "student_pic" },
            { "data": "stu_name" },
            { "data": "stu_email" },
            { "data": "school_name" },
            { "data": "actions" },

        ]
        });

        $(document).on("click", ".remove_stu", function(e){
          var id2 = $(this).val();
        //   console.log(id);
          if(confirm("Do you want to delete this School ?")){
          $.ajax({
            type: 'DELETE',
            url : 'students/remove',
            data: { id: id2,},
          }).done(function(data){
            console.log(data);
            toastr.success("Student Removed.");
            // alert("School Deleted");
            var table =  $('#students_table').DataTable();
            table.ajax.reload();
          });
          }
        });

    });

</script>


@endsection()

