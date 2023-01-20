<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Roster</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

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
            <div class="card-header">Diving</div>

            <div class="card-body">
                <h6>{{ $roster->diving->name }}</h6>
                <div class="row">
                    <div class="col-6">
                        {{ $roster->diving->address }} </div>
                    <div class="col">
                        {{ $roster->diving->reference }}
                    </div>
                    <div class="col">
                        {{ $roster->diving->phone }} </div>
                    <div class="col">
                        {{ $roster->diving->email }} </div>

                </div>
            </div>
        </div>

        @foreach ($roster->dives as $idx => $dive)
            <div style="page-break-inside: avoid;">
                <h2>Immersione # {{ $idx + 1 }}</h2>
                @foreach ($dive->divers as $course)
                    <div class="card border-dark mb-3">
                        <div class="card-header">{{ $course->course == 'GUESTS' ? 'Ospiti' : $course->course }}</div>
                        <div class="card-body text-dark">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col">Nominativo</th>
                                        @foreach ($equipments as $equipment)
                                            <th style="text-align: center" scope="col">
                                                {{ $equipment['translation'] }}
                                            </th>
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
                                            <td>
                                                @if ($diver->in_charge)
                                                    @php
                                                        $img = base64_encode('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M16 0H144c5.3 0 10.3 2.7 13.3 7.1l81.1 121.6c-49.5 4.1-94 25.6-127.6 58.3L2.7 24.9C-.6 20-.9 13.7 1.9 8.5S10.1 0 16 0zM509.3 24.9L401.2 187.1c-33.5-32.7-78.1-54.2-127.6-58.3L354.7 7.1c3-4.5 8-7.1 13.3-7.1H496c5.9 0 11.3 3.2 14.1 8.5s2.5 11.5-.8 16.4zM432 336c0 97.2-78.8 176-176 176s-176-78.8-176-176s78.8-176 176-176s176 78.8 176 176zM264.4 241.1c-3.4-7-13.3-7-16.8 0l-22.4 45.4c-1.4 2.8-4 4.7-7 5.1L168 298.9c-7.7 1.1-10.7 10.5-5.2 16l36.3 35.4c2.2 2.2 3.2 5.2 2.7 8.3l-8.6 49.9c-1.3 7.6 6.7 13.5 13.6 9.9l44.8-23.6c2.7-1.4 6-1.4 8.7 0l44.8 23.6c6.9 3.6 14.9-2.2 13.6-9.9l-8.6-49.9c-.5-3 .5-6.1 2.7-8.3l36.3-35.4c5.6-5.4 2.5-14.8-5.2-16l-50.1-7.3c-3-.4-5.7-2.4-7-5.1l-22.4-45.4z"/></svg>');
                                                    @endphp
                                                    <img src="data:image/svg+xml;base64,{{ $img }}"
                                                        width="15px" style="margin-auto" />
                                                @endif
                                                @if ($diver->teaching)
                                                    @php
                                                        $img = base64_encode('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M399 384.2C376.9 345.8 335.4 320 288 320H224c-47.4 0-88.9 25.8-111 64.2c35.2 39.2 86.2 63.8 143 63.8s107.8-24.7 143-63.8zM512 256c0 141.4-114.6 256-256 256S0 397.4 0 256S114.6 0 256 0S512 114.6 512 256zM256 272c39.8 0 72-32.2 72-72s-32.2-72-72-72s-72 32.2-72 72s32.2 72 72 72z"/></svg>');
                                                    @endphp
                                                    <img src="data:image/svg+xml;base64,{{ $img }}"
                                                        width="15px" style="margin-auto" />
                                                @endif
                                            </td>
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
            </div>
        @endforeach

</body>

</html>
