<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Roster</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/59194b772c.js" crossorigin="anonymous"></script>

</head>

<body>
    <div class="mx-4">
        <div class="card border-dark mb-3">
            <div class="card-body">
                @php
                    $rosterType = '';
                    if ($roster->type == 'POOL') {
                        $rosterType = 'Piscina';
                    } elseif ($roster->type == 'DIVE') {
                        $rosterType = 'Immersione';
                    } elseif ($roster->type == 'THEORY') {
                        $rosterType = 'Teoria';
                    }

                @endphp
                <h5 class="card-title">Roster
                    {{ $rosterType }}
                    del
                    {{ date('d-m-Y H:i', strtotime($roster->date)) }}</h5>
            </div>
        </div>
        <div class="card border-dark mb-3">
            <div class="card-body">
                <h5 class="card-title">Diving</h5>
                <h6>{{ $roster->diving->name }}</h6>
                <div class="row">
                    <div class="col-6">
                        {{ $roster->diving->address }} </div>
                    <div class="col">
                        {{ $roster->diving->phone }} </div>
                    <div class="col">
                        {{ $roster->diving->email }} </div>
                </div>
            </div>
        </div>
        @foreach ($roster->divers as $course)
            <div class="card border-dark mb-3">
                <div class="card-header">{{ $course->course == 'GUESTS' ? 'Ospiti' : $course->course }}</div>
                <div class="card-body text-dark">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Nominativo</th>
                                @foreach ($equipments as $equipment)
                                    <th style="text-align: center" scope="col">{{ $equipment['translation'] }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $divers = collect($course->divers)->sortBy(function ($item, $key) {
                                    return [!$item->teaching, !$item->in_charge, $item->lastname, $item->firstname];
                                });

                            @endphp
                            @foreach ($divers as $diver)
                                <tr>
                                    <th scope="row">
                                        @if ($diver->in_charge)
                                            <i class="fa-solid fa-medal"></i>
                                        @endif
                                        @if ($diver->teaching)
                                            <i class="fa-solid fa-circle-user"></i>
                                        @endif
                                    </th>
                                    <td>{{ $diver->lastname }} {{ $diver->firstname }}</td>
                                    @foreach ($equipments as $key => $equipment)
                                        @php
                                            $currentSize = '';
                                            foreach ($diver->gears as $gear) {
                                                if ($gear->name == $equipment['name']) {
                                                    if ($gear->size && isset($sizes[$gear->size])) {
                                                        $currentSize = $sizes[$gear->size];
                                                    } elseif ($gear->number) {
                                                        $currentSize = $gear->number;
                                                    } else {
                                                        $currentSize = $gear->size;
                                                    }
                                                    break;
                                                }
                                            }

                                        @endphp
                                        <td style="text-align: center">{{ $currentSize }}</td>
                                    @endforeach
                                </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
</body>

</html>
