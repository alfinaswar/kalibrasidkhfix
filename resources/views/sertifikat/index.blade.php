@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Data Sertifikat</h4>
                    <!-- Filter Inputs -->

                </div>
                <div class="card-body">
                     <div class="row mb-4">
                        <div class="col-md-4">
<label>
    Cari Berdasarkan Nama Instrumen
</label>
 <select class="multi-select" name="nama_alat" id="filter-nama-alat">

                                                <option value="">Semua Data Instrumen</option>
                                                @foreach ($instrumen as $inst)
                                                    <option value="{{ $inst->Nama }}">
                                                        {{ $inst->Nama }}</option>
                                                @endforeach
                                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>
    Cari Berdasarkan Status Sertifikat
</label>
                            <select id="filter-status-sertifikat" class="form-control" name="status_sertifikat">
                                <option value="">Filter Status Sertifikat</option>
                                <option value="N">Draft</option>
                                <option value="Y">Telah Terbit</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button id="filter-apply" class="btn btn-primary">Apply Filter</button>
                        </div>
                    </div>
                    <table id="example" class="display" style="min-width: 845px" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>No Sertifikat</th>
                                <th>No Order</th>
                                <th>Nama Alat</th>
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
                            url: '{{ route('spk.destroy', ':id') }}'.replace(':id',
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
                    ajax: {
                        url: "{{ route('job.index') }}",
                        data: function(d) {
                            d.nama_alat = $('#filter-nama-alat').val();
                            d.status_sertifikat = $('#filter-status-sertifikat').val();
                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'NoSertifikat',
                            name: 'NoSertifikat'
                        },
                        {
                            data: 'SertifikatOrder',
                            name: 'SertifikatOrder'
                        },
                        {
                            data: 'get_nama_alat.Nama',
                            name: 'get_nama_alat.Nama'
                        },
                        {
                            data: 'get_customer.Name',
                            name: 'get_customer.Name'
                        },
                        {
                            data: 'statsertifikat',
                            name: 'statsertifikat'
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

            $('#filter-apply').click(function() {
                $('#example').DataTable().ajax.reload();
            });
        });
    </script>
@endsection
