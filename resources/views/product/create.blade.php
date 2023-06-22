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
     <h1>Create Product</h1>

      @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
               @foreach($errors->all() as $message)
                <li>{{$message}}</li>
                @endforeach
            </ul>
      </div>
      @endif

     <form action="/products"method="post" enctype="multipart/form-data">
            <input type = "hidden" name="_token" value="{{csrf_token()}}">
             {{ csrf_field()}}

            <div class="form-group">
                <label for="name">Name</label>
                <input type = "text" id="name" name="name"class="form-control">
            </div>

            <div class="form-group">
                <label for="discription">Discription</label>
                <textarea id="discription" name="discription"class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label for="category_id">Category_id</label>
                <select id="category_id"name="category_id"class="form-control">
                    @foreach($categories as $category)
                    <option value="{{$category->id}}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="govern_id">Government</label>
                <select id="govern_id"name="govern_id"class="form-control" >
                    <option value="" selected disabled>select government    </option>
                    @foreach(\App\Models\Governorate::all() as $governorate)
                    <option value="{{$governorate->id}}">{{ $governorate->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="">Region</label>
                <select name="region_id" class="custom-select">
                    
                </select>
            </div>

            <div class="form-group">
                <label for="photo">Photo</label>
                <input type="file" id="photo" name="photo" class="form-control">
            </div>

            <div class="form-group">
                <button class="btn btn-primary">Save</button>
            </div>

        </form>
    </div>
</body>
<!-- jquery -->
<script src="{{ URL::asset('js/jquery-3.3.1.min.js') }}"></script>
<!-- plugins-jquery -->
<script src="{{ URL::asset('js/plugins-jquery.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('select[name="govern_id"]').on('change', function () {
                var government_id = $(this).val();
                
                if (government_id) {
                    $.ajax({
                        url: "{{ URL::to('region') }}/" + government_id,
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            $('select[name="region_id"]').empty();
                            $.each(data, function (key, value) {
                                $('select[name="region_id"]').append('<option value="' + key + '">' + value + '</option>');
                            });
                        },
                    });
                } else {
                    console.log('AJAX load did not work');
                }
            });
        });
    </script>
</html>
