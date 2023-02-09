<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Roster</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .div-table {
            display: table;
            width: 100%;
            overflow: scroll;
            background-color: #eee;
            border-spacing: 2px;
            border-radius: 4px;
        }

        .trow {
            display: table-row
        }

        .tcolumn {
            display: table-cell;
            vertical-align: top;
            background-color: #fff;
            padding: 10px 8px
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
                        <div class="div-table">
                            <div class="trow">
                                <div class="tcolumn tcolumn1">Nominativo</div>
                                <div class="tcolumn tcolumn2">Da recuperare</div>
                            </div>


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
                                <div class="trow">
                                    <div class="tcolumn">{{ $studentName }}</div>
                                    <div class="tcolumn">
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
                                    </div>
                                </div>
                            @endforeach
                        </div>
                </div>
        @endif
    </div>
    </div>
    @endforeach

</body>

</html>
