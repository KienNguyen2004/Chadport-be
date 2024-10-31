@extends('main')


@section('title')
    {{$title}}
@endsection

@section('content')

<table class="table table-striped">
    <thead>
        <th>#</th>
        <th>Tên danh mục</th>
        <th>Mô tả</th>
    </thead>
    <tbody>
        @foreach ($list as $item)
            <td>{{$item['id']}}</td>
            <td>{{$item['name']}}</td>
            <td>{{$item['description']}}</td>
        @endforeach
    </tbody>
</table>
@endsection