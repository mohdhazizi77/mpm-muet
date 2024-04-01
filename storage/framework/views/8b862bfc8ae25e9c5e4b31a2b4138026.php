<?php use SimpleSoftwareIO\QrCode\Facades\QrCode; ?>
    <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>download pdf</title>
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
        padding-top: 5px;
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
        padding-top: 130px;
        line-height: 0.8;
    }

    #qr {
        padding-top: 50px;
    }

</style>
<body>


<div id="page-1">
    <div id="session">
        <p style="font-weight: bold; font-size: 22px; margin-bottom: 0.1em;">SESSION MAY 2023</p>
        <p style="font-size: 17px">and obtained the following score</p>
    </div>
    <div id="student-details">
        <table style="width: 105%; margin-left: -15px; margin-right: -15px;">
            <tr>
                <td>ALI BIN ABU</td>
            </tr>
            <tr>
                <td style="text-align: left">900101121357</td>
                <td style="text-align: right">MA2011/0201</td>
            </tr>
        </table>
    </div>
    <div id="score">
        <table style="text-align: center; width: 105%; margin-left: -15px; margin-right: -15px; border-collapse: collapse">
            <tr style="background-color: lightgrey;">
                <td style="border: 1px solid black;">Test Component</td>
                <td style="border: 1px solid black;">Maximum Score</td>
                <td width="33%" style="border: 1px solid black;">Obtained Score</td>
            </tr>
            <tr>
                <td style="border: 1px solid black; border-top: 0; border-bottom: 0">LISTENING</td>
                <td style="border: 1px solid black; border-top: 0; border-bottom: 0">90</td>
                <td width="33%" style="border: 1px solid black; border-top: 0; border-bottom: 0">45</td>
            </tr>
            <tr>
                <td style="border: 1px solid black; border-top: 0; border-bottom: 0">SPEAKING</td>
                <td style="border: 1px solid black; border-top: 0; border-bottom: 0">90</td>
                <td width="33%" style="border: 1px solid black; border-top: 0; border-bottom: 0">41</td>
            </tr>
            <tr>
                <td style="border: 1px solid black; border-top: 0; border-bottom: 0">READING</td>
                <td style="border: 1px solid black; border-top: 0; border-bottom: 0">90</td>
                <td width="33%" style="border: 1px solid black; border-top: 0; border-bottom: 0">65</td>
            </tr>
            <tr>
                <td style="border: 1px solid black; border-top: 0; border-bottom: 0">WRITING</td>
                <td style="border: 1px solid black; border-top: 0; border-bottom: 0">90</td>
                <td width="33%" style="border: 1px solid black; border-top: 0; border-bottom: 0">30</td>
            </tr>
            <tr>
                <th style="border: 1px solid black;">AGGREGATED SCORE</th>
                <th style="border: 1px solid black;">360</th>
                <th width="33%" style="border: 1px solid black;">181</th>
            </tr>
        </table>
    </div>

    <div id="band">
        <table style="text-align: center; width: 105%; margin-left: -15px; margin-right: -15px; border-collapse: collapse">
            <tr>
                <td></td>
                <th style="text-align: right; padding-right: 5px">BAND ACHIEVED</th>
                <th width="33%" style="border: 1px solid black; background-color: lightgrey">3.5</th>
            </tr>
        </table>
    </div>

    <div id="signature">
        <table style="width: 105%; margin-left: -15px; margin-right: -15px">
            <tr>
                <td>SIGNATURE</td>
                <td>SIGNATURE</td>
            </tr>
            <tr>
                <td style="font-weight: bold">PROF. DATO' GS. TS. DR. MOHD EKHWAN HJ. TORIMAN</td>
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
                <td style="font-size: 14px; padding-top: 37px">Date of issue: 26 May 2023</td>
            </tr>
            <tr>
                <td></td>
                <td style="font-size: 14px; font-weight: bold">Date of expiry: 25 May 2028</td>
            </tr>
        </table>
    </div>
    <div id="qr">

        <table style="width: 105%; margin-left: -15px; margin-right: -15px">
            <tr>
                <td style="text-align: right"><img src="data:image/jpg;base64,<?php echo e(base64_encode($qr)); ?>" alt="QR Code"></td>
            </tr>
        </table>

    </div>
</div>




















</body>
</html>
<?php /**PATH C:\Users\hazizi-3TDS\Desktop\CODE\mpm-muet\resources\views/candidates/download-pdf.blade.php ENDPATH**/ ?>