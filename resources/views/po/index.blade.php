@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-end align-items-center mb-4 flex-wrap">
        <button type="button" class="btn btn-primary me-3 btn-sm" data-bs-toggle="modal" data-bs-target="#kajiUlangModal">
            <i class="fas fa-plus me-2"></i>Buat PO
        </button>


	</div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Data Purchase Order</h4>
                </div>
                <div class="card-body">
                        <table id="example" class="display" style="min-width: 845px">
                            <thead>
                                <tr>
                                <th>#</th>
                                <th>Kode</th>
                                <th>Customer</th>
                                <th>Tanggal PO</th>
                                <th>Status</th>
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
            <div class="modal fade" id="kajiUlangModal" tabindex="-1" aria-labelledby="kajiUlangModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="kajiUlangModalLabel">Data Quotation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table id="example4" class="display" width="100%">
                        <thead>
                            <tr class="text-center">
                                <th>#</th>
                                <th>Kode</th>
                                <th>Customer</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th width="12%">Aksi</th>
                            </tr>
                        </thead>
                         <tbody>
@foreach ($dataQuotation as $key => $qt)
<tr>
  <td class="text-center">{{$key+1}}</td>
  <td>{{$qt->KodeQuotation}}</td>
  <td>{{$qt->getCustomer->Name}}</td>
  <td>{{$qt->Tanggal}}</td>
  <td class="text-center">@if ($qt->Status == "DISETUJUI")
<span class="badge bg-success text-dark">DISETUJUI</span>
  @endif</td>
  <td class="text-center"><a href="{{route('po.form-po', $qt->id)}}" class="btn btn-primary">Purchase Order <i class="fas fa-arrow-right"></i></a></td>
</tr>
@endforeach
                            </tbody>

                    </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
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
                    ajax: "{{ route('po.index') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'KodePo',
                            name: 'KodePo'
                        },
                        {
                            data: 'CustomerId',
                            name: 'CustomerId'
                        },
                        {
                            data: 'TanggalPo',
                            name: 'TanggalPo'
                        },

                        {
                            data: 'Status',
                            name: 'Status'
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
