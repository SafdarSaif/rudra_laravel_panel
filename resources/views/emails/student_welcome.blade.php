<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Welcome Email</title>
</head>

<body>
    <p>Dear {{ $student->name }},</p>

    <p>Congratulations and welcome to <strong>Rudra ACK Solutions</strong>!</p>
    <p>We’re delighted to have you join our learning community and take the first step toward a brighter future.
        Your admission has been successfully processed, and we’re excited to support you every step of the way.</p>

    <p>📌 <strong>Course Enrolled:</strong> {{ $student->course->name ?? 'N/A' }}</p>

    <p>Please find your <strong>Fee Receipt</strong> attached with this email for your reference and records.</p>

    <br>
    <p>We’re thrilled to be part of your academic journey. Let’s make it count!</p>

    <p>
        Warm regards, <br>
        Team Rudra ACK Solutions <br>
        📧 info@rudraacksolutions.com | 🌐 www.rudraacksolutions.com | 📞 9211417459
    </p>
</body>

</html>