@extends('admin.layouts.default')

{{-- Web site Title --}}
@section('title') {!! trans("admin/sphere.sphere") !!} :: @parent
@stop

{{-- Content --}}
@section('main')
    <div class="page-header">
        <h3>
            {!! trans("admin/sphere.sphere") !!}
        </h3>
    </div>

    <table class="table table-striped table-hover datatable">
        <thead>
        <tr>
            <th></th>
            <th>{!! trans("admin/agent.agent") !!}</th>
            <th>{!! trans("admin/sphere.name") !!}</th>
            <th>{!! trans("admin/admin.updated_at") !!}</th>
            <th>{!! trans("admin/admin.action") !!}</th>
        </tr>
        </thead>
        <tbody>

        @forelse($collection as $id=>$sphere_rec)
            @foreach($sphere_rec as $rec)
            <tr>
                <td>{{ $rec->id }}</td>
                <td>{{ $rec->first_name }} {{ $rec->last_name }} ( {{ $rec->name }} )</td>
                <td>{{ $spheres[$id] }}</td>
                <td>{{ $rec->updated_at }}</td>
                <td><a href="{{ route('admin.sphere.reprice.edit',['sphere'=>$id,'id'=>$rec->agent_id]) }}" class="btn btn-success btn-sm" ><span class="glyphicon glyphicon-pencil"></span>  {{ trans("admin/modal.edit") }}</a></td>
            </tr>
            @endforeach
        @empty
        @endforelse

        </tbody>
    </table>
@stop

{{-- Scripts --}}
@section('scripts')
    <script>
        $(document).ready(function() {
            $('.datatable').DataTable({
                responsive: true
            });
        });
    </script>
@stop