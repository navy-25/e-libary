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
                <p class="my-auto">Daftar Buku</p>
            </div>
            <div class="col-6 col-md-6 col-lg-6 d-flex">
                <a title="tambah" href="#"
                    onclick="create()"
                    data-bs-toggle="modal" data-bs-target="#modalForm"
                    class="btn-primary btn ms-auto btn-sm">
                    Tambah
                </a>
                <button title="hapus terpilih"
                    onclick="confirm('Yakin hapus semua data terpilih?') == true ? $('#submit_delete_check').trigger('click') : ''"
                    class="btn-danger btn ms-2 btn-sm">
                    Hapus data terpilih
                </button>
            </div>
        </div>
    </div>
    <div class="card-body p-4 pb-0">
        <form action="" class="d-flex" method="GET">
            <input class="form-control me-2" name="title" placeholder="judul" value="{{ isset($_GET['title']) ? $_GET['title'] : '' }}">
            <input class="form-control me-2" name="description" placeholder="deskripsi" value="{{ isset($_GET['description']) ? $_GET['description'] : '' }}">
            <input class="form-control me-2" name="stock" placeholder="stok" value="{{ isset($_GET['stock']) ? $_GET['stock'] : '' }}">
            <input class="form-control me-2" name="price" placeholder="harga" value="{{ isset($_GET['price']) ? $_GET['price'] : '' }}">
            <button class="btn btn-success btn-sm" type="submit">Search</button>
        </form>
    </div>
    <div class="card-body p-4">
        <div class="table-responsive">
            <form action="{{ route('books.destroySelected') }}" method="POST">
                @csrf
                <table class="table table-hover" id="data-table" style="width: 100%">
                    <thead>
                        <tr class="bg-light">
                            <th>#</th>
                            <th>No</th>
                            <th>Judul Buku</th>
                            <th>Deskripsi</th>
                            <th>Kategori</th>
                            <th>Kata Kunci</th>
                            <th>Harga</th>
                            <th>Stock</th>
                            <th>Penerbit</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $number => $val)
                            <tr>
                                <td>
                                    <input style="width: 30px !important;height: 30px !important" class="form-check-input" name="id_books[]" type="checkbox" value="{{ $val->id }}" id="checkbox_{{ $number }}">
                                </td>
                                <td>{{ ++$number }}</td>
                                <td>{{ $val->title }}</td>
                                <td>
                                    @php
                                        $desc = substr($val->description, 0, 100);
                                        if (strlen($val->description) > 100) {
                                            $desc = $desc . '...';
                                        } else {
                                            $desc = $desc;
                                        }
                                    @endphp
                                    {{ $desc }}
                                </td>
                                <td>
                                    @php
                                        $category_data       = \App\Models\Category::whereIn('id', json_decode($val->category_id))->orderBy('name', 'ASC')->get();
                                        $category_name  = [];
                                        foreach ($category_data as $value) {
                                            $category_name[] = $value->name;
                                        }
                                    @endphp
                                    {{ join(', ', $category_name) }}
                                </td>
                                <td>
                                    @php
                                        $keyword_data        = \App\Models\Keywords::whereIn('id', json_decode($val->keyword_id))->orderBy('name', 'ASC')->get();
                                        $keyword_name   = [];
                                        foreach ($keyword_data as $value) {
                                            $keyword_name[] = $value->name;
                                        }
                                    @endphp
                                    {{ join(', ', $keyword_name) }}
                                </td>
                                <td>{{ 'Rp. ' . number_format($val->price, 2); }}</td>
                                <td>{{ number_format($val->stock); }}</td>
                                <td>{{ $val->publisher }}</td>
                                <td style="width: 200px !important">
                                    <input type="hidden" id="data_{{ $number }}" value="{{ json_encode($val,true) }}">
                                    <a href="#" onclick="content_view('{{ join(', ', $category_name) }}','{{ join(', ', $keyword_name) }}')" class="mb-1 btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalView" >View</a>
                                    <a href="#" onclick="update('data_{{ $number }}')"
                                        data-bs-toggle="modal" data-bs-target="#modalForm" class="mb-1 btn btn-sm btn-warning">Edit</a>
                                    <a href="{{ route('books.destroy',['id'=>$val->id]) }}" onclick="if(confirm('apakah kamu yakin?')" class="mb-1 btn btn-sm btn-danger">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <button class="d-none" id="submit_delete_check" type="submit">Delete</button>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalForm" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" id="modalContent">
            <form action="" method="POST" id="form">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modal_title">Judul Modal</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Judul Buku<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="judul buku" required>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label w-100">Kategori<span class="text-danger">*</span></label>
                                <select class="form-select select2-modal" style="width: 100% !important" name="category_id[]" id="category_id" multiple>
                                    @foreach ($category as $val)
                                        <option value="{{ $val->id }}">{{ $val->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label w-100">Kata Kunci<span class="text-danger">*</span></label>
                                <select class="form-select select2-modal" style="width: 100% !important" name="keyword_id[]" id="keyword_id" multiple>
                                    @foreach ($keyword as $val)
                                        <option value="{{ $val->id }}">{{ $val->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Harga<span class="text-danger">*</span></label>
                                <input type="text" class="form-control money" name="price" id="price" placeholder="harga buku" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Stok<span class="text-danger">*</span></label>
                                <input type="text" class="form-control money" name="stock" id="stock" placeholder="stok" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Penerbit<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="publisher" id="publisher" placeholder="nama penerbit" required>
                    </div>
                    <div class="mb-3">
                        <labe class="form-label">Deskripsi<span class="text-danger">*</span></label>
                        <textarea class="form-control" name="description" id="description" rows="3" required></textarea>
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
<div class="modal fade" id="modalView" tabindex="-1" aria-labelledby="modalView" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" id="modalContent">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Lihat data</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr class="bg-light">
                            <th>Judul Buku</th>
                            <th>Kategori</th>
                            <th>Kata Kunci</th>
                            <th>Stok</th>
                            <th>Harga</th>
                        </tr>
                    </thead>
                    <tbody id="content_view">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $('.money').mask('000.000.000.000.000', {
        reverse: true
    });
    $(".select2-keyword").select2({
        allowClear: true,
        placeholder: 'Pilih keyword',
    });
    $(".select2-category").select2({
        allowClear: true,
        placeholder: 'Pilih kategori',
    });
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
        $('#modal_title').text('Tambah Buku')
        $('#form').attr('action','{{ route('books.store') }}')
        $('#btn_submit').text('Tambah')
    }
    function update(id){
        var data = $(id).val()
        var data = JSON.parse(data)
        $('#modal_title').text('Edit Buku')
        $('#form').attr('action','{{ route('books.update') }}')
        $('#btn_submit').text('Simpan')

        $('#id').val(data.id)
        $('#title').val(data.title)
        $('#description').val(data.description)
        $('#category_id').val(JSON.parse(data.category_id)).trigger('change')
        $('#keyword_id').val(JSON.parse(data.keyword_id)).trigger('change')
        $('#price').val(data.price)
        $('#publisher').val(data.publisher)
        $('#stock').val(data.stock)
    }
    function content_view(category,keyword){
        var data = $('#data').val()
        var data = JSON.parse(data)
        $('#content_view').html('')
        $('#content_view').append(`
            <tr>
                <td>`+data.title+`</td>
                <td>`+category+`</td>
                <td>`+keyword+`</td>
                <td>`+data.stock.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")+`</td>
                <td>Rp. `+data.price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")+`</td>
            </tr>
            <tr>
                <td class="fw-bold bg-light" colspan="5">Deskripsi</td>
            </tr>
            <tr>
                <td colspan="5">`+data.description+`</td>
            </tr>
        `)
    }
</script>
@endsection
