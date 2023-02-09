<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Roster</title>
    <style>
        .mx-4 {
            margin-left: 1rem;

        }

        h5 {
            font-size: 1.25rem;
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-clip: border-box;
            border: 1px solid rgba(0, 0, 0, .125);
            border-radius: 0.25rem;
            margin-bottom: 0.75rem;
        }

        .card-header {
            padding: 0.5rem 1rem;
            margin-bottom: 0;
            background-color: rgba(0, 0, 0, .03);
            border-bottom: 1px solid rgba(0, 0, 0, .125);
        }

        .card-body {
            flex: 1 1 auto;
            padding: 1rem 1rem;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            vertical-align: top;
            border-color: #dee2e6;

        }

        tbody {
            width: 100%;
            border-top: 0.5px solid;

        }

        thead:after {
            content: "@";
            display: block;
            line-height: 10px;
            text-indent: -99999px;
        }

        .odd-row {
            background-color: rgba(0, 0, 0, 0.05);

        }

        .even-row {
            background-color: transparent;

        }
    </style>
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
                    {{ date('d-m-Y', strtotime($roster->date)) }}
                </h5>
            </div>
        </div>

        @foreach ($nextActivities as $courseName => $activities)
            <div class="card border-dark mb-3">
                <div class="card-header">{{ $courseName }}</div>
                <div class="card-body text-dark">
                    <h5>Prossima attività:
                        @if ($activities[$activityType]['overall'] < 9999)
                            {{ $activityTypeName }} {{ $activities[$activityType]['overall'] }}
                        @else
                            Completata
                        @endif
                    </h5>
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
                                                @if (!$exercises['completed'])
                                                    <h6>{{ $sessionName }}</h6>
                                                    <div style="margin-left: 20px">
                                                        @foreach ($exercises['missings'] as $exercise)
                                                            <p>{{ is_array($exercise) ? $exercise['label'] : $exercise }}
                                                            </p>
                                                        @endforeach
                                                    </div>
                                                @endif
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
