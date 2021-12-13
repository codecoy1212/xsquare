@extends('scripts')

@section('up_title', $vbl2->exe_name)
@section('pg_act_ex', 'side-menu--active')
@section('second_ref', $vbl1->cat_name)
@section('first_ref', 'Categories')
@section('pg_act_3', 'breadcrumb--active')
@section('third_ref', $vbl2->exe_name)

<?php $vbl = $vbl2;?>

<?php $add = route('exe');?>
@section('first_add',$add)

<?php $add2 = route('spe',['id' => $vbl1->id]);?>
@section('second_add',$add2)

<?php $add3 = route('ans',['id1' => $vbl1->id,'id2' => $vbl2->id]);?>
@section('first_add',$add3)

@section('main_content')

<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto ml-2">
       {{$vbl2->exe_name}} Questions
    </h2>
    <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
        <button class="add_que_btn button text-white bg-theme-9 shadow-md mr-2">Add Question</button>
    </div>
</div>
<!-- BEGIN: Datatable -->
<div class="intro-y datatable-wrapper box p-5 mt-5">
    <table id="questions_table" class="table table-report table-report--bordered display w-full">
        <thead>
            <tr>
                <th class="border-b-2 whitespace-no-wrap">Question</th>

                <th class="border-b-2 whitespace-no-wrap">Option 1</th>
                <th class="border-b-2 whitespace-no-wrap">Option 2</th>
                <th class="border-b-2 whitespace-no-wrap">Option 3</th>
                <th class="border-b-2 whitespace-no-wrap">Option 4</th>
                <th class="border-b-2 whitespace-no-wrap">Answer</th>
                <th class="border-b-2 whitespace-no-wrap">YT Link</th>
                <th class="border-b-2 whitespace-no-wrap">Text Sol</th>
                <th class="border-b-2 whitespace-no-wrap">Image Sol</th>
                <th class="border-b-2 whitespace-no-wrap">Actions</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
<!-- END: Datatable -->


<div class="modal" id="add_que_modal">
    <div class="modal__content">
        <div class="px-5 pb-0"><br>
           <div style="font-size:25px">Add Question</div>
        </div>
        <form id="add_que_form">
            @csrf
            <div class="intro-y col-span-12 lg:col-span-8 p-5">
                <div class="grid grid-cols-12 gap-4 row-gap-5">
                    <div class="intro-y col-span-12 px-2">
                        <div class="mb-2">Question</div>
                        <input type="text" name="q_name" id="add_que_id" class="input w-full border flex-1" placeholder="Enter Question">
                    </div>
                </div><br>
                <div class="grid grid-cols-12 gap-4 row-gap-5">
                    <div class="intro-y col-span-6 px-2">
                        <div class="mb-2">Option 1</div>
                        <input type="text" name="opt_1" id="add_opt1_id" class="input w-full border flex-1" placeholder="Enter Option 1">
                    </div>
                    <div class="intro-y col-span-6 px-2">
                        <div class="mb-2">Option 2</div>
                        <input type="text" name="opt_2" id="add_opt2_id" class="input w-full border flex-1" placeholder="Enter Option 2">
                    </div>
                    <div class="intro-y col-span-6 px-2">
                        <div class="mb-2">Option 3</div>
                        <input type="text" name="opt_3" id="add_opt3_id" class="input w-full border flex-1" placeholder="Enter Option 3">
                    </div>
                    <div class="intro-y col-span-6 px-2">
                        <div class="mb-2">Option 4</div>
                        <input type="text" name="opt_4" id="add_opt4_id" class="input w-full border flex-1" placeholder="Enter Option 4">
                    </div>
                </div><br>
                <div class="grid grid-cols-12 gap-4 row-gap-5">
                    <div class="intro-y col-span-6 px-2">
                        <div class="mb-2">Choose Right Option</div>
                        <input type="radio" name="rit_ans" id="add_rit_id1" class="input w-full border flex-1" value="1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="rit_ans" id="add_rit_id2" class="input w-full border flex-1" value="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="rit_ans" id="add_rit_id3" class="input w-full border flex-1" value="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="rit_ans" id="add_rit_id4" class="input w-full border flex-1" value="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>
                    <div class="intro-y col-span-6 px-2">
                        <div class="mb-2">Youtube Link</div>
                        <input type="text" name="yt_link" id="add_yt_link_id" class="input w-full border flex-1" placeholder="Enter Youtube Link">
                    </div>
                    <div class="intro-y col-span-6 px-2">
                        <div class="mb-2">Image Solution</div>
                        <input type="file" name="img_sol_file" id="add_img_sol_id" class="input w-full border flex-1">
                    </div>
                </div><br>
                <div class="grid grid-cols-12 gap-4 row-gap-5">
                    <div class="intro-y col-span-12 px-2">
                        <div class="mb-2">Text Solution</div>
                        <textarea id="w3review" name="ta_input" rows="6" cols="38">
                        </textarea>
                    </div>
                </div><br>
            </div>
            <div id="add_que_errors">
            </div>
            <div class="px-5 pb-8 text-right">
                <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 mr-1">Close</button>
                <button type="submit" id="add_que_done" class="button w-24 bg-theme-6 text-white">Add</button>
            </div>
        </form>
    </div>
</div>

{{-- SHOW IMAGE SOLUTION MODAL --}}
<div class="modal" id="s_img_modal">
    <div class="modal__content">
        <div class="px-5 pb-0"><br>
           <div style="font-size:25px">Image Solution</div>
        </div>
            <div class="intro-y col-span-12 lg:col-span-8 p-5">
                <div id="s_img"></div>
            </div>
            <div class="px-5 pb-8 text-right">
                <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 mr-1">Close</button>
            </div>
    </div>
</div>

{{-- SHOW TEXT SOLUTION MODAL --}}
<div class="modal" id="s_text_modal">
    <div class="modal__content">
        <div class="px-5 pb-0"><br>
           <div style="font-size:25px">Text Solution</div>
        </div>
            <div class="intro-y col-span-12 lg:col-span-8 p-5">
                <div id="s_text"></div>
            </div>
            <div class="px-5 pb-8 text-right">
                <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 mr-1">Close</button>
            </div>
    </div>
</div>


<div class="modal" id="edit_que_modal">
    <div class="modal__content">
        <div class="px-5 pb-0"><br>
           <div style="font-size:25px">Edit Question</div>
        </div>
        <form id="edit_que_form">
            @csrf
            <input type="hidden" name="id" id="update_val_id">
            <div class="intro-y col-span-12 lg:col-span-8 p-5">
                <div class="grid grid-cols-12 gap-4 row-gap-5">
                    <div class="intro-y col-span-12 px-2">
                        <div class="mb-2">Question</div>
                        <input type="text" name="q_name" id="edit_que_id" class="input w-full border flex-1" placeholder="Enter Question">
                    </div>
                </div><br>
                <div class="grid grid-cols-12 gap-4 row-gap-5">
                    <div class="intro-y col-span-6 px-2">
                        <div class="mb-2">Option 1</div>
                        <input type="text" name="opt_1" id="edit_opt1_id" class="input w-full border flex-1" placeholder="Enter Option 1">
                    </div>
                    <div class="intro-y col-span-6 px-2">
                        <div class="mb-2">Option 2</div>
                        <input type="text" name="opt_2" id="edit_opt2_id" class="input w-full border flex-1" placeholder="Enter Option 2">
                    </div>
                    <div class="intro-y col-span-6 px-2">
                        <div class="mb-2">Option 3</div>
                        <input type="text" name="opt_3" id="edit_opt3_id" class="input w-full border flex-1" placeholder="Enter Option 3">
                    </div>
                    <div class="intro-y col-span-6 px-2">
                        <div class="mb-2">Option 4</div>
                        <input type="text" name="opt_4" id="edit_opt4_id" class="input w-full border flex-1" placeholder="Enter Option 4">
                    </div>
                </div><br>
                <div class="grid grid-cols-12 gap-4 row-gap-5">
                    <div class="intro-y col-span-6 px-2">
                        <div class="mb-2">Choose Right Option</div>
                        <input type="radio" name="rit_ans" id="edit_rit_id1" class="input w-full border flex-1" value="1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="rit_ans" id="edit_rit_id2" class="input w-full border flex-1" value="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="rit_ans" id="edit_rit_id3" class="input w-full border flex-1" value="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="rit_ans" id="edit_rit_id4" class="input w-full border flex-1" value="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>
                    <div class="intro-y col-span-6 px-2">
                        <div class="mb-2">Youtube Link</div>
                        <input type="text" name="yt_link" id="edit_yt_link_id" class="input w-full border flex-1" placeholder="Enter Youtube Link">
                    </div>
                    <div class="intro-y col-span-6 px-2">
                        <div class="mb-2">Image Solution</div>
                        <input type="file" name="img_sol_file" id="edit_img_sol_id" class="input w-full border flex-1">
                    </div>
                </div><br>
                <div class="grid grid-cols-12 gap-4 row-gap-5">
                    <div class="intro-y col-span-12 px-2">
                        <div class="mb-2">Text Solution</div>
                        <textarea id="edit_ta_id" name="ta_input" rows="6" cols="38">
                        </textarea>
                    </div>
                </div><br>
            </div>
            <div id="edit_que_errors">
            </div>
            <div class="px-5 pb-8 text-right">
                <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 mr-1">Close</button>
                <button type="submit" id="edit_que_done" class="button w-24 bg-theme-6 text-white">Add</button>
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

        $(document).on("click",".add_que_btn",function(e){
            $("#add_que_id").val("");
            $("#add_yt_link_id").val("");
            $("#add_opt1_id").val("");
            $("#add_opt2_id").val("");
            $("#add_opt3_id").val("");
            $("#add_opt4_id").val("");
            $("#w3review").val("");
            e.preventDefault();
            $("#add_que_modal").modal("show");


        });

        $(document).on("submit","#add_que_form", function(event){
            event.preventDefault();
            var cat_id = "<?php echo $vbl1->id; ?>";
            var exe_id = "<?php echo $vbl2->id; ?>";

            var form = $('#add_que_form')[0];
            var formData = new FormData(form);

            // console.log(id1);
            $.ajax({
                type:"POST",
                url:'/X_SQUARE/public/categories/specific/'+cat_id+'/exercise/'+exe_id+'/questions/add',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response){
                    console.log(response);
                    $("#add_que_modal").modal("hide");
                    toastr.success("Question Added");
                    // alert("School Added.");
                    var table = $("#questions_table").DataTable();
                    table.ajax.reload();
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

        $('#questions_table').DataTable({
            "processing": false,
            "serverSide": false,
            "responsive": true,
            "autoWidth": false,
            "ajax": '/X_SQUARE/public/categories/specific/'+<?php echo $vbl1->id; ?>+'/exercise/'+<?php echo $vbl2->id; ?>+'/questions/show',
            "columns": [

            { "data": "que_title" },
            { "data": "option_1" },
            { "data": "option_2" },
            { "data": "option_3" },
            { "data": "option_4" },
            { "data": "right_ans" },
            { "data": "yt_link" },
            { "data": "t_sol" },
            { "data": "i_sol" },
            { "data": "actions" },
        ]
        });

        $(document).on("click",".open_i_sol",function(){
                var id10 = $(this).val();
                // console.log(id);
                $.ajax({
                    type:"GET",
                    url:'/X_SQUARE/public/categories/specific/'+<?php echo $vbl1->id; ?>+'/exercise/'+<?php echo $vbl2->id; ?>+'/questions/show/specific',
                    data: { id:id10,},
                }).done(function(data){
                // console.log(data);
                document.getElementById('s_img').innerHTML = '<img src="/X_SQUARE/public/storage/image_solutions/'+data.img_sol+'" alt="Solution not available.">';
                $("#s_img_modal").modal("show");
                });
        });

        $(document).on("click",".open_t_sol",function(){
                var id10 = $(this).val();
                // console.log(id);
                $.ajax({
                    type:"GET",
                    url:'/X_SQUARE/public/categories/specific/'+<?php echo $vbl1->id; ?>+'/exercise/'+<?php echo $vbl2->id; ?>+'/questions/show/specific',
                    data: { id:id10,},
                }).done(function(data){
                // console.log(data);
                document.getElementById('s_text').innerHTML = '<textarea rows="6" cols="38">'+data.text_sol+'</textarea>';
                $("#s_text_modal").modal("show");
                });
        });

        $(document).on("click",".update_que",function(){
            $("#edit_que_errors").empty();
            var curr_id = $(this).val();
            // console.log(curr_id);

            $.ajax({
                type:"GET",
                url:'/X_SQUARE/public/categories/specific/'+<?php echo $vbl1->id; ?>+'/exercise/'+<?php echo $vbl2->id; ?>+'/questions/show/specific/new',
                data: { id:curr_id,},
            }).done(function(data){
            console.log(data);
            $("#edit_que_id").val(data.que_title);
            $("#edit_opt1_id").val(data.option_1);
            $("#edit_opt2_id").val(data.option_2);
            $("#edit_opt3_id").val(data.option_3);
            $("#edit_opt4_id").val(data.option_4);
            $("#edit_yt_link_id").val(data.yt_link);
            $("#edit_ta_id").val(data.text_sol);
            $("#edit_que_modal").modal("show");
            $("#edit_que_done").val(data.id);
            $("#update_val_id").val(data.id);

            $("input[type=radio]:checked").removeAttr('checked');
            $("#edit_rit_id"+data.right_ans).attr('checked',true);
            });
        });

        $(document).on("submit", "#edit_que_form", function(e){
            e.preventDefault();
            $("#edit_exe_errors").empty();
            var id = $("#edit_que_done").val();
            // console.log(id);

            var form = $('#edit_que_form')[0];
            var formData = new FormData(form);

            $.ajax({
                type:"POST",
                url:'/X_SQUARE/public/categories/specific/'+<?php echo $vbl1->id; ?>+'/exercise/'+<?php echo $vbl2->id; ?>+'/questions/update',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response){
                    console.log(response);
                    $("#edit_que_modal").modal("hide");
                    toastr.success("Question Updated");
                    // alert("School Added.");
                    var table = $("#questions_table").DataTable();
                    table.ajax.reload();
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

        $(document).on("click", ".remove_que", function(e){
          var curr_id = $(this).val();
        //   console.log(id);
          if(confirm("Do you want to delete this Question ?")){
          $.ajax({
            type: 'DELETE',
            url : '/X_SQUARE/public/categories/specific/'+<?php echo $vbl1->id; ?>+'/exercise/'+<?php echo $vbl2->id; ?>+'/questions/remove',
            data: { id: curr_id,},
          }).done(function(data){
            console.log(data);
            toastr.success("Question Deleted");
            // alert("School Deleted");
            var table =  $('#questions_table').DataTable();
            table.ajax.reload();
          });
          }
        });

    });

</script>


@endsection()

