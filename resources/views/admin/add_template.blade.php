@extends('admin/adminlayout')

@section('container')
    <form action="" method="post">
        <button href="/add/chef" type="button" class="btn btn-success" style="width:170px;height:35px;padding-top:9px;">+ Add
            Template</button><br><br>

        <div class="card">
            <h5 class="card-header">Title : </h5>
            <div class="card-body">
                Description

                <fieldset>
                    <textarea name="description" rows="4" cols="50" id="message" placeholder="Message" required></textarea>
                </fieldset>
                <br>
            </div>
        </div>

        <br>
        <br>

        <div class="card-group">
            <div class="card">
                <img class="card-img-top" alt="...">
                <div class="card-body">
                    <input type="file" name="image1">
                    <h5 class="card-title">Section 1 Image</h5>
                    <p class="card-text">





                    </p>
                </div>

            </div>
            <div class="card" style="margin-left:20px;">
                <img class="card-img-top" alt="...">
                <div class="card-body">
                    <input type="file" name="image2">

                    <h5 class="card-title">Section 2 Image</h5>

                    <p class="card-text">






                    </p>
                </div>
            </div>
            <div class="card" style="margin-left:20px;">
                <img class="card-img-top" alt="...">
                <div class="card-body">
                    <input type="file" name="image3">


                    <h5 class="card-title">Section 3 Image</h5>

                    <p class="card-text">







                    </p>
                </div>
            </div>
        </div>
        <br><br>
        <h1>Video</h1>
        <br>

        <div class="embed-responsive embed-responsive-16by9">

            <iframe width=auto height="100" src="https://www.youtube.com/embed/dA0VGEbbw4g" title="YouTube video player"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                allowfullscreen></iframe>
        </div>

        <br>
        <br>



        <br>
        <br>
        <br>



        {{-- <div class="card mb-3">
        <img class="card-img-top" alt="...">
        <div class="card-body">
            <h5 class="card-title">Video Thumbnail</h5>
        </div>
    </div> --}}
    </form>
@endsection()
