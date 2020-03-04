@extends('layouts.app')

@section('content')

    <div class="">
        <div class="row">
            <div class="col-md-12 mb-3">
                <h3>Tasks</h3>
            </div>
        </div>
        <div class="pb-0 tasks">
            <div class="row">
                @if ($tasksTodo)
                    <div class="col-md-2 task-todo">
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
                                                <div class="date-create">Date create: {{ $todo->created_at }}</div>
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
                    <div class="col-md-2 task-doing">
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
                                            <div class="date-create">Date create: {{ $todo->created_at }}</div>
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
                    <div class="col-md-2 task-done">
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
                                            <div class="date-create">Date create: {{ $todo->created_at }}</div>
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
    <div class="col-md-4 pt-4">
        <a class="btn btn-primary" href="{{ route('form') }}">Create task</a>
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
                                    checkUpdateTask(id);
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
                    }
                });
            });

            $(document).on('click','button.addComment',function(event){

                var idTask = $('.taskData .id').val();
                var data = {};
                $('.createComment input').each(function() {
                    data[this.name] = $(this).val();
                });

                $.ajax({

                    type:'POST',

                    url:'/comment/create',

                    dataType: 'JSON',

                    data:{idTask: idTask, data: data},

                    success:function(data){
                        $('.createComment input').val('');
                        alert('Success add Comments');
                        $('.commentsAll').prepend('<div class="comment-text">' + data.comment['text'] + '</div><div class="comment-data">' + dateFormat(data.comment['created_at'], "UTC:yyyy-mm-dd HH:MM:ss") + '</div>')
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
                        var parent = link.parents('tr');
                        parent.find('.name').text('Task: ' + data.task.name);
                        parent.find('.date-create').text('Date create: ' + dateFormat(data.task.created_at, "UTC:yyyy-mm-dd HH:MM:ss"));
                        parent.find('.comments').text('Comments: ' + data.comments.length);
                        switch(data.task.status) {
                            case 'TODO':
                                var cloneTask = parent.clone();
                                parent.remove();
                                $('.task-todo tbody').prepend(cloneTask);
                                break;
                            case 'DOING':
                                var cloneTask = parent.clone();
                                parent.remove();
                                $('.task-doing tbody').prepend(cloneTask);
                                break;
                            case 'DONE':
                                var cloneTask = parent.clone();
                                parent.remove();
                                $('.task-done tbody').prepend(cloneTask);
                                break;
                        }
                    }
                });
            }

        });


    </script>

@endsection
