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
        @php
            $total_divers = 0;
            $total_price = 0;
        @endphp
        <div class="card border-dark mb-3">
            <div class="card-body">
                @php
                    $rosterType = 'Tecnico';
                @endphp
                <h5 class="card-title">Roster
                    {{ $rosterType }}
                    del
                    {{ date('d-m-Y H:i', strtotime($roster->date)) }}
                </h5>
            </div>
        </div>

        @foreach ($nextActivities as $courseName => $activities)
            <div class="card border-dark mb-3" style="page-break-inside: avoid;">
                <div class="card-header">{{ $courseName }}</div>
                <div class="card-body text-dark">
                    <h5>Prossima attività: {{ $activities[$activityType]['overall'] }}</h5>
                    @if (count($activities[$activityType]['students']))
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Nominativo</th>
                                    <th scope="col" style="text-align: left">Da recuperare</th>


                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $line_count = 0;
                                @endphp
                                @foreach ($activities[$activityType]['students'] as $studentName => $missings)
                                    @php
                                        $line_count++;
                                        $bg = 'rgba(0, 0, 0, 0.05)';
                                        if ($line_count % 2 == 0) {
                                            $bg = 'transparent';
                                        }

                                    @endphp
                                    <tr style="background-color: {{ $bg }}">
                                        <td>{{ $studentName }}</td>
                                        <td>
                                            @foreach ($missings as $sessionName => $exercises)
                                                <h6>{{ $sessionName }}</h6>
                                                <div style="margin-left: 20px">
                                                    @foreach ($exercises['missings'] as $exercise)
                                                        <p>{{ is_array($exercise) ? $exercise['label'] : $exercise }}
                                                        </p>
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        @endforeach

</body>

</html>
