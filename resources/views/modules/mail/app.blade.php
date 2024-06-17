<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    <title>MUET</title>
    <style>
        @media only screen and (max-width: 600px) {
            .inner-body {
                width: 100% !important;
            }

            .footer {
                width: 100% !important;
            }
        }

        body {
            /* width: 650px; */
            font-family: 'Lato', sans-serif !important;
            background-color: #f6f7fb;
            display: block;
            text-align: center;
        }

        .btn {
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
            position: relative;
            -webkit-text-size-adjust: none;
            border-radius: 4px;
            color: #fff;
            display: inline-block;
            overflow: hidden;
            font-family: poppins;
            text-decoration: none;
            background-color: #2d3748;
            border-bottom: 8px solid #2d3748;
            border-left: 18px solid #2d3748;
            border-right: 18px solid #2d3748;
            border-top: 8px solid #2d3748;
        }

    </style>
</head>

<body style="background-color: #EDF2F7; text-align: -webkit-center;">
<table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
        <td align="center">
            <table class="content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                {{-- {{ $header ?? '' }} --}}

                <!-- Email Body -->
                <tr>
                    <td class="body" width="100%" cellpadding="0" cellspacing="0">
                        <table class="inner-body" align="center" width="650" cellpadding="0" cellspacing="0"
                               role="presentation" style="background-color: white; padding: 20px;">
                            <!-- Body content -->
                            <tr>
                                <td class="content-cell" style="padding-top: 5px;">
                                    @yield('content')

                                    <div
                                        style="font-style: italic; font-size: 14px; font-weight: 700; color: black; margin-bottom:30px;padding-top: 10px">
                                        MUET
                                    </div>

                                    <div
                                        style="text-align: center; font-size: 12px; font-weight: 700; color: black; margin: 0px; font-style: italic;">
                                        @lang("Cetakan Komputer")
                                    </div>

                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                {{ $footer ?? '' }}
            </table>
        </td>
    </tr>
</table>
</body>

</html>
