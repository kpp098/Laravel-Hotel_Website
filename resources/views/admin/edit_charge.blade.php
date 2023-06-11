@extends('admin/adminlayout')

@section('container')
    @foreach ($charge as $charg)
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Edit Charge</h4>
                    <br>

                    @if (Session::has('wrong'))
                        <div class="alert">
                            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                            <strong>Opps !</strong> {{ Session::get('wrong') }}
                        </div>
                        <br>
                    @endif
                    @if (Session::has('success'))
                        <div class="success">
                            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                            <strong>Congrats !</strong> {{ Session::get('success') }}
                        </div>
                        <br>
                    @endif

                    <form class="forms-sample" action="{{ asset('/charge-edit-process/' . $charg->id) }}" method="post"
                        enctype="multipart/form-data">

                        @csrf

                        <div class="form-group">
                            <label for="exampleInputName1">Name</label>
                            <input type="text" name="name" value="{{ $charg->name }}" class="form-control"
                                id="exampleInputName1">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName1">Price</label>
                            <input type="text" name="price" value="{{ $charg->price }}" class="form-control"
                                id="exampleInputName1">
                        </div>


                        <button type="submit" class="btn btn-primary me-2">Update</button>
                        <button class="btn btn-dark" href="{{ redirect('admin/charge') }}">Cancel</button>
                    </form>
                </div>
            </div>

        </div>
    @endsection()
@endforeach

<style>
    .alert {
        padding: 20px;
        background-color: #f44336;
        color: white;
    }

    .success {
        padding: 20px;
        background-color: #4BB543;
        color: white;
    }

    .closebtn {
        margin-left: 15px;
        color: white;
        font-weight: bold;
        float: right;
        font-size: 22px;
        line-height: 20px;
        cursor: pointer;
        transition: 0.3s;
    }

    .closebtn:hover {
        color: black;
    }
</style>
