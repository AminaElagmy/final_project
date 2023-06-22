<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{config('app.name')}}</title>
    <link rel= "stylesheet" href=" {{asset('/css/bootstrap.min.css')}}">

   </head>
   <body>

    <div class='container'>

     <h1>Product Details</h1>

      @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
               @foreach($errors->all() as $message)
                <li>{{$message}}</li>
                @endforeach
            </ul>
      </div>
      @endif

    <form action="{{ route('data1',$product->id) }}"method="post" enctype="multipart/form-data">
        @csrf
        <input type ="hidden"name="product_id"value="{{$product->id}}">

        <div class="form-group">
            <label for="name">Number of Tables</label>
            <input type="text"  name="table"class="form-control"  required>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>

    </form>
    </div>
</body>
<!-- jquery -->
<script src="{{ URL::asset('js/jquery-3.3.1.min.js') }}"></script>
<!-- plugins-jquery -->
<script src="{{ URL::asset('js/plugins-jquery.js') }}"></script>

</html>
