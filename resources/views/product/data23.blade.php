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

    <form action="{{ route('data33',$product->id) }}"method="post" enctype="multipart/form-data">
        @csrf
        <input type ="hidden"name="product_id"value="{{$product->id}}">
        <div class="form-group">
            <label for="name">opertion</label>
            <input type="number"  name="opertion" class="form-control" value="{{ $tableresturant1 }}" required>
        </div>
        <div class="form-group">
            <label for="name">medical</label>
            <input type="number"  name="medical" class="form-control" value="{{ $tableresturant2 }}" required>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"
        integrity="sha512-foIijUdV0fR0Zew7vmw98E6mOWd9gkGWQBWaoA1EOFAx+pY+N8FmmtIYAVj64R98KeD2wzZh1aHK0JSpKmRH8w=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $('#kt_docs_repeater_basic').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {
                $(this).slideDown();
            },

            hide: function(deleteElement) {
                $(this).slideUp(deleteElement);
            }
        });
        </script>

<script>
        $('#kt_docs_repeater_basic1').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {
                $(this).slideDown();
            },

            hide: function(deleteElement) {
                $(this).slideUp(deleteElement);
            }
        });
        </script>
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
