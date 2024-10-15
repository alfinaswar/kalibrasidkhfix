@extends('layouts.app')

@section('content')
    @if ($message = Session::get('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'success',
                text: '{{ $message }}',
            });
        </script>
    @endif

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
               @foreach ($errors->all() as $error)
                 <li>{{ $error }}</li>
               @endforeach
            </ul>
        </div>
    @endif
        {!! Form::open(array('route' => 'users.store','method'=>'POST', 'class' => 'profile-form')) !!}
    <div class="row">
<div class="col-xl-2 col-lg-4">
    <div class="clearfix">
        <div class="card card-bx author-profile m-b30">
            <div class="card-body">
                <div class="p-5">
                    <div class="author-profile">
                        <div class="author-media">
                            <img id="profileImage" src="images/profile/pic1.jpg" alt="" class="rounded-circle border-orange">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="input-group mb-3">
                    <input type="file" name="Foto" class="form-control" id="profileImageInput" accept="image/*">
                </div>
                <div class="input-group">
                    <label>Tanda Tangan Digital</label>
                    <input type="file" name="DigitalSign" class="form-control" accept="image/*">
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .rounded-circle {
        border-radius: 50%;
        width: 100%;
        height: auto;
    }
    .border-orange {
        border: 4px solid orange; /* Adjust the width of the border as needed */
    }
</style>



<div class="col-xl-10 col-lg-8">
    <div class="card card-bx m-b30">
        <div class="card-header">
            <h6 class="title">Data Karyawan</h6>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-sm-6 m-b30">
                    <label class="form-label">Name</label>
                    {!! Form::text('name', null, array('placeholder' => 'Nama','class' => 'form-control')) !!}
                </div>
                <div class="col-sm-6 m-b30">
                    <label class="form-label">Email</label>
                    {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
                </div>
                <div class="col-sm-6 m-b30">
                    <label class="form-label">Nomor Identitas Pegawai</label>
                    {!! Form::text('nip', null, array('placeholder' => 'Nomor Identitas Pegawai','class' => 'form-control')) !!}
                </div>

                <div class="col-sm-6 m-b30">
                    <label class="form-label">Role</label>
                    {!! Form::select('roles[]', $roles,[], array('class' => 'form-control','multiple')) !!}
                </div>
                <div class="col-sm-6 m-b30">
                    <label class="form-label">Departemen</label>
                    {!! Form::text('department', null, array('placeholder' => 'Departmen','class' => 'form-control')) !!}
                </div>
                <div class="col-sm-6 m-b30">
                    <label class="form-label">Jabatan</label>
                    {!! Form::text('jabatan', null, array('placeholder' => 'Jabatan','class' => 'form-control')) !!}
                </div>
                <div class="col-sm-6 m-b30">
                    <label class="form-label">Nomor HP</label>
                    {!! Form::number('hp', null, array('placeholder' => 'Nomor HP','class' => 'form-control')) !!}
                </div>
                <div class="col-sm-6 m-b30">
                    <label class="form-label">Alamat</label>
                    {!! Form::textarea('alamat', null, array('placeholder' => 'Alamat','class' => 'form-control', 'rows' => 3)) !!}
                </div>

                <div class="col-sm-6 m-b30">
                    <label class="form-label">Password</label>
                    {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
                </div>
                <div class="col-sm-6 m-b30">
                    <label class="form-label">Confirm Password</label>
                    {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary" style="background-color:#6b6ef5;">Submit</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>

    </div>
    <script>
    document.getElementById('profileImageInput').addEventListener('change', function(event) {
        const input = event.target;
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profileImage').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    });
</script>
@endsection
