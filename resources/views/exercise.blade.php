@extends('scripts')

@section('up_title', 'Categories')
@section('first_ref', 'Categories')
@section('pg_act', 'breadcrumb--active')
@section('pg_act_ex', 'side-menu--active')

<?php $add = route('exe');?>
@section('first_add',$add)

@section('main_content')

    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 xxl:col-span-9 grid grid-cols-12 gap-6">
            <!-- BEGIN: General Report -->
            <div class="col-span-12 mt-8">
                <div class="intro-y flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        Categories
                    </h2>
                    {{-- <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                        <button class="add_cat_btn button text-white bg-theme-9 shadow-md mr-2">Add Category</button>
                    </div> --}}
                    {{-- <a href="" class="ml-auto flex text-theme-1 dark:text-theme-10"> <i data-feather="refresh-ccw" class="w-4 h-4 mr-3"></i> Reload Data </a> --}}
                </div>
                <div id="cat_list" class="grid grid-cols-12 gap-6 mt-5">
                </div>
            </div>
        </div>
    </div>


    <div class="modal" id="add_cat_modal">
        <div class="modal__content">
            <div class="px-5 pb-0"><br>
               <div style="font-size:25px">Add Category</div>
            </div>
            <form id="add_cat_form">
                @csrf
                <div class="intro-y col-span-12 lg:col-span-8 p-5">
                    <div class="grid grid-cols-12 gap-4 row-gap-5">
                        <div class="intro-y col-span-12 px-2">
                            <div class="mb-2">Category Name</div>
                            <input type="text" name="cat_name" id="add_cat_id" class="input w-full border flex-1" placeholder="Category Name">
                        </div>
                    </div><br>
                </div>
                <div id="add_cat_errors">
                </div>
                <div class="px-5 pb-8 text-right">
                    <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 mr-1">Close</button>
                    <button type="submit" id="add_cat_done" class="button w-24 bg-theme-6 text-white">Add</button>
                </div>
            </form>
        </div>
    </div>

    {{-- <div class="modal" id="edit_cat_modal">
        <div class="modal__content">
            <div class="px-5 pb-0"><br>
               <div style="font-size:25px">Edit Category</div>
            </div>
            <form id="edit_school_form">
                @csrf
                <input type="hidden" id="update_val_id" name="id">
                <div class="intro-y col-span-12 lg:col-span-8 p-5">
                    <div class="grid grid-cols-12 gap-4 row-gap-5">
                        <div class="intro-y col-span-12 px-2">
                            <div class="mb-2">Category Name</div>
                            <input type="text" name="cat_name" id="edit_cat_id" class="input w-full border flex-1">
                        </div>
                    </div><br>
                    <div id="edit_cat_errors">
                    </div>
                </div>
                <div class="px-5 pb-8 text-right">
                    <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 mr-1">Close</button>
                    <button type="submit" id="edit_cat_done" class="button w-24 bg-theme-6 text-white">Update</button>
                </div>
            </form>
        </div>
    </div> --}}

    <script src="/X_SQUARE/public/plugins/toastr/toastr.min.js"></script>

      <script>

        $(document).ready(function(){

            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            $(document).on("click",".add_cat_btn",function(e){
                e.preventDefault();
                $("#add_cat_id").val("");
                $("#add_cat_modal").modal("show");
            });

            $(document).on("submit","#add_cat_form", function(event){
                event.preventDefault();
                $.ajax({
                    type:"POST",
                    url:"/X_SQUARE/public/categories/add",
                    data: $("#add_cat_form").serialize(),
                    success: function(response){
                        console.log(response);
                        $("#add_cat_modal").modal("hide");
                        toastr.success("Category Added");
                        // alert("School Added.");
                        // var table = $("#schools_table").DataTable();
                        // table.ajax.reload();
                        get_cat();
                    },
                    error: function(error){
                        // alert("School Not Added.");
                        $.each(error.responseJSON,function(key,value) {
                        toastr.error(value[0]);
                        // $("#add_subject_errors").append(`<li>`+value[0]+`</li>`);
                        });
                        console.log(error);
                    }
                });
            });


            get_cat();
            function get_cat()
            {
                $("#cat_list").empty();
                $.ajax({
                    type:"GET",
                    url:'/X_SQUARE/public/categories/show',
                }).done(function(data){
                    // console.log(data[0].cat_name)
                // console.log(data.length);
                // var vbl = data[1][1].post_content_file.split(".").pop();
                // console.log(vbl);

                for (let i = 0; i < data.length; i++) {
                    // console.log();
                    $("#cat_list").append(
                        `<a class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y" href="specific/`+data[i].id+`">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="text-3xl font-bold leading-8 mt-4 mb-4">`+data[i].cat_name+`</div>
                                </div>
                            </div>
                        </a>`
                    );
                }

                });
            }


            // $(document).on("click",".update_sch",function(){
            //     $("#update_subject_errors").empty();
            //     var id2 = $(this).val();
            //     // console.log(id2);
            //     $.ajax({
            //         type:"GET",
            //         url:'/X_SQUARE/public/schools/show/specific/',
            //         data: { id: id2,},
            //     }).done(function(data){
            //     // console.log(data);
            //     $("#edit_school_id").val(data.school_name);
            //     $("#edit_school_code").val(data.school_code);
            //     $("#edit_school_done").val(id2);
            //     $("#update_val_id").val(id2);
            //     $("#edit_school_modal").modal("show");
            //     });
            // });

            // $(document).on("submit", "#edit_school_form", function(e){
            //     e.preventDefault();
            //     $("#edit_school_errors").empty();
            //     var id = $("#edit_school_done").val();
            //     // console.log(id);

            //     $.ajax({
            //         type: 'PUT',
            //         url: '/X_SQUARE/public/schools/update/',
            //         data: $('#edit_school_form').serialize(),
            //       success: function (response){
            //         // console.log(response);
            //         $('#edit_school_modal').modal('hide');
            //         toastr.success("School Updated");
            //         // alert("Subject Updated.");
            //         var table =  $('#schools_table').DataTable();
            //         table.ajax.reload();
            //       },
            //       error: function (error){
            //         // console.log(error);
            //         $.each(error.responseJSON,function(key,value) {
            //         toastr.error(value[0]);
            //         // $("#update_subject_errors").append(`<li>`+value[0]+`</li>`);
            //         });

            //         // alert("Subject Not Updated.");
            //       }
            //     });
            // });

            // $(document).on("click", ".remove_sch", function(e){
            //   var id2 = $(this).val();
            // //   console.log(id);
            //   if(confirm("Do you want to delete this School ?")){
            //   $.ajax({
            //     type: 'DELETE',
            //     url : '/X_SQUARE/public/schools/remove',
            //     data: { id: id2,},
            //   }).done(function(data){
            //     console.log(data);
            //     toastr.success("School Deleted");
            //     // alert("School Deleted");
            //     var table =  $('#schools_table').DataTable();
            //     table.ajax.reload();
            //   });
            //   }
            // });

        });

    </script>


@endsection()

