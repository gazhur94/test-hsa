<html>
    <head>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <meta charset="utf-8">
    </head>
    <body>
        <h1 style="text-align: center">{{$document->name}}</h1>
        <ul>
            @foreach($document->files as $file)
                <li><a href="/storage/{{$file->path}}">{{$file->name}}</a></li>
            @endforeach
        </ul>
    </body>
</html>