@extends('scripts')

@section('up_title',  $vbl->cat_name)
@section('pg_act_ex', 'side-menu--active')
@section('second_ref', $vbl->cat_name)
@section('first_ref', 'Categories')
@section('pg_act_2', 'breadcrumb--active')

<?php $add = route('exe');?>
@section('first_add',$add)

<?php $add2 = route('spe',['id' => $vbl->id]);?>
@section('second_add',$add2)

@section('main_content')

<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto ml-2">
        {{$vbl->cat_name}}
    </h2>
    <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
        <button class="add_exe_btn button text-white bg-theme-9 shadow-md mr-2">Add Exercise</button>
    </div>
</div>
<!-- BEGIN: Datatable -->
<div class="intro-y datatable-wrapper box p-5 mt-5">
    <table id="exercises_table" class="table table-report table-report--bordered display w-full">
        <thead>
            <tr>
                <th class="border-b-2 whitespace-no-wrap">Exercise ID</th>

                <th class="border-b-2 whitespace-no-wrap">Exercise Name</th>

                <th class="border-b-2 whitespace-no-wrap">Actions</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
<!-- END: Datatable -->


<div class="modal" id="add_exe_modal">
    <div class="modal__content">
        <div class="px-5 pb-0"><br>
           <div style="font-size:25px">Add Exercise</div>
        </div>
        <form id="add_exe_form">
            @csrf
            <div class="intro-y col-span-12 lg:col-span-8 p-5">
                <div class="grid grid-cols-12 gap-4 row-gap-5">
                    <div class="intro-y col-span-12 px-2">
                        <div class="mb-2">Exercise Name</div>
                        <input type="text" name="exe_name" id="add_exe_id" class="input w-full border flex-1" placeholder="Exercise Name">
                    </div>
                </div><br>
            </div>
            <div id="add_exe_errors">
            </div>
            <div class="px-5 pb-8 text-right">
                <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 mr-1">Close</button>
                <button type="submit" id="add_exe_done" class="button w-24 bg-theme-6 text-white">Add</button>
            </div>
        </form>
    </div>
</div>

<div class="modal" id="edit_exe_modal">
    <div class="modal__content">
        <div class="px-5 pb-0"><br>
           <div style="font-size:25px">Edit Exercise</div>
        </div>
        <form id="edit_exe_form">
            @csrf
            <input type="hidden" id="update_val_id" name="id">
            <div class="intro-y col-span-12 lg:col-span-8 p-5">
                <div class="grid grid-cols-12 gap-4 row-gap-5">
                    <div class="intro-y col-span-12 px-2">
                        <div class="mb-2">Exercise Name</div>
                        <input type="text" name="exe_name" id="edit_exe_id" class="input w-full border flex-1">
                    </div>
                </div><br>
                <div id="edit_exe_errors">
                </div>
            </div>
            <div class="px-5 pb-8 text-right">
                <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 mr-1">Close</button>
                <button type="submit" id="edit_exe_done" class="button w-24 bg-theme-6 text-white">Update</button>
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

        $(document).on("click",".add_exe_btn",function(e){
            $("#add_exe_errors").val("");
            $("#add_exe_id").val("");
            e.preventDefault();
            $("#add_exe_modal").modal("show");
        });

        $(document).on("submit","#add_exe_form", function(event){
            event.preventDefault();
            var id1 = <?php echo $vbl->id; ?>;
            console.log(id1);
            $.ajax({
                type:"POST",
                url:'/X_SQUARE/public/categories/specific/'+id1+'/exercises/add',
                data: $("#add_exe_form").serialize(),
                success: function(response){
                    // console.log(response);
                    $("#add_exe_modal").modal("hide");
                    toastr.success("Exercise Added");
                    // alert("School Added.");
                    var table = $("#exercises_table").DataTable();
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

        $('#exercises_table').DataTable({
            "processing": false,
            "serverSide": false,
            "responsive": true,
            "autoWidth": false,
            "ajax": '/X_SQUARE/public/categories/specific/'+<?php echo $vbl->id; ?>+'/exercises/show',
            "columns": [

            { "data": "id" },
            { "data": "exercise_link" },
            { "data": "actions" },
        ]
        });

        $(document).on("click",".update_exe",function(){
            $("#edit_exe_errors").empty();
            var curr_id = $(this).val();
            // console.log(curr_id);
            $.ajax({
                type:"GET",
                url:'/X_SQUARE/public/categories/specific/'+<?php echo $vbl->id; ?>+'/exercises/show/specific',
                data: { id:curr_id,},
            }).done(function(data){
            // console.log(data);
            $("#edit_exe_id").val(data.exe_name);
            $("#edit_exe_modal").modal("show");
            $("#edit_exe_done").val(data.id);
            $("#update_val_id").val(data.id);
            });
        });

        $(document).on("submit", "#edit_exe_form", function(e){
            e.preventDefault();
            $("#edit_exe_errors").empty();
            var id = $("#edit_exe_done").val();
            // console.log(id);

            $.ajax({
                type: 'PUT',
                url: '/X_SQUARE/public/categories/specific/'+<?php echo $vbl->id; ?>+'/exercises/update',
                data: $('#edit_exe_form').serialize(),
              success: function (response){
                console.log(response);
                $('#edit_exe_modal').modal('hide');
                toastr.success("Exercise Updated");
                // alert("Subject Updated.");
                var table =  $('#exercises_table').DataTable();
                table.ajax.reload();
              },
              error: function (error){
                console.log(error);
                $.each(error.responseJSON,function(key,value) {
                toastr.error(value[0]);
                // $("#update_subject_errors").append(`<li>`+value[0]+`</li>`);
                });

                // alert("Subject Not Updated.");
              }
            });
        });

        $(document).on("click", ".remove_exe", function(e){
          var curr_id = $(this).val();
        //   console.log(id);
          if(confirm("Do you want to delete this Exercise ?")){
          $.ajax({
            type: 'DELETE',
            url : '/X_SQUARE/public/categories/specific/'+<?php echo $vbl->id; ?>+'/exercises/remove',
            data: { id: curr_id,},
          }).done(function(data){
            console.log(data);
            toastr.success("Exercise Deleted");
            // alert("School Deleted");
            var table =  $('#exercises_table').DataTable();
            table.ajax.reload();
          });
          }
        });

    });

</script>


@endsection()

