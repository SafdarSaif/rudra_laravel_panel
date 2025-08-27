<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>🎓 Welcome to Rudra ACK Solutions</title>
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
                                            <p>🎓 <strong>Welcome to Rudra ACK Solutions!</strong></p>
                                        </div>

                                        <div style="color:#444;margin-top:15px;">
                                            <p>Congratulations and welcome to <strong>Rudra ACK Solutions</strong>!
                                            We’re delighted to have you join our learning community and take the first step toward a brighter future.</p>

                                            <p>Your registration has been <strong>successfully processed</strong>, and we’re excited to support you every step of the way.</p>

                                            <p>📌 <strong>Course Enrolled:</strong> {{ $student->course_name }}</p>

                                            <p>Please find your <strong>Fee Receipt</strong> attached with this email for your reference and records.</p>

                                            <p>We’re thrilled to be part of your academic journey. Let’s make it count!</p>

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
