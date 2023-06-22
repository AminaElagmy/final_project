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

     <h1>Show Category</h1>

    <div class="table-responsive">
    <table class="table">

        <thead>
            <tr>
              <th>Id</th>
              <th>Name</th>
              <th>Discription</th>
              <th>Parent_id</th>
              <th>Image</th>
              <th>Created At</th>

            </tr>
        </thead>

        <tbody>
         <tr>
              <td>{{$category->id}}</td>
              <td>{{$category->name}}</td>
              <td>{{$category->discription}}</td>
              <td>{{$category->parent_id}}</td>
              <td> <img src="{{$category->getFirstMediaUrl()}}" height="100px" width="100px"></td>
              <td> {{ $category->created_at }}</td>

         </tr>

        </tbody>
    </table>
         </div>
        </div>

</body>
</html>
