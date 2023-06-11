@extends('layout', ['title' => 'Home'])

@section('page-content')
    <div style="width:80%; margin:auto;">
        <br>
        <br>
        <br>
        <br>
        <h1>Your order amount is Rs:{{ $total }}</h1><br>
        <h2 style="color:#FB5849">Choose a payment method</h2><br>
        <input ng-model="myVar" type="radio" id="cod" name="cod" value="cod">
        <label for="cod"><img style="max-width:150px;" src="{{ asset('assets/images/cod.png') }}"></label><br>
        <input ng-model="myVar" type="radio" id="instamojo" name="instamojo" value="instamojo">
        <label for="instamojo"><img style="max-width:150px;"
                src="{{ asset('assets/images/instamojo.png') }}"></label><br><br><br>
        <div ng-switch="myVar">
            @if (Auth::check())
                <div ng-switch-when="cod">

                    <form style="display:inline" method="post" action="{{ route('mails.shipped', $total) }}">
                        @csrf
                        <input class="btn btn-success" type="submit" value="Place Order">
                        <?php
                        $status = ': Cash On Delievery';
                        Session::put('status', $status);
                        ?>
                    </form>
                </div>
                <div ng-switch-when="instamojo">
                    <?php
                    Session::put('total', $total);
                    ?>
                    <a href="/verifyAdd"><input class="btn btn-success" type="submit" value="Pay with Online"></a>

                </div>
            @else
                <div ng-switch-when="cod">

                </div>
                <div ng-switch-when="instamojo">
                    <a href="/login"><input class="btn btn-success" type="submit" value="Log in"></a>
                </div>
            @endif
        </div>
        </form>
    </div>
@endsection
