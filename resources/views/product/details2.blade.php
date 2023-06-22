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

    <form action="{{ route('adddetails2',$product->id) }}"method="post" enctype="multipart/form-data">

        @csrf

        <input type ="hidden"name="product_id"value="{{$product->id}}">
        
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text"  name="name"class="form-control"  required>
        </div>

        <div class="form-group">
            <label for="discription">Discription</label>
            <textarea name="discription"class="form-control" required></textarea>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email"  name="email"class="form-control"  required>
        </div>

        <div class="form-group">
            <label for="email">phone</label>
            <input type="number"  name="phone"class="form-control"  required>
        </div>

        <div class="form-group">
            <label for="email">location</label>
            <input type="text"  name="location"class="form-control" required>
        </div>
            
        <div class="form-group">
            <label for="email">mission</label>
            <textarea name="mission" class="form-control" required></textarea>
        </div>

        <div class="form-group">
            <label for="email">vision</label>
            <textarea name="vision" class="form-control" required></textarea>
        </div>

        <div class="form-group">
            <label for="email">about</label>
            <textarea name="about" class="form-control" required></textarea>
        </div>

        <div class="form-group">
            <label for="photo">Staff</label>
            <div id="kt_docs_repeater_basic">
                <!--begin::Form group-->
                <div class="form-group">
                    <div data-repeater-list="kt_docs_repeater_basic">
                        <div data-repeater-item>
                            <div class="form-group row">
                                <div class="col">
                                    <label class="form-label">Name:</label>
                                    <input type="text"  name="namestaff"class="form-control"  required>
                                </div>

                                <div class="col">
                                    <label class="form-label">title:</label>
                                    <input type="text"  name="titlestaff"class="form-control"  required>
                                </div>

                                <div class="col">
                                    <label class="form-label">image:</label>
                                    <input type="file"  name="imgestaff" class="form-control"  required>
                                </div>
                               
                                <div class="col-md-4">
                                    <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                                        <i class="la la-trash-o"></i>Delete
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--begin::Form group-->
                <div class="form-group mt-5">
                    <a href="javascript:;" data-repeater-create class="btn btn-light-primary">
                        <i class="la la-plus"></i>Add
                    </a>
                </div>
            </div>
        </div>


        <div class="form-group">
            <label for="photo">service</label>
            <div id="kt_docs_repeater_basic1">
                <!--begin::Form group-->
                <div class="form-group">
                    <div data-repeater-list="kt_docs_repeater_basic1">
                        <div data-repeater-item>
                            <div class="form-group row">
                                <div class="col">
                                    <label class="form-label">Name:</label>
                                    <input type="text"  name="nameservice"class="form-control"  required>
                                </div>

                                <div class="col">
                                    <label class="form-label">description:</label>
                                    <textarea name="descservice" class="form-control" required></textarea>
                                </div>

                                
                               
                                <div class="col-md-4">
                                    <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                                        <i class="la la-trash-o"></i>Delete
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--begin::Form group-->
                <div class="form-group mt-5">
                    <a href="javascript:;" data-repeater-create class="btn btn-light-primary">
                        <i class="la la-plus"></i>Add
                    </a>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="photo">Photo</label>
            <input type="file" name="image" class="form-control" >
        </div>

        <div class="form-group">
            <label for="photo">Photos</label>
            <input type="file" name="images[]" class="form-control" multiple>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>

    </form>
    </div>
</body>
<!-- jquery -->
<script src="{{ URL::asset('js/jquery-3.3.1.min.js') }}"></script>
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
