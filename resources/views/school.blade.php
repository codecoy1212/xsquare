@extends('scripts')

@section('up_title', 'Schools')
@section('first_ref', 'Schools')
@section('pg_act', 'breadcrumb--active')
@section('pg_act_sc', 'side-menu--active')

<?php $add = route('sch');?>
@section('first_add',$add)

@section('main_content')

<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto ml-2">
        List of Schools
    </h2>
    <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
        <button class="add_school_btn button text-white bg-theme-9 shadow-md mr-2">Add School</button>
    </div>
</div>
<!-- BEGIN: Datatable -->
<div class="intro-y datatable-wrapper box p-5 mt-5">
    <table id="schools_table" class="table table-report table-report--bordered display w-full">
        <thead>
            <tr>
                <th class="border-b-2 whitespace-no-wrap">School ID</th>

                <th class="border-b-2 whitespace-no-wrap">School Name</th>

                <th class="border-b-2 whitespace-no-wrap">School Code</th>

                <th class="border-b-2 whitespace-no-wrap">Actions</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<!-- END: Datatable -->


<div class="modal" id="add_school_modal">
    <div class="modal__content">
        <div class="px-5 pb-0"><br>
           <div style="font-size:25px">Add School</div>
        </div>
        <form id="add_school_form">
            @csrf
            <div class="intro-y col-span-12 lg:col-span-8 p-5">
                <div class="grid grid-cols-12 gap-4 row-gap-5">
                    <div class="intro-y col-span-12 px-2">
                        <div class="mb-2">School Name</div>
                        <input type="text" name="school_name" id="add_school_id" class="input w-full border flex-1" placeholder="School Name">
                    </div>
                </div><br>
                <div class="grid grid-cols-12 gap-4 row-gap-5">
                    <div class="intro-y col-span-6 px-2">
                        <div class="mb-2">School Code (Only 4 Digits)</div>
                        <input type="text" name="school_code" id="add_school_code" class="input w-full border flex-1" placeholder="School Code">
                    </div>
                    <div class="intro-y col-span-6 px-2">
                        <button class="auto_gen button text-white bg-theme-11 shadow-md" style="margin-top: 29px">Auto Generate</button>
                    </div>
                </div><br>
            </div>
            <div id="add_school_errors">
            </div>
            <div class="px-5 pb-8 text-right">
                <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 mr-1">Close</button>
                <button type="submit" id="add_school_done" class="button w-24 bg-theme-6 text-white">Add</button>
            </div>
        </form>
    </div>
</div>

<div class="modal" id="edit_school_modal">
    <div class="modal__content">
        <div class="px-5 pb-0"><br>
           <div style="font-size:25px">Edit School</div>
        </div>
        <form id="edit_school_form">
            @csrf
            <input type="hidden" id="update_val_id" name="id">
            <div class="intro-y col-span-12 lg:col-span-8 p-5">
                <div class="grid grid-cols-12 gap-4 row-gap-5">
                    <div class="intro-y col-span-12 px-2">
                        <div class="mb-2">School Name</div>
                        <input type="text" name="school_name" id="edit_school_id" class="input w-full border flex-1">
                    </div>
                </div><br>
                <div class="grid grid-cols-12 gap-4 row-gap-5">
                    <div class="intro-y col-span-6 px-2">
                        <div class="mb-2">School Code (Only 4 Digits)</div>
                        <input type="text" name="school_code" id="edit_school_code" class="input w-full border flex-1">
                    </div>
                    <div class="intro-y col-span-6 px-2">
                        <button class="auto_gen button text-white bg-theme-11 shadow-md" style="margin-top: 29px">Auto Generate</button>
                    </div>
                </div><br>
                <div id="edit_school_errors">
                </div>
            </div>
            <div class="px-5 pb-8 text-right">
                <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 mr-1">Close</button>
                <button type="submit" id="edit_school_done" class="button w-24 bg-theme-6 text-white">Update</button>
            </div>
        </form>
    </div>
</div>

<script src="/X_SQUARE/public/plugins/toastr/toastr.min.js"></script>

  <script>

    $(document).ready(function(){

        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        $(document).on("click",".auto_gen",function(e){
            e.preventDefault();
            var code = Math.floor(Math.random() * (9999 - 1000 + 1) ) + 1000;
            $("#add_school_code").val(code);
            $("#edit_school_code").val(code);

        });

        $(document).on("click",".add_school_btn",function(e){

            $("#add_school_id").val("");
            $("#add_school_code").val("");
            e.preventDefault();
            $("#add_school_modal").modal("show");
        });

        $(document).on("submit","#add_school_form", function(event){
            event.preventDefault();
            $.ajax({
                type:"POST",
                url:"/X_SQUARE/public/schools/add",
                data: $("#add_school_form").serialize(),
                success: function(response){
                    // console.log(response);
                    $("#add_school_modal").modal("hide");
                    toastr.success("School Added");
                    // alert("School Added.");
                    var table = $("#schools_table").DataTable();
                    table.ajax.reload();
                },
                error: function(error){
                    // alert("School Not Added.");
                    $.each(error.responseJSON,function(key,value) {
                    toastr.error(value[0]);
                    // $("#add_subject_errors").append(`<li>`+value[0]+`</li>`);
                    });
                    // console.log(error);
                }
            });
        });

        $('#schools_table').DataTable({
            "processing": false,
            "serverSide": false,
            "responsive": true,
            "autoWidth": false,
            "ajax": "/X_SQUARE/public/schools/show",
            "columns": [

            { "data": "id" },
            { "data": "school_name" },
            { "data": "school_code" },
            { "data": "actions" },

        ]
        });

        $(document).on("click",".update_sch",function(){
            $("#update_subject_errors").empty();
            var id2 = $(this).val();
            // console.log(id2);
            $.ajax({
                type:"GET",
                url:'/X_SQUARE/public/schools/show/specific/',
                data: { id: id2,},
            }).done(function(data){
            // console.log(data);
            $("#edit_school_id").val(data.school_name);
            $("#edit_school_code").val(data.school_code);
            $("#edit_school_done").val(id2);
            $("#update_val_id").val(id2);
            $("#edit_school_modal").modal("show");
            });
        });

        $(document).on("submit", "#edit_school_form", function(e){
            e.preventDefault();
            $("#edit_school_errors").empty();
            var id = $("#edit_school_done").val();
            // console.log(id);

            $.ajax({
                type: 'PUT',
                url: '/X_SQUARE/public/schools/update/',
                data: $('#edit_school_form').serialize(),
              success: function (response){
                // console.log(response);
                $('#edit_school_modal').modal('hide');
                toastr.success("School Updated");
                // alert("Subject Updated.");
                var table =  $('#schools_table').DataTable();
                table.ajax.reload();
              },
              error: function (error){
                // console.log(error);
                $.each(error.responseJSON,function(key,value) {
                toastr.error(value[0]);
                // $("#update_subject_errors").append(`<li>`+value[0]+`</li>`);
                });

                // alert("Subject Not Updated.");
              }
            });
        });

        $(document).on("click", ".remove_sch", function(e){
          var id2 = $(this).val();
        //   console.log(id);
          if(confirm("Do you want to delete this School ?")){
          $.ajax({
            type: 'DELETE',
            url : '/X_SQUARE/public/schools/remove',
            data: { id: id2,},
          }).done(function(data){
            console.log(data);
            toastr.success("School Deleted");
            // alert("School Deleted");
            var table =  $('#schools_table').DataTable();
            table.ajax.reload();
          });
          }
        });

    });

</script>


@endsection()

