<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Roster</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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

        .table-header {
            width: 100%;
            border-bottom: 0.5px solid;
            font-weight: 500;
            font-size: 1rem;
            line-height: 1.5;
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
    <div style=" margin-left: 1rem;  margin-right: 1rem;">
        @php
        $total_divers = 0;
        $total_price = 0;
        $total_dive = 0;
        $total_gears = 0;
        $total_courses = 0;
        @endphp
        <div class="card">
            <div class="card-body">
                @php
                $rosterType = 'Amministrativo';
                @endphp
                <h5 class="card-title">Roster
                    {{ $rosterType }}
                    del
                    {{ date('d-m-Y H:i', strtotime($roster->date)) }}
                </h5>
            </div>
        </div>
        <div class="card">
            <div class="card-header">Diving</div>
            <div class="card-body">
                <h6>{{ $roster->diving->name }}</h6>
                <div class="row">
                    <div class="col-6">
                        {{ $roster->diving->address }}
                    </div>
                    <div class="col">
                        {{ $roster->diving->reference }}
                    </div>
                    <div class="col">
                        {{ $roster->diving->phone }}
                    </div>
                    <div class="col">
                        {{ $roster->diving->email }}
                    </div>

                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">{{ 'Ospiti' }}</div>
            <div class="card-body text-dark">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Nominativo</th>
                            <th scope="col" style="text-align: right">Saldo</th>
                            <th scope="col" style="text-align: right">Pagato</th>
                            <th scope="col" style="text-align: right">Acconto</th>

                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $rowCount = 0;
                        @endphp
                        @foreach ($divers as $diver)
                        @php
                        $rowCount++;
                        $class = 'even-row';
                        if ($rowCount % 2 === 0) {
                        $class = 'odd-row';
                        }
                        @endphp
                        <tr class="{{ $class }}">
                            <td>{{ $diver['name'] }}</td>
                            <td style="text-align: right">
                                @if ($roster->type == 'DIVE')
                                <p>Immersione:

                                    {{ $diver->price ? number_format((float) $diver['balance']['dive'], 2) : number_format((float) 0, 2) }}
                                    €
                                </p>
                                @endif
                                @if ($diver['balance']['course'])
                                <p>Corso:

                                    {{ number_format((float) $diver['balance']['course'], 2) }}
                                    €
                                </p>
                                @endif

                            </td>
                            <td>
                                <div style="display: flex;flex-direction: column; gap: 22px; width: 20px;float: right;">
                                    <div style="display:block;float:right;border:solid; height:20px;width:20px">
                                    </div>
                                    @if (!$diver['balance']['course'])
                                    <div style="display:block;float:right;border:solid; height:20px;width:20px">
                                    </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card border-dark mb-3" style="page-break-before: always;">
            <div class="card-header">Totali</div>
            <div class="card-body">
                @php
                $total_cost = $roster->cost * $total_divers - $roster->cost * $roster->gratuities;
                $gain = $total_dive + $total_gears - $total_cost;
                @endphp
                <div class="table-header"> Immersione</div>
                <table class="table">
                    <tbody>
                        <tr>

                            <td style="width: 16.6%">Incasso</td>
                            <td style="width: 16.6%">{{ number_format((float) $totals['dive']['income'], 2) }} €</td>
                            <td style="width: 16.6%">Dovuto</td>
                            <td style="width: 16.6%">{{ number_format((float) $totals['dive']['cost'], 2) }} €</td>

                            <td style="width: 16.6%">Saldo</td>
                            <td style="width: 16.6%">{{ number_format((float) $totals['dive']['income']- $totals['dive']['cost'] 2) }}
                                €
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="table-header">Attrezzature</div>
                <table class="table">
                    <tbody>
                        <tr>

                            <td style="width: 16.6%">Incasso</td>
                            <td style="width: 16.6%">{{ number_format((float) $totals['equipment']['income'], 2) }} €</td>
                            <td style="width: 16.6%"></td>
                            <td style="width: 16.6%"></td>


                            <td style="width: 16.6%">Saldo</td>
                            <td style="width: 16.6%">{{ number_format((float) $totals['equipment']['income'], 2) }}
                                €
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="table-header">Totale</div>
                <table class="table">
                    <tbody>
                        <tr>

                            <td style="width: 16.6%">Incasso</td>
                            <td style="width: 16.6%">{{ number_format((float) $total_gears + $total_dive, 2) }} €
                            </td>
                            <td style="width: 16.6%">Dovuto</td>
                            <td style="width: 16.6%">{{ number_format((float) $total_cost, 2) }} €</td>

                            <td style="width: 16.6%">Saldo</td>
                            <td style="width: 16.6%">{{ number_format((float) $gain, 2) }}
                                €
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="table-header">Corsi</div>
                <table class="table">
                    <tbody>
                        <tr>

                            <td style="width: 16.6%">Incasso</td>
                            <td style="width: 16.6%">{{ number_format((float) $total_courses, 2) }} €
                            </td>
                            <td style="width: 16.6%"></td>
                            <td style="width: 16.6%"></td>

                            <td style="width: 16.6%">Saldo</td>
                            <td style="width: 16.6%">{{ number_format((float) $total_courses, 2) }}
                                €
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="table-header">Numero Gratuità: {{ $roster->gratuities }}</div>
            </div>
        </div>
</body>

</html>
