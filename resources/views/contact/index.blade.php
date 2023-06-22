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

     <h1 class="mb-3">{{$title}}</h1>

    <div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Subject</th>
              <th>message</th>
              
            </tr>
        </thead>

        <tbody>
         <?php foreach($contacts as $contact):?>
         <tr>
              <td> {{$contact->name}}</td>
              <td>{{$contact->email}}</td>
              <td> {{$contact->subject}}</td>
              <td> {{$contact->message}}</td>
             
            </tr>
         <?php endforeach ?>
        </tbody>
    </table>
         </div>
        </div>
    
</body>
</html>