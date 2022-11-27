@extends('layouts.master')

@section('content')
@if ($errors->any())
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger" role="alert">
            {{ ucfirst($error) }}
        </div>
    @endforeach
@elseif ($message = Session::get('error'))
    <div class="alert alert-danger" role="alert">
        {{ $message }}
    </div>
@elseif ($message = Session::get('success'))
    <div class="alert alert-success" role="alert">
        {{ $message }}
    </div>
@endif
<div class="card">
    <div class="card-header py-3 px-3">
        <div class="row">
            <div class="col-6 col-md-6 col-lg-6 d-flex">
                <p class="my-auto">Daftar Kategori</p>
            </div>
            <div class="col-6 col-md-6 col-lg-6 d-flex">
                <a title="tambah" href="#"
                    onclick="create()"
                    data-bs-toggle="modal" data-bs-target="#modalForm"
                    class="btn-primary btn ms-auto btn-sm">
                    Tambah
                </a>
            </div>
        </div>
    </div>
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover" id="data-table" style="width: 100%">
                <thead>
                    <tr class="bg-light">
                        <th>No</th>
                        <th>Nama</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $number => $val)
                        <tr>
                            <td style="width: 40px !important">{{ ++$number }}</td>
                            <td>{{ $val->name }}</td>
                            <td style="width: 200px !important">
                                <input type="hidden" id="data_{{ $number }}" value="{{ json_encode($val,true) }}">
                                <a href="#" onclick="update('#data_{{ $number }}')"
                                    data-bs-toggle="modal" data-bs-target="#modalForm" class="mb-1 btn btn-sm btn-warning">Edit</a>
                                <a href="{{ route('category.destroy',['id'=>$val->id]) }}" class="mb-1 btn btn-sm btn-danger">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalForm" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" id="modalContent">
            <form action="" method="POST" id="form">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modal_title">Judul Modal</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="nama" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id" id="id">
                    <button type="submit" id='btn_submit' class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(".select2-modal").select2({
        allowClear: true,
        dropdownParent: $('#modalContent'),
        placeholder: 'Pilih beberapa',
    });
    var datatable = $('#data-table').DataTable({
        processing: true,
        destroy: true,
        pageLength: 10,
        lengthMenu: [[5,10, 50, 100, -1], [5, 10, 50, 100, "Semua"]],
        responsive: true,
        dom: '<"d-flex justify-content-between align-items-center mx-0 row mb-3 px-0"<"col-12 col-sm-6 col-md-6 px-0"l><"col-12 col-sm-6 col-md-6 px-0"f>>t<"d-flex justify-content-between mx-0 row px-0"<"col-sm-12 col-md-6 px-0"i><"col-sm-12 col-md-6 px-0"p>>'
    })
    function create(){
        $('#modal_title').text('Tambah Kategori')
        $('#form').attr('action','{{ route('category.store') }}')
        $('#btn_submit').text('Tambah')
    }
    function update(id){
        var data = $(id).val()
        var data = JSON.parse(data)
        $('#modal_title').text('Edit Kategori')
        $('#form').attr('action','{{ route('category.update') }}')
        $('#btn_submit').text('Simpan')

        $('#id').val(data.id)
        $('#name').val(data.name)
    }
</script>
@endsection
