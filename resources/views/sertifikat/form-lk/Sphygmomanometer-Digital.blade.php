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
                        @include('sertifikat.form-komponen.sphygmomanometer.pemeriksaan-fisik-dan-fungsi-alat-sphygmomanometer')

                        {{-- Komponen Pengujian Kinerja Respirasi --}}
                        @include('sertifikat.form-komponen.sphygmomanometer.pengujian-kinerja')

                        {{-- Komponen Teknis --}}
                        @include('sertifikat.form-komponen.telaah-teknis')
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
        function addRow() {
            var table = document.getElementById("myTable").getElementsByTagName('tbody')[0];
            var newRow = table.insertRow(table.rows.length);
            var cells = [];
            for (var i = 0; i < 5; i++) {
                cells[i] = newRow.insertCell(i);
                if (i === 0) {
                    cells[i].innerHTML = `
                <div class="input-group">
                    <input type="number" class="form-control" name="TestingStandart[]" placeholder="Standart Testing RPM" value="">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fas fa-tachometer-alt"></i>
                        </span>
                    </div>
                </div>`;
                } else if (i < 4) {
                    cells[i].innerHTML = `
                <input type="text" name="PembacaanAlat${i}[]" placeholder="Uji ${i}" class="form-control" onclick="checkValue(this)">
            `;
                } else {
                    cells[i].innerHTML = `
                <input type="text" name="RataRata${i}[]" placeholder="Rata-rata" class="form-control">
            `;
                }
            }
            updateTestingStandart();
        }

        function deleteRow() {
            var table = document.getElementById("myTable").getElementsByTagName('tbody')[0];
            if (table.rows.length > 1) {
                table.deleteRow(table.rows.length - 1);
                updateTestingStandart();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Tidak dapat menghapus baris, tabel harus memiliki setidaknya satu baris.'
                });
            }
        }

        function updateTestingStandart() {
            var rows = document.querySelectorAll('#myTable tbody tr');
            var lastRowIndex = rows.length - 1;
            var lastRowTestingStandartInput = rows[lastRowIndex].querySelector('input[name="TestingStandart[]"]');
            if (lastRowIndex > 0) {
                var prevRowTestingStandartInput = rows[lastRowIndex - 1].querySelector('input[name="TestingStandart[]"]');
                lastRowTestingStandartInput.value = prevRowTestingStandartInput.value;
            }
        }

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

        function checkValue(input) {
            var row = input.parentNode.parentNode;
            var testingStandartInput = row.querySelector('input[name="TestingStandart[]"]');
            var testingStandartValue = parseFloat(testingStandartInput.value);
            var pembacaanAlatValue = parseFloat(input.value);
            var allowedRange = testingStandartValue * 0.1;
            if (pembacaanAlatValue < (testingStandartValue - allowedRange) || pembacaanAlatValue > (testingStandartValue +
                    allowedRange)) {
                input.classList.add('is-invalid');
            } else {
                input.classList.remove('is-invalid');
            }


        }
    </script>
@endsection
