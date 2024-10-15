@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title fw-bold">LK PENGUJIAN DAN KALIBRASI <span
                            class="text-primary text-uppercase">{{ $sertifikat->getNamaAlat->Nama }}</span></h4>
                    <span></span>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('job.store') }}">
                        @csrf
                        {{-- Komponen Administrasi --}}
                        @include('sertifikat.form-komponen.administrasi')

                        {{-- Komponen Alat Ukur --}}
                        @include('sertifikat.form-komponen.alat-ukur')

                        {{-- Komponen Pengukuran Kondisi Lingkungan --}}
                        @include('sertifikat.form-komponen.pengukuran-kondisi-lingkungan-tanpa-tegangan-utama')

                        {{-- Komponen Pemeriksaan Fisik dan Fungsi Alat --}}
                        @include('sertifikat.form-komponen.TimbanganBayi.pemeriksaan-fisik-dan-fungsi-alat-tensimeter-digital')

                        {{-- Komponen Pengujian Kinerja hALF mAX --}}
                        @include('sertifikat.form-komponen.TimbanganBayi.pengukuran-kinerja-half-max')

                        {{-- Komponen Pengujian Kinerja Skala Nominal --}}
                        @include('sertifikat.form-komponen.TimbanganBayi.pengujian-skala-nominal')

                        {{-- Komponen Teknis --}}
                        @include('sertifikat.form-komponen.TimbanganBayi.telaah-teknis')
                </div>
            </div>
        </div>
        <input type="hidden" name="idinstrumen" value="{{ $sertifikat->InstrumenId }}">
        <input type="hidden" name="sertifikatid" value="{{ $sertifikat->id }}">
        <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="ModalMetoda" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Metoda Kerja</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table id="example" class="display" width="100%">
                        <thead>
                            <tr>
                                <th width="10%">#</th>
                                <th>Nama</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
        function saveMetodaKerja() {
            var modalValue = document.getElementById('modal_metoda_kerja').value;
            document.getElementById('metoda_kerja').value = modalValue;
            $('#ModalMetoda').modal('hide');
        }
        $(document).ready(function() {
            var dataTable = function() {
                var table = $('#example').DataTable({
                    responsive: true,
                    serverSide: true,
                    destroy: true,
                    processing: true,
                    language: {
                        processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Memuat...</span> ',
                        paginate: {
                            next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                            previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                        }
                    },
                    columnDefs: [{
                        width: '10%',
                        targets: 0
                    }],
                    ajax: "{{ route('metode.index') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'Nama',
                            name: 'Nama'
                        },
                    ]
                });

                $('#example tbody').on('click', 'tr', function() {
                    var data = table.row(this).data();
                    $("#metoda_kerja").val(data.Nama);
                    $('#ModalMetoda').modal('hide');
                });
            };
            dataTable();
        });
    </script>
@endsection
