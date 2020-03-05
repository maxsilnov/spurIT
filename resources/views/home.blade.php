@extends('layouts.app')

@section('content')

    <div class="">
        <div class="row">
            <div class="col-md-12 mb-2">
                <h3>Tasks</h3>
            </div>
        </div>
        <div class="pb-0 tasks">
            <div class="row">
                <div class="col-md-12 text-center">
                    @if ($tasksTodo)
                        <div class="col-md-4 task-todo float-left ">
                            <table class="table table-bordered">
                                <thead>
                                    <th class="text-center">TODO</th>
                                </thead>
                                <tbody>
                                    @foreach($tasksTodo as $todo)
                                        <tr class="text-center">
                                            <td>
                                                <a data-id="{{ $todo->id }}" class="open_modal" href="#form">
                                                    <div class="name">Task: {{ $todo->name }}</div>
                                                    <div class="date-create">Date create: <div class="time">{{ $todo->created_at }}</div></div>
                                                    <div class="comments">Comments: {{ count($todo->comments) }}</div>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    @endif
                    @if ($tasksDoing)
                        <div class="col-md-4 task-doing float-left">
                            <table class="table table-bordered">
                                <thead>
                                <th class="text-center">DOING</th>
                                </thead>
                                <tbody>
                                @foreach($tasksDoing as $todo)
                                    <tr class="text-center">
                                        <td>
                                            <a data-id="{{ $todo->id }}" class="open_modal" href="#form">
                                                <div class="name">Task: {{ $todo->name }}</div>
                                                <div class="date-create">Date create: <div class="time">{{ $todo->created_at }}</div></div>
                                                <div class="comments">Comments: {{ count($todo->comments) }}</div>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>

                            </table>
                        </div>
                    @endif
                    @if ($tasksDone)
                        <div class="col-md-4 task-done float-left">
                            <table class="table table-bordered">
                                <thead>
                                <th class="text-center">DONE</th>
                                </thead>
                                <tbody>
                                @foreach($tasksDone as $todo)
                                    <tr class="text-center">
                                        <td>
                                            <a data-id="{{ $todo->id }}" class="open_modal" href="#form">
                                                <div class="name">Task: {{ $todo->name }}</div>
                                                <div class="date-create">Date create: <div class="time">{{ $todo->created_at }}</div></div>
                                                <div class="comments">Comments: {{ count($todo->comments) }}</div>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>

                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 pt-4">
        <a class="btn btn-primary create-task" href="{{ route('form') }}">Create task</a>
    </div>


    <div style="display:none">
        <div id="form">
            <div class="row">
                <div class="taskData">
                    <div class="hidden" style="display: none;">
                        <input class="id" name="id" type="text">
                    </div>
                    <div class="col-md-4">
                        <label for="name" style="display: block;">Title</label>
                        <input class="name" name="name" type="text">
                    </div>
                    <div class="col-md-4">
                        <label for="description" style="display: block;">Description</label>
                        <input name="description" class="description" type="text">
                    </div>
                    <div class="col-md-4">
                        <label for="status" style="display: block;">Status</label>
                        <select class="status" name="status">
                            <option value="TODO">TODO</option>
                            <option value="DOING">DOING</option>
                            <option value="DONE">DONE</option>
                        </select>
                    </div>
                    <div class="col-md-12 mt-3">
                        <button class="btn btn-info taskDataSubmit">Update</button>
                    </div>
                </div>

                <div class="comments col-md-12">
                    <div class="createComment">
                        <h4 class="mt-3">Add comment</h4>
                        <input class="create" name="text" type="text">
                        <div class="col-md-12 mt-3">
                            <button class="btn btn-info addComment">Go</button>
                        </div>
                    </div>
                    <div class="commentsAll"></div>
                </div>

            </div>
        </div>
    </div>

    <div style="display:none">
        <div id="form-task">
            <div class="row">
                <div class="taskData">
                    <div class="hidden" style="display: none;">
                        <input class="id" name="id" type="text">
                    </div>
                    <div class="col-md-4">
                        <label for="name" style="display: block;">Title</label>
                        <input class="name" name="name" type="text">
                    </div>
                    <div class="col-md-4">
                        <label for="description" style="display: block;">Description</label>
                        <input name="description" class="description" type="text">
                    </div>
                    <div class="col-md-4">
                        <label for="status" style="display: block;">Status</label>
                        <select class="status" name="status">
                            <option value="TODO">TODO</option>
                            <option value="DOING">DOING</option>
                            <option value="DONE">DONE</option>
                        </select>
                    </div>
                    <div class="col-md-12 mt-3">
                        <button class="btn btn-info formTaskSubmit">Create</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="hidden" style="display: none;">
    <table>
        <tbody class="task-link">
            <tr class="text-center">
                <td>
                    <a data-id="{{ $todo->id }}" class="open_modal" href="#form">
                        <div class="name">Task: {{ $todo->name }}</div>
                        <div class="date-create">Date create: <div class="time">{{ $todo->created_at }}</div></div>
                        <div class="comments">Comments: {{ count($todo->comments) }}</div>
                    </a>
                </td>
            </tr>
        </tbody>
    </table>
</div>
    <script type="text/javascript">
        $(document).ready(function(){


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var fancybox = $(".fancybox");

            $(document).on('click','.open_modal',function(event){
                event.preventDefault();

                var id = $(this).attr('data-id');
                var name = $('#form .name');
                var description = $('#form .description');
                var status = $('#form .status');
                var formId = $('#form .id');
                var commentsTemp = '';

                $.ajax({

                    type:'POST',

                    url:'/taskdata',

                    dataType: 'JSON',

                    data:{id: id},

                    success:function(data){
                        name.val(data.task.name);
                        description.val(data.task.description);
                        status.val(data.task.status);
                        formId.val(id);
                        $('.commentsAll').html('');
                        if(data.comments.length > 0){
                            data.comments.forEach((element) => {
                                commentsTemp = commentsTemp + '<div class="comment-text">' + element['text'] + '</div><div class="comment-data">' + dateFormat(element['created_at'], "UTC:yyyy-mm-dd HH:MM:ss") + '</div>';
                            });
                            // commentsClone.html(commentsTemp);
                            $('.commentsAll').html(commentsTemp);
                        }


                        $.fancybox.open({
                            src  : '#form',
                            type : 'inline',
                            opts : {
                                afterClose: function() {

                                }
                            }
                        });
                    }
                });
            });
            $(document).on('click','.taskDataSubmit',function(event){
                event.preventDefault();

                var data = {};
                $('.taskData').find('input, select').each(function() {
                    data[this.name] = $(this).val();
                });

                $.ajax({

                    type:'PUT',

                    url:'/edit',

                    dataType: 'JSON',

                    data:{data: data},

                    success:function(data){

                        alert('Success update Task');
                        checkUpdateTask(data.task.id);
                    }
                });
            });

            $(document).on('click','button.addComment',function(event){

                var idTask = $('.fancybox-container .taskData .id').val();
                var data = {};
                $('.createComment input').each(function() {
                    data[this.name] = $(this).val();
                });
                console.log(idTask);
                $.ajax({

                    type:'POST',

                    url:'/comment/create',

                    dataType: 'JSON',

                    data:{idTask: idTask, data: data},

                    success:function(data){

                        $('.createComment input').val('');
                        alert('Success add Comments');
                        $('.commentsAll').prepend('<div class="comment-text">' + data.comment['text'] + '</div><div class="comment-data">' + dateFormat(data.comment['created_at'], "UTC:yyyy-mm-dd HH:MM:ss") + '</div>')
                        checkUpdateTask(idTask);
                    }
                });
            });

            function checkUpdateTask(id){
                $.ajax({

                    type:'POST',

                    url:'/taskdata',

                    dataType: 'JSON',

                    data:{id: id},

                    success:function(data){

                        var link = $('a[data-id="' + id +'"]');
                        if(link.length >0){
                            var parent = link.parents('tr');
                        }else{
                            var parent = $('.task-link tr').clone();
                            var link = parent.find('.open_modal').attr({'data-id' : id})
                        }

                        var table = '';
                        parent.find('.name').text('Task: ' + data.task.name);
                        parent.find('.name').text('Task: ' + data.task.name);
                        parent.find('.date-create').html('Date create: <div class="time">' + dateFormat(data.task.created_at, "yyyy-mm-dd HH:MM:ss" + '</div>'));
                        parent.find('.comments').text('Comments: ' + data.comments.length);
                        var cloneTask = '';
                        switch(data.task.status) {
                            case 'TODO':
                                console.log(1);
                                cloneTask = parent.clone();
                                parent.remove();
                                table = $('.task-todo tbody');
                                break;
                            case 'DOING':
                                console.log(2);
                                cloneTask = parent.clone();
                                parent.remove();
                                table = $('.task-doing tbody');
                                break;
                            case 'DONE':
                                console.log(3);
                                cloneTask = parent.clone();
                                parent.remove();
                                table = $('.task-done tbody');
                                break;
                        }
                        if(table.find('tr').length > 0){
                            var check = 0;
                            console.log(4);
                            table.find('tr').each(function(event){
                                console.log(parseInt(dateFormat(data.task.created_at, "UTC:yyyymmddHHMMss"))); // мое
                                console.log(parseInt(dateFormat($(this).find('.time').text(), "UTC:yyyymmddHHMMss"))); // общее
                                // console.log($(this).find('.time').text());
                                if(parseInt(dateFormat(data.task.created_at, "UTC:yyyymmddHHMMss")) < parseInt(dateFormat($(this).find('.time').text(), "UTC:yyyymmddHHMMss")) ){
                                    console.log(2222);
                                    $(this).before(cloneTask);
                                    check = 1;
                                    return false;

                                }
                            });
                            if(check == 0){
                                console.log(111111);
                                table.append(cloneTask);
                            }
                        }else{
                            console.log(5);
                            table.append(cloneTask);
                        }

                    }
                });
            }
            $(document).on('click','a.create-task',function(event){
                event.preventDefault();

                $.fancybox.open({
                    src  : '#form-task',
                    type : 'inline',
                    afterClose : function( instance, current ) {
                        $.fancybox.destroy();
                    }
                });

            });


            $(document).on('click','.fancybox-container button.formTaskSubmit',function(event) {
                var name = $('#form .name');
                var description = $('#form .description');
                var status = $('#form .status');
                var formId = $('#form .id');
                var id = 0;

                var data = {};
                $('.fancybox-container .taskData').find('input, select').each(function() {
                    data[this.name] = $(this).val();
                });
                $.ajax({

                    type: 'POST',

                    url: '/create',

                    dataType: 'JSON',

                    data: {data: data},

                    success: function (data) {
                        id = data.task.id;
                        name.val(data.task.name);
                        description.val(data.task.description);
                        status.val(data.task.status);
                        formId.val(id);
                        checkUpdateTask(id);
                        alert('create');
                    }
                });
            });
        });


    </script>

@endsection
