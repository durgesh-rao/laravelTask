@extends('layouts.admin')
@section('title')
Groups
@endsection
@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<style>
    table td
    {
        font-size: 16px;
    }
    .add, .trash 
    {
        font-size : 20px !important;
    }
</style>
<div class="card">
    <div class="card-header">
        <a class="btn btn-sm btn-primary float-right p-2 ml-2 add" href="{{ route('group.create')}}">
            <i class="fa fa-plus"></i> Add Group
        </a>

        <a class="btn btn-sm btn-primary float-right p-2 trash" href="{{ route('group.trash')}}">
            <i class="fa fa-trash"></i> Go To Trash
        </a>
    </div>

<!-- table view produts  -->

    <div class="card-body">
        <div class="table-responsive">
            <table id="data-table" class="table table-sm table-bordered">
                <thead>
                    <tr>
                        <th>label</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($groups as $group)
                    <tr>
                        <td>{{ $group->label }}</td>
                        <td>{{ $group->created_at->format('Y-m-d')}}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('group.edit', $group->id) }}" class="btn btn-sm btn-primary p-2">Edit</i></a>
                                <form action="{{ route('group.destroy', $group->id) }}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="delete-btn btn btn-sm btn-danger ml-2 p-2">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>








<script>
    $("#data-table").DataTable({
        "responsive": false,
        "lengthChange": false,
        "autoWidth": false,
        "paging": false,
        "searching": true,
        "ordering": true,
        "info": false,
    }).buttons().container().appendTo('#data-table_wrapper .col-md-6:eq(0)');

    $('.delete-btn').click(function(evt) {
        if (!confirm('Do you want to Trashed this Group')) {
            evt.preventDefault()
        }
    })
</script>



</script>
@endsection
