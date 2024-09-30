@extends('layouts.app')
@section('content')
<div class="col-xl-12 col-lg-12">
                        <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title">Form Tambah Kategori Inventori</h4>
                                    <button class="btn btn-secondary" onclick="window.history.back();">Back</button>
                            </div>
                            <div class="card-body">
                                <div class="basic-form mb-4">
                                    <form action="{{route('inv.store-kategori')}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="mb-3 col-md-12">
                                                <label class="form-label">Kategori</label>
                                                <input type="text" name="Kategori" class="form-control @error('Kategori') is-invalid @enderror" placeholder="Kategori" value="{{old('Kategori')}}">
                                                @error('Kategori')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-md btn-primary btn-block">Tambah</button>
                                    </form>
                                </div>
                                 <table id="example" class="display" style="min-width: 845px">
                                        <thead>
                                            <tr>
                                                <th width="5%">#</th>
                                                <th>Nama</th>
                                                <th width="15%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                </table>
                            </div>
                        </div>
					</div>
                    <script>
                        $(document).ready(function () {
                            var dataTable = function() {
                                    var table = $('#example');
                                    table.DataTable({
                                        responsive: true,
                                        serverSide: true,
                                        bDestroy: true,
                                        processing: true,
                                        language: {
                                            processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Memuat...</span> ',
                                            paginate: {
                                                next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                                                previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                                            }
                                        },
                                        serverSide: true,
                                        ajax: "{{ route('inv.create-kategori') }}",
                                        columns: [{
                                                data: 'DT_RowIndex',
                                                name: 'DT_RowIndex'
                                            },
                                            {
                                                data: 'Kategori',
                                                name: 'Kategori'
                                            },
                                            {
                                                data: 'action',
                                                name: 'action',
                                                orderable: false,
                                                searchable: false
                                            },
                                        ]
                                    });
                                };
                                dataTable();
                                 $('body').on('click', '.btn-delete', function() {
                var id = $(this).data('id');

                Swal.fire({
                    title: 'Hapus Data',
                    text: "Anda Ingin Menghapus Data?",
                    icon: 'Peringatan',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('inv.destroy-kategori', ':id') }}'.replace(':id',
                                id),
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Dihapus',
                                    'Data Berhasil Dihapus',
                                    'success'
                                );

                                $('#example').DataTable().ajax.reload();
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Failed!',
                                    'Data Sedang Digunakan',
                                    'error'
                                );
                                console.log(xhr.responseText);
                            }
                        });
                    }
                });
            });
                        });
                    </script>
@endsection
