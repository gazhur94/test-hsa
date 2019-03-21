<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                margin-top: 100px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
            }


        </style>
    </head>
    <body>

        <div class="flex-center position-ref">
             @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Go to admin page</a>
                    @else
                        <a href="{{ route('login') }}">Go to admin page</a>

                    @endauth
                </div>
             @endif

                 <div class="container content">
                     <div class="row justify-content-center">
                         <div class="col-md-12">
                             <div class="card">
                                 <div class="card-header">Documents</div>

                                 <div class="card-body">
                                     <table class="table table-striped">
                                         <thead>
                                         <tr>
                                             <th scope="col"></th>
                                         </tr>
                                         </thead>
                                         <tbody>

                                        @if(count($documents) <= 0)
                                            <tr >
                                                <td style="text-align: center">
                                                    There are no documents yet
                                                </td>
                                            </tr>
                                        @else
                                             @foreach($documents as $document)
                                                 <tr >
                                                     <td class="links">
                                                         <a  href="/storage/uploads/document_{{$document->id}}.pdf" target="_blank">{{$document->name}}</a>
                                                     </td>
                                                 </tr>
                                             @endforeach
                                        @endif
                                         </tbody>
                                     </table>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>

        </div>

    </body>
    <script src="{{ asset('js/app.js') }}"></script>
</html>
