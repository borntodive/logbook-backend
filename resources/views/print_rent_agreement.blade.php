<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Contratto</title>


</head>
<style>
    @page {
        margin: 180px 50px;
    }

    #header {
        position: fixed;
        left: 0px;
        top: -180px;
        right: 0px;
        height: 120px;
        text-align: center;

    }

    #footer {
        position: fixed;
        left: 0px;
        bottom: -180px;
        right: 0px;
        height: 65px;
        text-align: center;

    }

    .equipmentsTable {
        border-collapse: collapse;
        width: 100%;
        page-break-inside: avoid;
    }

    .equipmentsTable td,
    th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    .no-border {
        border: 0 !important;
    }

    .even {
        background-color: rgba(221, 221, 221, 0.3);
    }
</style>

<body>
    <div id="header">
        <img src="{{ url('storage/images/pdf/logo_tod_header_agreement.jpg') }}" height="120" style="margin:auto" />
    </div>
    <div id="footer">
        <img src="{{ url('storage/images/pdf/logo_tod_footer_agreement.jpg') }}" height="60" style="margin:auto" />
    </div>
    <div id="content" class="margin-left:16px; margin-right:16px">
        <div style="text-align: center">
            <h3>SCRITTURA PRIVATA PER IL NOLEGGIO DI ATTREZZATURA</h3>
            <h3>(ATTIVITA’ IN ACQUA LIBERA)</h3>
            <h4 style="margin-top: 10px;margin-bottom:10px">TRA</h4>
        </div>
        <p>L’Associazione Sportiva Dilettantistica TOP ONE DIVING, con sede in Via S. Quasimodo, n. 124/a, in
            persona
            del Presidente e legale rappresentante p.t. Sig. Davide Bastiani (di seguito per brevità anche
            l’Associazione)</p>
        <div style="text-align: center">

            <h4 style="margin-top: 10px;margin-bottom:10px">E</h4>
        </div>
        <p>
            @if ($rent->user->gender == 'male')
                Il Sig.
            @else
                La Sig.ra
                @endif {{ $rent->user->lastname }} {{ $rent->user->firstname }}, @if ($rent->user->gender == 'male')
                    nato
                @else
                    nata
                @endif il
                {{ $rent->user->birthdate }}
                (di seguito per
                brevità anche l’utilizzatore);
        </p>
        <p><span style="font-weight: bold">Art. 1 – Oggetto -</span> L’utilizzatore è iscritto presso la ASD Top One
            Diving ;</p>

        <p>Per lo svolgimento delle attività in acqua libera, l’Associazione mette a disposizione la seguente
            attrezzatura, per il noleggio <span style="font-weight: bold">{{ $rent->name }}</span>, come da
            seguente elenco:</p>

        <table style='width:100%; margin-top:10px;margin-bottom:10px' class="equipmentsTable">
            <thead>
                <tr>
                    <th>
                        Q.tà
                    </th>
                    <th>Tipo di Attrezzatura</th>
                    <th>
                        Tipo
                    </th>
                    <th>
                        Marca
                    </th>
                    <th>Misura</th>
                    <th>Costo Noleggio</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total = 0;
                @endphp
                @foreach ($rent->equipments as $idx => $equipment)
                    @php
                        $total += $equipment->price;
                        $class = '';
                        if ($idx % 2) {
                            $class = 'even';
                        }
                    @endphp
                    <tr class="primary {{ $class }}">
                        <td>
                            1
                        </td>
                        <td>{{ $translations['equipments'][$equipment->name] }}</td>
                        <td>
                            {{ $translations['inventory'][$equipment->type] }}
                        </td>
                        <td>
                            {{ $equipment->brand }}
                        </td>
                        <td>{{ $translations['sizes'][$equipment->size] }}</td>
                        <td style="text-align:right">{{ sprintf('%0.2f', $equipment->price) }} €</td>
                    </tr>
                @endforeach
                <tr>
                    <th class="no-border"></th>
                    <th class="no-border"></th>
                    <th class="no-border"></th>
                    <th class="no-border"></th>
                    <th>Prezzo Listino / giorno</th>
                    <td style="text-align:right">{{ sprintf('%0.2f', $total) }} €</td>
                </tr>
                <tr>
                    <th class="no-border"></th>
                    <th class="no-border"></th>
                    <th class="no-border"></th>
                    <th class="no-border"></th>
                    <th>Sconto</th>
                    <td style="text-align:right">
                        {{ $total ? sprintf('%0.2f', (($total - $rent->price) / $total) * 100) : 0 }} %
                    </td>
                </tr>
                <tr>
                    <th class="no-border"></th>
                    <th class="no-border"></th>
                    <th class="no-border"></th>
                    <th class="no-border"></th>
                    <th>Prezzo Scontato / giorno</th>
                    <td style="text-align:right">{{ sprintf('%0.2f', $rent->price) }} €</td>
                </tr>
                <tr>
                    <th class="no-border"></th>
                    <th class="no-border"></th>
                    <th class="no-border"></th>
                    <th class="no-border"></th>
                    <th>Giorni di utilizzo</th>
                    <td style="text-align:right">{{ $rent->usedDays }} </td>
                </tr>
                <tr>
                    <th class="no-border"></th>
                    <th class="no-border"></th>
                    <th class="no-border"></th>
                    <th class="no-border"></th>
                    <th>Totale</th>
                    <td style="text-align:right">{{ sprintf('%0.2f', $rent->price * $rent->usedDays) }} €</td>
                </tr>
            </tbody>
        </table>
        <table style="width:100%;margin-top:20px">
            <tr style="line-height: 50px;">
                <td>Data inizio noleggio:</td>
                <td style=""> {{ date('d-m-Y', strtotime($rent->startDate)) }}</td>
                <td>Data fine noleggio (prevista): </td>
                <td>{{ date('d-m-Y', strtotime($rent->endDate)) }}</td>
            </tr>
        </table>

        <p>Le parti danno espressamente atto, con la firma della presente scrittura, che tali beni sono stati
            esaminati
            dall’utilizzatore insieme ad un istruttore autorizzato dell’associazione e si trovano in stato di
            perfetto
            funzionamento e manutenzione.</p>
        <p><span style="font-weight: bold">Art. 2 – Utilizzo delle attrezzature -</span> Il noleggio e l’utilizzo
            delle
            attrezzature è limitato ai soli Soci dell’associazione e per le sole attività da essa organizzate. E’
            fatto
            espresso divieto di consentire a terzi, a titolo gratuito o oneroso, l’utilizzo delle attrezzature
            oggetto
            del presente accordo.</p>
        <p><span style="font-weight: bold">Art. 3 – Obblighi delle parti -</span> L’Associazione si obbliga a
            consegnare
            i predetti beni in perfetta efficienza, debitamente sanificati ed a garantirne il pacifico godimento da
            parte dell’utilizzatore per la durata del presente accordo.
            L’utilizzatore si obbliga a prendere in consegna i predetti beni, a conservarli con la diligenza di buon
            padre di famiglia ed a restituirli alla scadenza del contratto, per tale dovendosi intendere la
            conclusione
            per qualunque ragione dell’attività didattica, anche per fatto o responsabilità esclusivi
            dell’associazione
            ed a prescindere dall’ottenimento del brevetto.</p>
        <p><span style="font-weight: bold">Art. 4 – Responsabilità dell’utilizzatore -</span> L’utilizzatore è
            responsabile della custodia dell’attrezzatura e dei danni provocati a sé ed a terzi per uso improprio ed
            è
            responsabile della rottura, distruzione o perdita dei
            medesimi anche se fossero causati da terzi. Nelle ipotesi di danneggiamento, distruzione o perdita di un
            bene, egli è tenuto a rifondere all’Associazione i costi per la riparazione o il riacquisto dello
            stesso.
        </p>
        <p><span style="font-weight: bold">Art. 5 – Scadenza del contratto -</span> Il contratto ha termine alla
            data di fine noleggio effettiva. Alla scadenza i beni dovranno
            essere
            restituiti presso la sede dell’Associazione.
        </p>
        <p><span style="font-weight: bold">Art. 6 – Facoltà di recesso -</span> Resta salva la facoltà di entrambe
            le
            parti di recedere in qualsiasi momento per qualsiasi motivo dal presente accordo. In questo caso
            l’utilizzatore si impegna a restituire immediatamente i beni oggetto del presente contratto, fermi gli
            obblighi di cui agli artt. 2 e 3 che precedono.
        </p>
        <p><span style="font-weight: bold">Art. 7 – Disposizioni generali -</span> Qualsiasi modifica al presente
            contratto dovrà essere fatta per iscritto e sottoscritta da entrambe le parti a pena di nullità.
        </p>
        <p>
            Letto confermato e sottoscritto
        </p>
        <p style="margin-top:20px">
            Roma, il {{ now()->format('d-m-Y') }}
        </p>
        <table style="width:100%;margin-top:20px">
            <tr style="line-height: 50px;">
                <td>Nome e Cognome</td>
                <td>Firma</td>
            </tr>
            <tr>
                <td> {{ $rent->user->lastname }} {{ $rent->user->firstname }}</td>
                <td>______________________________</td>
            </tr>
        </table>
</body>

</html>
