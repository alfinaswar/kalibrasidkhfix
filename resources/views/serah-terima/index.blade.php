@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-end align-items-center mb-4 flex-wrap">
        <a href="{{ route('st.create') }}" class="btn btn-primary me-3 btn-sm"><i class="fas fa-plus me-2"></i>Tambah</a>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Data Serah Terima Alat</h4>
                </div>
                <div class="card-body">
                    {{-- <div class="row">
                    <div class="col-3 my-1">
    <label class="me-sm-2">Status</label>
                                                <select id="filter-status" class="form-control" name="filter-status">
                                                <option>Pilih...</option>
                                                   <option value="AKTIF">AKTIF</option>
                                                   <option value="TIDAKAKTIF">TIDAK</option>

                                                </select>
                                            </div>
                                              <div class="col-3 my-1">
                                                <label class="me-sm-2">Customer</label>
                                                <select id="filter-customer" class="multi-select" name="filter-customer">
                                                <option selected>Pilih...</option>
                                                   @foreach ($customer as $kat)
                                                   <option value="{{ $kat->Name }}">{{ $kat->Name }}</option>
                                                   @endforeach

                                                </select>
                                            </div>
                                            </div> --}}
                    <table id="example" class="display" style="min-width: 845px" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th width="15%">Nomor</th>
                                <th>Kategori</th>
                                <th>Customer</th>
                                <th>Tanggal Diterima</th>
                                <th>Tanggal Diserahkan</th>
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
    @if (session()->has('success'))
        <script>
            swal.fire({
                title: "{{ __('Success!') }}",
                text: "{!! \Session::get('success') !!}",
                icon: "success"
            });
        </script>
    @endif
    <script>
        $(document).ready(function() {

$('body').on('change', '.TanggalDiserahkan', function () {
    var rowId = $(this).data('row-id');
    var tanggalDiserahkan = $(this).val();
    var url = "{{ route('st.UpdateDiserahkan', ':id') }}".replace(':id', rowId);

    $.ajax({
        url: url,
        type: 'PUT',
        data: {
            tanggalDiserahkan: tanggalDiserahkan,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            swal({
                title: "Success!",
                text: response.message,
                type: "success",
                timer: 2000,
                showConfirmButton: false
            });
            location.reload();
        },
        error: function (xhr) {
            swal({
                title: "Error!",
                text: xhr.responseJSON.message || "Gagal.",
                type: "error",
                timer: 2000,
                showConfirmButton: false
            });
        }
    });
});


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
                            url: '{{ route('st.destroy', ':id') }}'.replace(':id',
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
                    ajax: "{{ route('st.index') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'KodeSt',
                            name: 'KodeSt'
                        },
                         {
                            data: 'get_customer.Kategori',
                            name: 'get_customer.Kategori'
                        },
                        {
                            data: 'get_customer.Name',
                            name: 'get_customer.Name'
                        },
                        {
                            data: 'TanggalDiterima',
                            name: 'TanggalDiterima'
                        },
                        {
                            data: 'Diserahkan',
                            name: 'Diserahkan',
                        },
                        {
                            data: 'Stat',
                            name: 'Stat'
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
             $(".multi-select").select2();

        });
    </script>
@endsection
