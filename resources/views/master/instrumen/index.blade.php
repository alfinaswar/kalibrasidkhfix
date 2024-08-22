@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-end align-items-center mb-4 flex-wrap">
					<a href="{{route('instrumen.create')}}" class="btn btn-primary me-3 btn-sm"><i class="fas fa-plus me-2"></i>Tambah Alat</a>
	</div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Data Alat Medis</h4>
                </div>
                <div class="card-body">
                        <table id="example" class="display" style="min-width: 845px">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kode Alat</th>
                                    <th>Nama Alat</th>
                                    <th>Merk</th>
                                    <th>Serial Number</th>
                                    <th>Foto</th>
                                    <th>Tertelusur</th>
                                    <th width="12%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>


    </div>
    </div>
     @if (session()->has('success'))
                <script>
                    swal.fire({
                        title: "{{ __('Success!') }}",
                        text: "{!! \Session::get('success') !!}",
                        type: "success"
                    });
                </script>
            @endif
 <script>

    $(document).ready(function () {

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
                            url: '{{ route('alat.destroy', ':id') }}'.replace(':id',
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
                                    'Error',
                                    'error'
                                );
                                console.log(xhr.responseText);
                            }
                        });
                    }
                });
            });
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
                    ajax: "{{ route('alat.index') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'KodeAlat',
                            name: 'KodeAlat'
                        },
                        {
                            data: 'NamaAlat',
                            name: 'NamaAlat'
                        },
                        {
                            data: 'Merk',
                            name: 'Merk'
                        },
                        {
                            data: 'SerialNumber',
                            name: 'SerialNumber'
                        },
                        {
                            data: 'Tertelusur',
                            name: 'Tertelusur'
                        },
                        {
                            data: 'Foto',
                            name: 'Foto'
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
    });
 </script>
@endsection
