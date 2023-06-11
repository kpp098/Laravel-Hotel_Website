<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Otp Verification</title>
</head>

<body style="font-size:17px; text-align:center;">

    Hi <b>{{ Session::get('name') }} !</b><br>
    {{-- Hi <b>Kashyap!</b><br> --}}

    Your verification code is <br><br>
    <tr>
        <td align="left" bgcolor="#ffffff">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td align="left" bgcolor="#ffffff" style="padding: 12px;text-align:-webkit-center;">
                        <table border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td align="center" bgcolor="#1a82e2" style="border-radius: 6px;">
                                    <a
                                        style="display: inline-block; padding: 16px 36px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 25px; color: #ffffff; text-decoration: none; border-radius: 6px;">
                                        {{ Cache::get('otp') }}
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr><br>
    Enter this code in our Website to activate your account.<br><br>


    If you have any questions,<br> send us an email hotel.century01@gmail.com.<br>
    We will Contact You Soon.<br>

    We’re glad you’re here!<br>
    The Hotel_Century team


    </p>
</body>

</html>
