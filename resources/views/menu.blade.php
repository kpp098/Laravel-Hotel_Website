@extends('layout', ['title' => 'Home'])

@section('page-content')
    <br><br><br><br>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">
    <script src="script.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <table style="margin:10%; max-width:fit-content;">
        <tbody style="display: flex;
    flex-direction: row;
    justify-content: space-between;
    flex-wrap: wrap;">
            @foreach ($products as $product)
                <tr @if ($product->available != 'Stock') style="  opacity:0.5;" @endif
                    style="line-height:100%; margin-top:1%;">

                    <td width=0px>
                        <img src="{{ asset('assets/images/' . $product->image) }}" height=250px width=250px
                            style="    border-radius: 5px;max-width:fit-content;max-height:8rem;">
                    </td>
                    <td>

                        <h2>{{ $product->name }}</h2>
                        <h4>Rs :- {{ $product->price }}</h4>
                        <p>{{ $product->description }}</p>
                        <form method="post" action="{{ route('cart.store', $product) }}">
                            @csrf


                            <?php
                            
                            $total_rate = DB::table('rates')
                                ->where('product_id', $product->id)
                                ->sum('star_value');
                            
                            $total_voter = DB::table('rates')
                                ->where('product_id', $product->id)
                                ->count();
                            
                            if ($total_voter > 0) {
                                $per_rate = $total_rate / $total_voter;
                            } else {
                                $per_rate = 0;
                            }
                            
                            $per_rate = number_format($per_rate, 1);
                            
                            $whole = floor($per_rate); // 1
                            $fraction = $per_rate - $whole;
                            
                            ?>



                            <span class="product_rating">
                                @for ($i = 1; $i <= $whole; $i++)
                                    <i class="fa fa-star "></i>
                                @endfor

                                @if ($fraction != 0)
                                    <i class="fa fa-star-half"></i>
                                @endif


                                <span class="rating_avg">({{ $per_rate }})</span>
                            </span>

                            <br>
                            <br>

                            @if ($product->available == 'Stock')
                                <input type="number" name="number"
                                    style="width:52px; height:36px; border-radius:5px;padding-top: 3px;" id="myNumber"
                                    value="1">
                                <button class="btn btn-success">Add to Cart</button>
                            @endif
                            @if ($product->available != 'Stock')
                                <p class="btn btn-danger">Out of Stock</p>
                            @endif
                        </form>
                    </td>

                </tr>
            @endforeach

        </tbody>
    </table>
@endsection
