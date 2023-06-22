<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href=" {{ asset('/css/bootstrap.min.css') }}">

</head>

<body>
    <div class='container'>

        <h1 class="mb-3">{{ $title }}
            <small><a href="/products/create">create</a></small>
        </h1>

        @if($flashMessage)
        <div class="alert alert-success">
            {{ $flashMessage }}
        </div>
        @endif

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Discription</th>
                        <th>category_id</th>
                        <th>Image</th>
                        <th>Created At</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($products as $product)
                    <tr>
                        <td> {{ $product->id }}</td>
                        <td><a href="{{ url('products', $product->id) }}"> {{ $product->name }}</a></td>
                        <td> {{ $product->discription }}</td>
                        <td> {{ $product->category_id }}</td>
                        <!-- <td> <img src="{{$product->getFirstMediaUrl()}}" height="100px" width="100px"></td> -->
                        <td> <img src="{{asset('/images/products/' . $product->photo)}}" height="100px" width="100px"></td>
                        <td> {{ $product->created_at }}</td>
                        <td><a href="{{url('products/edit', $product->id) }}" class="btn btn-sm btn-dark">Edit</a></td>
                        <td><a href="{{url('products/details', $product->id) }}" class="btn btn-sm btn-dark">Details</a></td>
                        <td><a href="{{url('products/data', $product->id) }}" class="btn btn-sm btn-dark">Data</a></td>
                        <td>
                            <form action="/products/{{ $product->id }}" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="delete">
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>
