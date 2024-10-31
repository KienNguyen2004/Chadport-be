@extends('main')


@section('title')
    {{$title}}
@endsection

@section('content')
<form action="" method="POST">
    <div class="mb-3">
        <label class="form-label">Tiêu đề</label>
        <input type="text" name="tieu_de" class="form-control" placeholder="Nhập tiêu đề">
    </div>

    <div class="mb-3">
        <label class="form-label">Hình ảnh</label>
        <input type="file" name="hinh_anh" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Ngày đăng</label>
        <input type="date" name="ngay_dang" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Nội dung</label>
        <textarea class="form-control" rows="3" name="noi_dung" placeholder="Nhập nội dung"></textarea>
    </div>

    <div class="mb-3 d-flex justify-content-center">
        <button type="submit" class="btn btn-success">Thêm mới</button>
    </div>
</form>
@endsection