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
                    <div class="col-md-2">
                        <table class="table table-bordered">
                            <thead>
                                <th class="text-center">TODO</th>
                            </thead>
                            <tbody>
                                @foreach($tasksTodo as $todo)
                                    <tr class="text-center">
                                        <td>
                                            <a data-id="{{ $todo->id }}" class="open_modal" href="#form">{{ $todo->name }}</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                @endif
                @if ($tasksDoing)
                    <div class="col-md-2">
                        <table class="table table-bordered">
                            <thead>
                            <th class="text-center">DOING</th>
                            </thead>
                            <tbody>
                            @foreach($tasksDoing as $todo)
                                <tr class="text-center">
                                    <td>
                                        <a data-id="{{ $todo->id }}" class="open_modal" href="#form">{{ $todo->name }}</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>

                        </table>
                    </div>
                @endif
                @if ($tasksDone)
                    <div class="col-md-2">
                        <table class="table table-bordered">
                            <thead>
                            <th class="text-center">DONE</th>
                            </thead>
                            <tbody>
                            @foreach($tasksDone as $todo)
                                <tr class="text-center">
                                    <td>
                                        <a data-id="{{ $todo->id }}" class="open_modal" href="#form">{{ $todo->name }}</a>
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
                        <input class="name" name="title" type="text">
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
                        <button class="btn btn-info taskDataSubmit">Submit</button>
                    </div>
                </div>

                <div class="comments col-md-12">
                    <div class="createComment">
                        <input class="create" type="text">
                        <div class="col-md-12 mt-3">
                            <button class="btn btn-info">Go</button>
                        </div>
                    </div>
                    <div class="commentsAll">
                        <div class="comment-text">

                        </div>
                        <div class="comment-data">

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('click','.open_modal',function(event){
            event.preventDefault();

            var id = $(this).attr('data-id');
            var name = $('#form .name');
            var description = $('#form .description');
            var status = $('#form .status');
            var formId = $('#form .id');

            $.ajax({

                type:'POST',

                url:'/taskdata',

                dataType: 'JSON',

                data:{id: id},

                success:function(data){
                console.log(data);
                    name.val(data.task.name);
                    description.val(data.task.description);
                    status.val(data.task.status);
                    formId.val(id);

                    if(data.comments.length > 0){
                        data.comments.forEach((element) => {
                            var comments = $('.comments .all').clone();
                            comments.find('.comment-text').text(element.text);
                            comments.find('.comment-data').text(element.created_at);
                            $('.all').after(comments);
                        });
                    }
                    $.fancybox.open({
                        src  : '#form',
                        type : 'inline'
                    });
                }
            });
        });
        $(document).on('click','.taskDataSubmit',function(event){
            event.preventDefault();

            var id = $('.taskData').find ('#form .id');
            var data = {};
            $('.taskData').find ('input, select').each(function() {
                data[this.name] = $(this).val();
            });

            $.ajax({

                type:'PUT',

                url:'/updatetask',

                dataType: 'JSON',

                data:{id: id},

                success:function(data){
                    console.log(data);
                    name.val(data.task.name);
                    description.val(data.task.description);
                    status.val(data.task.status);

                    if(data.comments.length > 0){
                        data.comments.forEach((element) => {
                            var comments = $('.comments .all').clone();
                            comments.find('.comment-text').text(element.text);
                            comments.find('.comment-data').text(element.created_at);
                            $('.all').after(comments);
                        });
                    }
                }
            });
        });
    </script>

@endsection
