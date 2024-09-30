@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-end align-items-center mb-4 flex-wrap">
        <button type="button" class="btn btn-primary me-3 btn-sm" data-bs-toggle="modal" data-bs-target="#kajiUlangModal">
            <i class="fas fa-plus me-2"></i>Kaji Ulang
        </button>


    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Data Kaji Ulang Alat</h4>
                </div>
                <div class="card-body">
                    <table id="example" class="display" style="min-width: 845px" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nomor Serah Terima</th>
                                <th>Customer</th>
                                <th>Status</th>
                                <th width="20%">Aksi</th>
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
    <div class="modal fade" id="kajiUlangModal" tabindex="-1" aria-labelledby="kajiUlangModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="kajiUlangModalLabel">Serah Terima</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table id="example4" class="display" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th width="auto">Nomor</th>
                                <th width="auto">Nama Customer</th>
                                <th width="auto">Tanggal Diterima</th>
                                <th width="auto">Tanggal Diserahkan</th>
                                <th width="auto">Status</th>
                                <th width="12%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataSerahTerima as $key => $st)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $st->KodeSt }}</td>
                                    <td>{{ $st->getCustomer['Name'] ?? 'Tidak Ditemukan' }}</td>
                                    <td>{{ $st->TanggalDiterima }}</td>
                                    <td>{{ $st->TanggalDiajukan }}</td>
                                    <td class="text-center">
                                        @if ($st->Status == 'AKTIF')
                                            <span class="badge bg-green">Aktif</span>
                                        @else
                                            <span class="badge bg-danger text-white">Tidak AKtif</span>
                                        @endif
                                    </td>
                                    <td><a href="{{ route('ku.form-kaji-ulang', $st->id) }}"
                                            class="btn btn-primary">Kaji</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

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
        $(document).ready(function() {

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
                            url: '{{ route('inv.destroy', ':id') }}'.replace(':id',
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
                    ajax: "{{ route('ku.index') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'KodeSt',
                            name: 'KodeSt'
                        },
                        {
                            data: 'get_customer.Name',
                            name: 'get_customer.Name'
                        },
                        {
                            data: 'StatusKaji',
                            name: 'StatusKaji'
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
