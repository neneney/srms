<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
        }

        .certificate-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 10px;
            position: relative;
            height: 400px;
            font-size: medium;
            display: none;
        }

        .certificate-header {
            display: grid;
            grid-template-columns: 1fr 2fr 1fr;
            align-items: center;
            column-gap: 0;
            position: relative;
            margin-bottom: 10px;
        }

        .certificate-header img {
            height: 100px;
            right: 0;
        }

        h3 {
            text-align: center;
        }

        .header p {
            text-align: center;
        }

        .header-content {
            display: grid;
            place-items: center;
        }

        .letter-content {
            margin-top: 60px;
        }

        .letter-content p {
            text-align: justify;
            text-indent: 2rem;
            margin-top: 10px;
            margin-bottom: 7px;
        }

        .signature-container {
            position: absolute;
            bottom: 0;
            right: 0;
            text-align: center;
        }

        @media print {
            .certificate-container {
                visibility: visible;
            }
        }
    </style>
</head>

<body>
    <div class="ce.certificate-container">
        <div class="certificate-header">
            <img class="logo" src="company/bjmp_logo.png" alt="">
            <div class=header-content>
                <p>Republic of the Philippines </p>
                <h3>Bureau of Jail Management and Penology</h3>
                <p>Region IXA - Calabarzon</p>
                <p>General Trias, Cavite</p>
            </div>
            <img class="logo" src="company/als_logo.png">
        </div>
        <hr>
        <div class="letter-content">
            <h4>TO WHOM IT MAY CONCERN:</h4>
            <p> This is to certify that <span>[Full Name]</span> is presently enrolled in this institution as< <strong>Alternative Learning System(ALS)</strong> Student from the <span>[PROGRAM ENROLLED]</span> this <span>[current year]</span></p>
            <p>Issued this 26th day of february 2019 at Bureau of Jail Management and Penology - General Trias Cavite</p>
        </div>
        <div class="signature-container">
            <p>[Representative Name]</p>
            <p>[Position]</p>
        </div>
    </div>
</body>

</html>