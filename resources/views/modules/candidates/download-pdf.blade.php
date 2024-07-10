@php use SimpleSoftwareIO\QrCode\Facades\QrCode; @endphp
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Result {{ $type }} {{ $result['index_number'] }}</title>
</head>
<style>
    body {
        font-family: Helvetica, Arial, sans-serif;
        font-size: 16px;
    }

    #session {
        padding-top: 38%;
        text-align: center;
        line-height: 0.4;
    }

    #student-details {
        padding-top: 20px;
        font-weight: bold;
        line-height: 1;
        /* font-size: 14px; */
    }

    #student-details-2 {
        padding-top: -5px;
        font-weight: bold;
        line-height: 1;
        font-size: 14px;
    }

    #score {
        padding-top: 10px;
    }

    #score td {
        padding-top: 7px;
        padding-bottom: 7px;
        vertical-align: middle;
    }

    #score th {
        padding-top: 7px;
        padding-bottom: 7px;
        vertical-align: middle;
    }

    #band {
        padding-top: 15px;
    }

    #band th {
        padding-top: 7px;
        padding-bottom: 7px;
        vertical-align: middle;
    }

    #signature {
        padding-top: 90px;
        line-height: 0.8;
    }

    #qr {
        padding-top: 50px;
    }

    #scheme-student {
        width: 105%;
        margin-top: -3px;
        margin-left: -15px;
        margin-right: -15px;
    }

    #scheme-student td {
        font-size: 8.5pt;
    }



    #scheme {
        /* width: 100%; */
        border-collapse: collapse;
        border: 2px solid black;
        /* Border around the entire table */
        width: 105%;
        margin-left: -15px;
        margin-right: -15px;
    }

    #scheme th,
    #scheme td {
        border: 1px solid black;
        /* Borders around each cell */
        padding: 5px;
        text-align: center
    }

    #scheme th {
        font-size: 8.5pt;
        text-align: center;
        background-color: #000000;
        color: #ffffff;
    }

    #scheme td {
        font-size: 8.5pt;
        text-align: center
    }

    .highlight {
        background-color: #dedada;
    }

    .border {
        border: 1px solid black;
        /* Borders around each cell */
    }


    #band-achieved {
        /* width: 100%; */
        /* border-collapse: collapse;
        border: 2px solid black; Border around the entire table */
        width: 105%;
        margin-left: -15px;
        margin-right: -15px;
    }

    th[colspan="3"] {
        background-color: initial;
        color: initial;
    }

    td[colspan="3"] {
        text-align: justify;
    }

    @media (max-width: 768px) {

        th,
        td {
            font-size: 8pt;
            padding: 3px;
        }
    }
</style>

<body>

    <div id="page-1" style="padding-left: 10%; padding-right: 10%;page-break-after: always;">
        <div class="row logo-container" style="text-align: center; padding-top: 90px">
            <span style="padding-right: 10px">
                {{-- <img style="width: 100px" src="{{ URL::asset('build/images/jatanegara/JataNegara.png') }}" alt="Logo1"> --}}
                <img style="width: 100px" src="https://sijil.mpm.edu.my/build/images/jatanegara/JataNegara.png" alt="Logo1">
            </span>
            <span>
                {{-- <img style="width: 80px;height: auto;" src="{{ URL::asset('build/images/logo-mpm-kuningpinang.jpg') }}" --}}
                <img style="width: 80px;height: auto;" src="https://sijil.mpm.edu.my/build/images/logo-mpm-kuningpinang.jpg"
                    alt="Logo">
            </span>
        </div>
        <div id="title_session" style="text-align: center; padding-top: 25px">
            <span style="font-size: 15pt; font-weight: bolder">MAJLIS PEPERIKSAAN MALAYSIA</span><br>
            <span style="font-size: 12pt; font-weight: bold">MALAYSIAN EXAMINATIONS COUNCIL</span>
            <p style="font-size: 10pt">This is to certify that the below candidate has sat for the</p>
            <span style="font-size: 12pt; font-weight: bolder">MALAYSIAN UNIVERSITY ENGLISH TEST <br>
                {{ Str::upper($tarikh->sesi) }}</span>
            <p style="font-size: 10pt">and obtained the following score.</p>
        </div>
        {{-- <div id="session">
        <p style="font-weight: bold; font-size: 22px; margin-bottom: 0.1em;">{{ $result['session'] }}</p>
        <p style="font-size: 17px">and obtained the following score</p>
        </div> --}}
        <div id="student-details">
            <table style="width: 105%; margin-left: -15px; margin-right: -15px; font-size:16pt">
                <tr>
                    <td>{{ strtoupper($candidate->nama) }}</td>
                </tr>
                <tr>
                    <td style="text-align: left">{{ $candidate->kp }}</td>
                    <td style="text-align: right">{{ $result['index_number'] }}</td>
                </tr>
            </table>
        </div>
        <div id="score">
            <table
                style="text-align: center; width: 105%; margin-left: -15px; margin-right: -15px; border-collapse: collapse;font-size: 10pt">
                {{-- <tr style="background-color: lightgrey;"> --}}
                <tr>
                    <td style="border: 1px solid black;">Test Component</td>
                    <td style="border: 1px solid black;">Maximum Score</td>
                    <td width="33%" style="border: 1px solid black;">Obtained Score</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; border-top: 0; border-bottom: 0;text-align: left;padding-left: 5px"> LISTENING</td>
                    <td style="border: 1px solid black; border-top: 0; border-bottom: 0">{{ $scheme['listening'] }}</td>
                    <td width="33%" style="border: 1px solid black; border-top: 0; border-bottom: 0"> {{ $result['listening'] }}</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; border-top: 0; border-bottom: 0;text-align: left;padding-left: 5px"> SPEAKING</td>
                    <td style="border: 1px solid black; border-top: 0; border-bottom: 0">{{ $scheme['speaking'] }}</td>
                    <td width="33%" style="border: 1px solid black; border-top: 0; border-bottom: 0"> {{ $result['speaking'] }}</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; border-top: 0; border-bottom: 0;text-align: left;padding-left: 5px"> READING</td>
                    <td style="border: 1px solid black; border-top: 0; border-bottom: 0">{{ $scheme['reading'] }}</td>
                    <td width="33%" style="border: 1px solid black; border-top: 0; border-bottom: 0"> {{ $result['reading'] }}</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; border-top: 0; border-bottom: 0;text-align: left;padding-left: 5px"> WRITING</td>
                    <td style="border: 1px solid black; border-top: 0; border-bottom: 0">{{ $scheme['writing'] }}</td>
                    <td width="33%" style="border: 1px solid black; border-top: 0; border-bottom: 0"> {{ $result['writing'] }}</td>
                </tr>
                <tr>
                    <th style="border: 1px solid black;text-align: left;padding-left: 5px">AGGREGATED SCORE</th>
                    <th style="border: 1px solid black;">{{ $scheme['agg_score'] }}</th>
                    <th width="33%" style="border: 1px solid black;">{{ $result['agg_score'] }}</th>
                </tr>
            </table>
        </div>

        <div id="band">
            <table
                style="text-align: center; width: 105%; margin-left: -15px; margin-right: -15px; border-collapse: collapse">
                <tr>
                    <th style="border: 1px solid black;text-align: left; padding-left: 5px">BAND ACHIEVED</th>
                    <th width="33%" style="border: 1px solid black; background-color: white">{{ $result['band'] }}
                    </th>
                </tr>
            </table>
        </div>

        <div id="signature">
            {{-- <table style="width: 105%; margin-left: -15px; margin-right: -15px">
            <tr>
                @if ($result['year'] > 2020) above 2020
                    <td style="font-weight: bold">PROF. DATO' GS. TS. DR. MOHD EKHWAN HJ. TORIMAN</td>
                @else 2020 and before
                    <td style="font-weight: bold">PROF. DATUK TS. DR. WAHID BIN RAZALLY</td>
                @endif

                <td style="font-weight: bold">ADNAN BIN HUSIN</td>
            </tr>
            <tr>
                <td style="font-size: 14px">Chairman</td>
                <td style="font-size: 14px">Chief Executive</td>
            </tr>
            <tr>
                <td style="font-size: 14px">Malaysian Examinations Council</td>
                <td style="font-size: 14px">Malaysian Examinations Council</td>
            </tr>
            <tr>
                <td></td>
                <td style="font-size: 14px; padding-top: 37px">Date of issue: {{ date($result['issue_date']) }}</td>
            </tr>
            <tr>
                <td></td>
                <td style="font-size: 14px; font-weight: bold">Date of expiry: {{ date($result['exp_date']) }}</td>
            </tr>
        </table> --}}
            <table style="width: 105%; margin-left: -15px; margin-right: -15px;">
                <tr>
                    <td>
                        <img style="width: 100px" src="{{ URL::asset('build/images/sign/sign_new.png') }}" alt="Logo">
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left">
                        <div style="line-height: 1.0;">
                            <span style="font-weight: bold; font-size: 12pt;">ADNAN BIN HUSIN</span><br>
                            <span style="font-size: 10pt;">Chief Executive</span><br>
                            <span style="font-size: 10pt;">Malaysian Examinations Council</span>
                        </div>
                    </td>
                    <td style="text-align: right;">
                        <div style="float: right;">
                            <table>
                                <tr>
                                    <td style="font-size: 14px;">Date of issue</td>
                                    <td style="font-size: 14px;">:</td>
                                    <td style="font-size: 14px;">{{ $result['issue_date'] }}</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 14px; font-weight: bold;">Date of expiry</td>
                                    <td style="font-size: 14px; font-weight: bold;">:</td>
                                    <td style="font-size: 14px; font-weight: bold;">{{ $result['exp_date'] }}</td>
                                </tr>
                            </table>
                        </div>
                    </td>

                </tr>
            </table>
        </div>
        <div id="qr">

            <table style="width: 105%; margin-left: -15px; margin-right: -15px">
                <tr>
                    <td style="text-align: right"><img src="data:image/jpg;base64,{{ base64_encode($qr) }}"
                            alt="QR Code"></td>
                </tr>
            </table>

        </div>
    </div>

    @if ($result['year'] > 1999 && $result['year'] < 2008)
        <div id="back-tahun-1999">
            <div id="table-title">
                <table
                    style="text-align: center; width: 105%; margin-left: -15px; margin-right: -15px; border-collapse: collapse">
                    <tr>
                        <th
                            style="background-color: rgb(235, 180, 0);border: 1px solid black; text-align: center;padding: 10px">
                            MUET BAND DESCRIPTION</th>
                    </tr>
                </table>
            </div>

            <div id="table-content">
                <table
                    style="width: 105%; margin-left: -15px; margin-right: -15px; border-collapse: collapse;padding-top: 30px">
                    <thead>
                        <tr>
                            <th
                                style="background-color: #9a9a9a;color: white;text-align: center; border: 1px solid black; font-size: 10pt;padding: 10px">
                                AGGREGATED SCORE </th>
                            <th
                                style="background-color: #9a9a9a;color: white;text-align: center; border: 1px solid black; font-size: 10pt;padding: 10px">
                                BAND </th>
                            <th
                                style="background-color: #9a9a9a;color: white;text-align: center; border: 1px solid black; font-size: 10pt;padding: 10px">
                                USER </th>
                            <th
                                style="background-color: #9a9a9a;color: white;text-align: center; border: 1px solid black; font-size: 10pt;padding: 10px">
                                COMMAND OF LANGUAGE </th>
                            <th
                                style="background-color: #9a9a9a;color: white;text-align: center; border: 1px solid black; font-size: 10pt;padding: 10px">
                                COMMUNICATIVE ABILITY </th>
                            <th
                                style="background-color: #9a9a9a;color: white;text-align: center; border: 1px solid black; font-size: 10pt;padding: 10px">
                                UNDERSTANDING </th>
                            <th
                                style="background-color: #9a9a9a;color: white;text-align: center; border: 1px solid black; font-size: 10pt;padding: 10px">
                                TASK PERFORMANCE </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class={{ $result['agg_score'] >= 260 && $result['agg_score'] <= 300 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">260 – 300 </td>
                            <td class={{ $result['agg_score'] >= 260 && $result['agg_score'] <= 300 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">6</td>
                            <td class={{ $result['agg_score'] >= 260 && $result['agg_score'] <= 300 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">Very good user</td>
                            <td class={{ $result['agg_score'] >= 260 && $result['agg_score'] <= 300 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">Very good command
                                of the language</td>
                            <td class={{ $result['agg_score'] >= 260 && $result['agg_score'] <= 300 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">Highly expressive,
                                accurate and appropriate; hardly any inaccuracies</td>
                            <td class={{ $result['agg_score'] >= 260 && $result['agg_score'] <= 300 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">High level of
                                understanding of the language</td>
                            <td class={{ $result['agg_score'] >= 260 && $result['agg_score'] <= 300 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">Functions extremely
                                well in the language</td>
                        </tr>
                        <tr>
                            <td class={{ $result['agg_score'] >= 220 && $result['agg_score'] <= 259 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">220 – 259
                            </td>
                            <td class={{ $result['agg_score'] >= 220 && $result['agg_score'] <= 259 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">5</td>
                            <td class={{ $result['agg_score'] >= 220 && $result['agg_score'] <= 259 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">Good user
                            </td>
                            <td class={{ $result['agg_score'] >= 220 && $result['agg_score'] <= 259 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">Good
                                command of
                                the language</td>
                            <td class={{ $result['agg_score'] >= 220 && $result['agg_score'] <= 259 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">
                                Expressive, accurate
                                and appropriate but
                                with minor
                                inaccuracies</td>
                            <td class={{ $result['agg_score'] >= 220 && $result['agg_score'] <= 259 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">Good
                                level of
                                understanding of the
                                language
                            </td>
                            <td class={{ $result['agg_score'] >= 220 && $result['agg_score'] <= 259 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">
                                Functions well in the
                                language</td>
                        </tr>
                        <tr>
                            <td class={{ $result['agg_score'] >= 180 && $result['agg_score'] <= 219 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">180 –
                                219</td>
                            <td class={{ $result['agg_score'] >= 180 && $result['agg_score'] <= 219 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">4</td>
                            <td class={{ $result['agg_score'] >= 180 && $result['agg_score'] <= 219 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">
                                Competent
                                user
                            </td>
                            <td class={{ $result['agg_score'] >= 180 && $result['agg_score'] <= 219 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">
                                Satisfactory
                                command of the
                                language</td>
                            <td class={{ $result['agg_score'] >= 180 && $result['agg_score'] <= 219 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">
                                Generally expressive
                                and appropriate but
                                with occasional
                                inaccuracies</td>
                            <td class={{ $result['agg_score'] >= 180 && $result['agg_score'] <= 219 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">
                                Satisfactory level of
                                understanding of the
                                language
                            </td>
                            <td class={{ $result['agg_score'] >= 180 && $result['agg_score'] <= 219 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">
                                Functions
                                reasonably well in
                                the language</td>
                        </tr>
                        <tr>
                            <td class={{ $result['agg_score'] >= 140 && $result['agg_score'] <= 179 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">140 –
                                179</td>
                            <td class={{ $result['agg_score'] >= 140 && $result['agg_score'] <= 179 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">3</td>
                            <td class={{ $result['agg_score'] >= 140 && $result['agg_score'] <= 179 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">
                                Modest user
                            </td>
                            <td class={{ $result['agg_score'] >= 140 && $result['agg_score'] <= 179 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">
                                Fair command of
                                the language</td>
                            <td class={{ $result['agg_score'] >= 140 && $result['agg_score'] <= 179 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">
                                Fairly expressive,
                                usually appropriate but
                                with noticeable
                                inaccuracies</td>
                            <td class={{ $result['agg_score'] >= 140 && $result['agg_score'] <= 179 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">
                                Able to understand
                                but with some
                                misinterpretation
                            </td>
                            <td class={{ $result['agg_score'] >= 140 && $result['agg_score'] <= 179 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">
                                Able to function but
                                with some effort</td>
                        </tr>
                        <tr>
                            <td class={{ $result['agg_score'] >= 100 && $result['agg_score'] <= 139 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">100 –
                                139</td>
                            <td class={{ $result['agg_score'] >= 100 && $result['agg_score'] <= 139 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">2</td>
                            <td class={{ $result['agg_score'] >= 100 && $result['agg_score'] <= 139 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">
                                Limited user
                            </td>
                            <td class={{ $result['agg_score'] >= 100 && $result['agg_score'] <= 139 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">
                                Limited command
                                of the language</td>
                            <td class={{ $result['agg_score'] >= 100 && $result['agg_score'] <= 139 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">
                                Lacks expressiveness
                                and appropriacy;
                                inaccurate use of the
                                language resulting in
                                frequent breakdowns
                                in communication</td>
                            <td class={{ $result['agg_score'] >= 100 && $result['agg_score'] <= 139 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">
                                Limited
                                understanding of the
                                language
                            </td>
                            <td class={{ $result['agg_score'] >= 100 && $result['agg_score'] <= 139 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">
                                Limited ability to
                                function in the
                                language</td>
                        </tr>
                        <tr>
                            <td class={{ $result['agg_score'] >= 1 && $result['agg_score'] <= 100 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">Below
                                100</td>
                            <td class={{ $result['agg_score'] >= 1 && $result['agg_score'] <= 100 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">1</td>
                            <td class={{ $result['agg_score'] >= 1 && $result['agg_score'] <= 100 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">
                                Extremely
                                limited user
                            </td>
                            <td class={{ $result['agg_score'] >= 1 && $result['agg_score'] <= 100 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">
                                Poor command of
                                the language</td>
                            <td class={{ $result['agg_score'] >= 1 && $result['agg_score'] <= 100 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">
                                Inexpressive and
                                inaccurate use of the
                                language resulting in
                                very frequent
                                breakdowns in
                                communication</td>
                            <td class={{ $result['agg_score'] >= 1 && $result['agg_score'] <= 100 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">
                                Poor understanding
                                of the language

                            </td>
                            <td class={{ $result['agg_score'] >= 1 && $result['agg_score'] <= 100 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">
                                Hardly able to
                                function in the
                                language</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @elseif ($result['year'] > 2008 && $result['year'] < 2021)
        <div id="back-tahun-2020">
            <div id="table-title">
                <table
                    style="text-align: center; width: 105%; margin-left: -15px; margin-right: -15px; border-collapse: collapse">
                    <tr>
                        <th
                            style="background-color: rgb(235, 180, 0);border: 1px solid black; text-align: center;padding: 10px">
                            MUET BAND DESCRIPTION</th>
                    </tr>
                </table>
            </div>

            <div id="table-content">
                <table
                    style="width: 105%; margin-left: -15px; margin-right: -15px; border-collapse: collapse;padding-top: 30px">
                    <thead>
                        <tr>
                            <th
                                style="background-color: #9a9a9a;color: white;text-align: center; border: 1px solid black; font-size: 10pt;padding: 10px">
                                AGGREGATED SCORE </th>
                            <th
                                style="background-color: #9a9a9a;color: white;text-align: center; border: 1px solid black; font-size: 10pt;padding: 10px">
                                BAND </th>
                            <th
                                style="background-color: #9a9a9a;color: white;text-align: center; border: 1px solid black; font-size: 10pt;padding: 10px">
                                USER </th>
                            <th
                                style="background-color: #9a9a9a;color: white;text-align: center; border: 1px solid black; font-size: 10pt;padding: 10px">
                                COMMUNICATIVE ABILITY </th>
                            <th
                                style="background-color: #9a9a9a;color: white;text-align: center; border: 1px solid black; font-size: 10pt;padding: 10px">
                                COMPREHENSION </th>
                            <th
                                style="background-color: #9a9a9a;color: white;text-align: center; border: 1px solid black; font-size: 10pt;padding: 10px">
                                TASK PERFORMANCE </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class={{ $result['agg_score'] >= 260 && $result['agg_score'] <= 300 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">260 – 300
                            </td>
                            <td class={{ $result['agg_score'] >= 260 && $result['agg_score'] <= 300 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">6</td>
                            <td class={{ $result['agg_score'] >= 260 && $result['agg_score'] <= 300 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">Highly
                                proficient
                                user</td>
                            <td class={{ $result['agg_score'] >= 260 && $result['agg_score'] <= 300 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">Very fluent;
                                highly
                                appropriate use of
                                language; hardly any
                                grammatical error</td>
                            <td class={{ $result['agg_score'] >= 260 && $result['agg_score'] <= 300 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">Very fluent;
                                highly
                                appropriate use of
                                language; hardly any
                                grammatical error
                            </td>
                            <td class={{ $result['agg_score'] >= 260 && $result['agg_score'] <= 300 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">Very high ability
                                to
                                function in the
                                language</td>
                        </tr>
                        <tr>
                            <td class={{ $result['agg_score'] >= 220 && $result['agg_score'] <= 259 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">220 – 259
                            </td>
                            <td class={{ $result['agg_score'] >= 220 && $result['agg_score'] <= 259 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">5</td>
                            <td class={{ $result['agg_score'] >= 220 && $result['agg_score'] <= 259 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">Proficient
                                user
                            </td>
                            <td class={{ $result['agg_score'] >= 220 && $result['agg_score'] <= 259 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">
                                Fluent; appropriate use of
                                language; few
                                grammatical errors</td>
                            <td class={{ $result['agg_score'] >= 220 && $result['agg_score'] <= 259 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">Good understanding
                                of
                                language and context
                            </td>
                            <td class={{ $result['agg_score'] >= 220 && $result['agg_score'] <= 259 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">
                                High ability to
                                function in the
                                language</td>
                        </tr>
                        <tr>
                            <td class={{ $result['agg_score'] >= 180 && $result['agg_score'] <= 219 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">180 –
                                219</td>
                            <td class={{ $result['agg_score'] >= 180 && $result['agg_score'] <= 219 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">4</td>
                            <td class={{ $result['agg_score'] >= 180 && $result['agg_score'] <= 219 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">
                                Satisfactory
                                user
                            </td>
                            <td class={{ $result['agg_score'] >= 180 && $result['agg_score'] <= 219 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">
                                Generally fluent; generally
                                appropriate use of
                                language; some
                                grammatical errors</td>
                            <td class={{ $result['agg_score'] >= 180 && $result['agg_score'] <= 219 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">
                                Satisfactory
                                understanding of
                                language and context
                            </td>
                            <td class={{ $result['agg_score'] >= 180 && $result['agg_score'] <= 219 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">
                                Satisfactory ability to
                                function in the
                                language</td>
                        </tr>
                        <tr>
                            <td class={{ $result['agg_score'] >= 140 && $result['agg_score'] <= 179 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">140 –
                                179</td>
                            <td class={{ $result['agg_score'] >= 140 && $result['agg_score'] <= 179 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">3</td>
                            <td class={{ $result['agg_score'] >= 140 && $result['agg_score'] <= 179 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">
                                Modest user
                            </td>
                            <td class={{ $result['agg_score'] >= 140 && $result['agg_score'] <= 179 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">
                                Fairly fluent; fairly
                                appropriate use of
                                language; many
                                grammatical errors
                            </td>
                            <td class={{ $result['agg_score'] >= 140 && $result['agg_score'] <= 179 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">
                                Fair understanding of language and context
                            </td>
                            <td class={{ $result['agg_score'] >= 140 && $result['agg_score'] <= 179 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">
                                Fair ability to function the language
                            </td>
                        </tr>
                        <tr>
                            <td class={{ $result['agg_score'] >= 100 && $result['agg_score'] <= 139 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">100 –
                                139</td>
                            <td class={{ $result['agg_score'] >= 100 && $result['agg_score'] <= 139 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">2</td>
                            <td class={{ $result['agg_score'] >= 100 && $result['agg_score'] <= 139 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">
                                Limited user
                            </td>
                            <td class={{ $result['agg_score'] >= 100 && $result['agg_score'] <= 139 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">
                                Not fluent; inappropriate use of language; very frequent grammatical
                                errors
                            </td>
                            <td class={{ $result['agg_score'] >= 100 && $result['agg_score'] <= 139 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">
                                Limited understanding of language and contex
                            </td>
                            <td class={{ $result['agg_score'] >= 100 && $result['agg_score'] <= 139 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">
                                Limited ability to function in the
                                language
                            </td>
                        </tr>
                        <tr>
                            <td class={{ $result['agg_score'] >= 1 && $result['agg_score'] <= 100 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">Below
                                100</td>
                            <td class={{ $result['agg_score'] >= 1 && $result['agg_score'] <= 100 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">1</td>
                            <td class={{ $result['agg_score'] >= 1 && $result['agg_score'] <= 100 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">
                                Very limited user
                            </td>
                            <td class={{ $result['agg_score'] >= 1 && $result['agg_score'] <= 100 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">
                                Hardly able to use the language
                            </td>
                            <td class={{ $result['agg_score'] >= 1 && $result['agg_score'] <= 100 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">
                                Very limited understanding of language and context
                            </td>
                            <td class={{ $result['agg_score'] >= 1 && $result['agg_score'] <= 100 ? 'highlight' : 'border' }}
                                style="text-align: center; border: 1px solid black; font-size: 10pt">
                                Very limited ability to function in the language
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div id="back-tahun-2021" style="padding-left: 7%;padding-right: 7%">
            <div id="table-title">
                <table
                    style="text-align: center; width: 100%; margin-left: -15px; margin-right: -15px; border-collapse: collapse">
                    <tr>
                        <th
                            style="background-color: rgb(235, 180, 0);border: 1px solid black; text-align: center;padding: 7px; font-size: 10pt">
                            MUET AND CEFR ALIGNMENT GLOBAL DESCRIPTIONS</th>
                    </tr>
                </table>
            </div>

            <div id="table-content" style="padding-top: 5px">
                <div id="proficient-user">
                    <table
                        style="text-align: center; width: 100%; margin-left: -15px; margin-right: -15px; border-collapse: collapse">
                        <tr>
                            <th style="text-align: center;padding: 10px;color: rgb(0, 110, 255); font-size: 10pt">
                                PROFICIENT USER</th>
                        </tr>
                    </table>
                    <table style="width: 100%; margin-left: -15px; margin-right: -15px; border-collapse: collapse">
                        <tr>
                            <th style="border: 1px solid black; text-align: center;padding: 5px;font-size: 10pt">
                                Aggregated Score</th>
                            <th style="border: 1px solid black; text-align: center;padding: 5px;font-size: 10pt">BAND
                            </th>
                            <th style="border: 1px solid black; text-align: center;padding: 5px;font-size: 10pt">CEFR
                                Level</th>
                        </tr>
                        <tr>
                            <td style="border: 1px solid black; text-align: center;padding: 5px;font-size: 10pt"
                                class={{ $result['agg_score'] >= 331 && $result['agg_score'] <= 360 ? 'highlight' : 'border' }}>
                                331 - 360</td>
                            <td style="border: 1px solid black; text-align: center;padding: 5px;font-size: 10pt"
                                class={{ $result['agg_score'] >= 331 && $result['agg_score'] <= 360 ? 'highlight' : 'border' }}>
                                5+</td>
                            <td style="border: 1px solid black; text-align: center;padding: 5px;font-size: 10pt"
                                class={{ $result['agg_score'] >= 331 && $result['agg_score'] <= 360 ? 'highlight' : 'border' }}>
                                C1+</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid black; text-align: center;padding: 5px;font-size: 10pt"
                                class={{ $result['agg_score'] >= 294 && $result['agg_score'] <= 330 ? 'highlight' : 'border' }}>
                                294 - 330</td>
                            <td style="border: 1px solid black; text-align: center;padding: 5px;font-size: 10pt"
                                class={{ $result['agg_score'] >= 294 && $result['agg_score'] <= 330 ? 'highlight' : 'border' }}>
                                5.0</td>
                            <td style="border: 1px solid black; text-align: center;padding: 5px;font-size: 10pt"
                                class={{ $result['agg_score'] >= 294 && $result['agg_score'] <= 330 ? 'highlight' : 'border' }}>
                                C1</td>
                        </tr>
                        <tr>
                            <th colspan="3" style="border: 1px solid black;font-size: 10pt">Descriptions</th>
                        </tr>
                        <tr>
                            <td colspan="3" style="border: 1px solid black;font-size: 9pt">
                                Can understand a wide range of demanding, longer texts, and recognise implicit meaning.
                                Can
                                express him/herself fluently and spontaneously without much obvious searching for
                                expressions. Can
                                use language flexibly and effectively for social, academic and professional purposes.
                                Can produce
                                clear, well-structured, detailed text on complex subjects, showing controlled use of
                                organisational
                                patterns, connectors and cohesive devices.
                            </td>
                        </tr>
                    </table>
                </div>

                <div id="independent-user" style="padding-top: 10px">
                    <table
                        style="text-align: center; width: 100%; margin-left: -15px; margin-right: -15px; border-collapse: collapse">
                        <tr>
                            <th style="text-align: center;padding: 10px;color: rgb(0, 110, 255); font-size: 10pt">
                                INDEPENDENT USER</th>
                        </tr>
                    </table>
                    <table style="width: 100%; margin-left: -15px; margin-right: -15px; border-collapse: collapse">
                        <tr>
                            <th style="border: 1px solid black; text-align: center;padding: 5px;font-size: 10pt">
                                Aggregated Score</th>
                            <th style="border: 1px solid black; text-align: center;padding: 5px;font-size: 10pt">BAND
                            </th>
                            <th style="border: 1px solid black; text-align: center;padding: 5px;font-size: 10pt">CEFR
                                Level</th>
                        </tr>
                        <tr>
                            <td style="border: 1px solid black; text-align: center;padding: 5px;font-size: 10pt"
                                class={{ $result['agg_score'] >= 258 && $result['agg_score'] <= 293 ? 'highlight' : 'border' }}>
                                258 - 293</td>
                            <td style="border: 1px solid black; text-align: center;padding: 5px;font-size: 10pt"
                                class={{ $result['agg_score'] >= 258 && $result['agg_score'] <= 293 ? 'highlight' : 'border' }}>
                                4.5</td>
                            <td style="border: 1px solid black; text-align: center;padding: 5px;font-size: 10pt"
                                class={{ $result['agg_score'] >= 258 && $result['agg_score'] <= 293 ? 'highlight' : 'border' }}>
                                B2</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid black; text-align: center;padding: 5px;font-size: 10pt"
                                class={{ $result['agg_score'] >= 211 && $result['agg_score'] <= 257 ? 'highlight' : 'border' }}>
                                211 - 257</td>
                            <td style="border: 1px solid black; text-align: center;padding: 5px;font-size: 10pt"
                                class={{ $result['agg_score'] >= 211 && $result['agg_score'] <= 257 ? 'highlight' : 'border' }}>
                                4.0</td>
                            <td style="border: 1px solid black; text-align: center;padding: 5px;font-size: 10pt"
                                class={{ $result['agg_score'] >= 211 && $result['agg_score'] <= 257 ? 'highlight' : 'border' }}>
                                B2</td>
                        </tr>
                        <tr>
                            <th colspan="3" style="border: 1px solid black;font-size: 10pt">Descriptions</th>
                        </tr>
                        <tr>
                            <td colspan="3" style="border: 1px solid black;font-size: 9pt">
                                Can understand the main ideas of complex text on both concrete and abstract topics,
                                including
                                technical discussions in his/her field of specialisation. Can interact with a degree of
                                fluency and
                                spontaneity that makes regular interaction with native speakers quite possible without
                                strain for either
                                party. Can produce clear, detailed text on a wide range of subjects and explain a
                                viewpoint on a
                                topical issue giving the advantages and disadvantages of various options.
                            </td>
                        </tr>
                    </table>
                </div>

                <div id="independent-user-2" style="padding-top: 10px">
                    <table
                        style="text-align: center; width: 100%; margin-left: -15px; margin-right: -15px; border-collapse: collapse">
                        <tr>
                            <th style="text-align: center;padding: 10px;color: rgb(0, 110, 255); font-size: 10pt">
                                INDEPENDENT USER</th>
                        </tr>
                    </table>
                    <table style="width: 100%; margin-left: -15px; margin-right: -15px; border-collapse: collapse">
                        <tr>
                            <th style="border: 1px solid black; text-align: center;padding: 5px;font-size: 10pt">
                                Aggregated Score</th>
                            <th style="border: 1px solid black; text-align: center;padding: 5px;font-size: 10pt">BAND
                            </th>
                            <th style="border: 1px solid black; text-align: center;padding: 5px;font-size: 10pt">CEFR
                                Level</th>
                        </tr>
                        <tr>
                            <td style="border: 1px solid black; text-align: center;padding: 5px;font-size: 10pt"
                                class={{ $result['agg_score'] >= 264 && $result['agg_score'] <= 210 ? 'highlight' : 'border' }}>
                                264 - 210</td>
                            <td style="border: 1px solid black; text-align: center;padding: 5px;font-size: 10pt"
                                class={{ $result['agg_score'] >= 264 && $result['agg_score'] <= 210 ? 'highlight' : 'border' }}>
                                3.5</td>
                            <td style="border: 1px solid black; text-align: center;padding: 5px;font-size: 10pt"
                                class={{ $result['agg_score'] >= 264 && $result['agg_score'] <= 210 ? 'highlight' : 'border' }}>
                                B1</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid black; text-align: center;padding: 5px;font-size: 10pt"
                                class={{ $result['agg_score'] >= 123 && $result['agg_score'] <= 163 ? 'highlight' : 'border' }}>
                                123 - 163</td>
                            <td style="border: 1px solid black; text-align: center;padding: 5px;font-size: 10pt"
                                class={{ $result['agg_score'] >= 123 && $result['agg_score'] <= 163 ? 'highlight' : 'border' }}>
                                3.0</td>
                            <td style="border: 1px solid black; text-align: center;padding: 5px;font-size: 10pt"
                                class={{ $result['agg_score'] >= 123 && $result['agg_score'] <= 163 ? 'highlight' : 'border' }}>
                                B1</td>
                        </tr>
                        <tr>
                            <th colspan="3" style="border: 1px solid black;font-size: 10pt">Descriptions</th>
                        </tr>
                        <tr>
                            <td colspan="3" style="border: 1px solid black;font-size: 9pt">
                                Can understand the main points of clear standard input on familiar matters regularly
                                encountered in
                                work, school, leisure, etc. Can deal with most situations likely to arise whilst
                                travelling in an area
                                where the language is spoken. Can produce simple connected text on topics which are
                                familiar, or
                                of personal interest. Can describe experiences and events, dreams, hopes and ambitions
                                and briefly
                                give reasons and explanations for opinions and plans.
                            </td>
                        </tr>
                    </table>
                </div>

                <div id="independent-user-2" style="padding-top: 10px">
                    <table
                        style="text-align: center; width: 100%; margin-left: -15px; margin-right: -15px; border-collapse: collapse">
                        <tr>
                            <th style="text-align: center;padding: 10px;color: rgb(0, 110, 255); font-size: 10pt">
                                BASIC USER</th>
                        </tr>
                    </table>
                    <table style="width: 100%; margin-left: -15px; margin-right: -15px; border-collapse: collapse">
                        <tr>
                            <th style="border: 1px solid black; text-align: center;padding: 5px;font-size: 10pt">
                                Aggregated Score</th>
                            <th style="border: 1px solid black; text-align: center;padding: 5px;font-size: 10pt">BAND
                            </th>
                            <th style="border: 1px solid black; text-align: center;padding: 5px;font-size: 10pt">CEFR
                                Level</th>
                        </tr>
                        <tr>
                            <td style="border: 1px solid black; text-align: center;padding: 5px;font-size: 10pt"
                                class={{ $result['agg_score'] >= 82 && $result['agg_score'] <= 122 ? 'highlight' : 'border' }}>
                                82 - 122</td>
                            <td style="border: 1px solid black; text-align: center;padding: 5px;font-size: 10pt"
                                class={{ $result['agg_score'] >= 82 && $result['agg_score'] <= 122 ? 'highlight' : 'border' }}>
                                2.5</td>
                            <td style="border: 1px solid black; text-align: center;padding: 5px;font-size: 10pt"
                                class={{ $result['agg_score'] >= 82 && $result['agg_score'] <= 122 ? 'highlight' : 'border' }}>
                                A2</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid black; text-align: center;padding: 5px;font-size: 10pt"
                                class={{ $result['agg_score'] >= 36 && $result['agg_score'] <= 81 ? 'highlight' : 'border' }}>
                                36 - 81</td>
                            <td style="border: 1px solid black; text-align: center;padding: 5px;font-size: 10pt"
                                class={{ $result['agg_score'] >= 36 && $result['agg_score'] <= 81 ? 'highlight' : 'border' }}>
                                2.0</td>
                            <td style="border: 1px solid black; text-align: center;padding: 5px;font-size: 10pt"
                                class={{ $result['agg_score'] >= 36 && $result['agg_score'] <= 81 ? 'highlight' : 'border' }}>
                                A2</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid black; text-align: center;padding: 5px;font-size: 10pt"
                                class={{ $result['agg_score'] >= 1 && $result['agg_score'] <= 35 ? 'highlight' : 'border' }}>
                                1 - 35</td>
                            <td style="border: 1px solid black; text-align: center;padding: 5px;font-size: 10pt"
                                class={{ $result['agg_score'] >= 1 && $result['agg_score'] <= 35 ? 'highlight' : 'border' }}>
                                1.0</td>
                            <td style="border: 1px solid black; text-align: center;padding: 5px;font-size: 10pt"
                                class={{ $result['agg_score'] >= 1 && $result['agg_score'] <= 35 ? 'highlight' : 'border' }}>
                                A2</td>
                        </tr>
                        <tr>
                            <th colspan="3" style="border: 1px solid black;font-size: 10pt">Descriptions</th>
                        </tr>
                        <tr>
                            <td colspan="3" style="border: 1px solid black;font-size: 9pt">
                                Can understand sentences and frequently used expressions related to areas of most
                                immediate
                                relevance (e.g. very basic personal and family information, shopping, local geography,
                                employment).
                                Can communicate in simple and routine tasks requiring a simple and direct exchange of
                                information
                                on familiar and routine matters. Can describe in simple terms aspects of his/her
                                background,
                                immediate environment and matters in areas of immediate need.
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    @endif

    <div class="footer" style="padding-top: 10px;text-align: center; font-size: 10pt">
        The QR code will redirect you to MPM MUET Online
        Certificate System. Make sure that it redirects you to
        <a href="https://sijil.mpm.edu.my" target="_blank">sijil.mpm.edu.my</a> for authenticity <span class="pagenum"></span>
    </div>

</body>

</html>
