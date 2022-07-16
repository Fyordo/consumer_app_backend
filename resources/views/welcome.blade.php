@php
    use Illuminate\Support\Facades\URL;
    use \App\Http\Resources\FlatResource;
    use \App\Models\Flat;
    /**
    * @var $data array
     */

    $data = FlatResource::collection(Flat::all())->toArray(request());
@endphp
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::asset('public/css/app.css') }}">

    <title>Админ - панель</title>
</head>
<body>
<div class="container">
    <div id="images">
        <div class="about1">
            <img src="{{URL::asset('favicon.ico')}}" width="100" height="100" alt="">
        </div>

        <div class="about2" align="right">
            <h3>Иванов И.И.</h3>
        </div>

    </div>
    <br>
    <h1 align="center">АДМИН ПАНЕЛЬ</h1>
    <br>
    <div class="content">
        <h3 class="heading">Все квартиры</h3>
        <!-- table__wrapper for y axis scrolling -->
        <div class="table__wrapper">
            <table class="table">
                <thead>
                <tr class="table__row">
                    <th class="table__heading">Название</th>
                    <th class="table__heading">Статус</th>
                    <th class="table__heading">Площадь</th>
                    <th class="table__heading">Кол-во этажей</th>
                    <th class="table__heading">Жилая площадь</th>
                    <th class="table__heading">Кол-во комнат</th>
                    <th class="table__heading">Площадь без балкона и т.п.</th>
                    <th class="table__heading">Цена</th>
                    <th class="table__heading">Цена за кв.м.</th>
                    <th class="table__heading">Готовность</th>
                    <th class="table__heading">Вид</th>
                    <th class="table__heading">Материал</th>
                    <th class="table__heading">Высота</th>
                    <th class="table__heading">Парковка</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($data as $line)
                    <tr class="table__row">
                        <td class="table__data">{{$line['title']}}</td>
                        <td class="table__data">{{$line['status']['title']}}</td>
                        <td class="table__data">{{$line['full_space']}}</td>
                        <td class="table__data">{{$line['floor_count']}}</td>
                        <td class="table__data">{{$line['living_space']}}</td>
                        <td class="table__data">{{$line['room_count'] == 0 ? "Студия" : $line['room_count']}}</td>
                        <td class="table__data">{{$line['balconyless_space']}}</td>
                        <td class="table__data">{{$line['cost']}}</td>
                        <td class="table__data">{{$line['is_ready'] ? "Готова" : "Не готова"}}</td>
                        <td class="table__data">{{$line['repair']}}</td>
                        <td class="table__data">{{$line['view']}}</td>
                        <td class="table__data">{{$line['height']}}</td>
                        <td class="table__data">{{$line['material']}}</td>
                        <td class="table__data">{{$line['parking']}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div><br>
</div>
</body>
</html>
