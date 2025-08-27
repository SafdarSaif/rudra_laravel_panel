<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Fee Paid - Rudra ACK Solutions</title>
    <style>
        .mailicon a{
            color:white !important;
            text-decoration:none !important;
        }
    </style>
</head>
<body>
    <table style="background:#f0f0f0;border-collapse:collapse;font-family:Arial,Helvetica,sans-serif;font-size:16px;line-height:1.6;width:100%;min-width:700px;" width="100%">
        <tr>
            <td style="padding:10px">
                <table style="margin:0 auto;width:700px;" width="700" align="center">

                    <!-- Header -->
                    <tr>
                        <td style="padding:0 21px">
                            <table style="background:#ffffff;width:658px;margin:0 auto;" width="658" align="center">
                                <tr>
                                    {{-- <td style="border-bottom:3px solid #16345c;padding:20px;text-align:center">
                                        <img src="{{ url('assets/web-assets/rudra_logo.png') }}" width="200" alt="Rudra ACK Solutions Logo" />
                                    </td> --}}
                                </tr>

                                <!-- Body -->
                                <tr>
                                    <td style="padding:25px 60px">
                                        <div style="border-bottom:2px dotted #16345c;color:#16345c;padding-bottom:1em;">
                                            <p><strong>Dear {{ $student->name }},</strong></p>
                                            <p>🎉 <strong style="color:green">Congratulations!</strong> Your fee payment has been <strong>Received</strong>.</p>
                                        </div>

                                        <div style="color:#444;margin-top:15px;">
                                            <p>We are pleased to inform you that your payment has been successfully paid.</p>

                                            <p>
                                                📌 <strong>Transaction ID:</strong> {{ $ledger->provided_transaction_id }}<br>
                                                📌 <strong>Amount Received:</strong> ₹{{ $ledger->fee_received }}
                                            </p>

                                            <p> We look forward to supporting your learning journey with Rudra ACK Solutions.</p>

                                            <p style="color:#16345c">
                                                Warm regards,<br>
                                                <strong style="color:black">Team Rudra ACK Solutions</strong>
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#16345c;text-align:center;padding:30px;">
                            <p class="mailicon" style="color:#ffffff; margin:0; font-size:14px;">
                                📧 info@rudraacksolutions.com | 🌐 www.rudraacksolutions.com | 📞 9211417459
                            </p>
                            <p style="color:#ffffff; margin:5px 0 0; font-size:14px;">
                                © {{ date('Y') }} Rudra ACK Solutions. All rights reserved.
                            </p>
                            <p style="color:#ffffff; margin:10px 0 0; font-size:12px;">
                                ⚠️ This is a system-generated email. Please do not reply.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
