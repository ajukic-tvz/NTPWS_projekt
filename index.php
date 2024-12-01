<?php
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(E_ALL);
?>

<!DOCTYPE HTML>
<html>
	<head>
        <title>Prognoza</title>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="author" content="Antonio jukić">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            body{
                background-color: white;
                margin: 0;
                padding: 0;
                font-family: monospace, "Monaco";
            }

            header {
                text-align: center;
                background-color: azure;
                padding-bottom: 10px;
                border-bottom: 1px solid teal;
            }

            .containerH{
                max-width: 900px;
                margin: 0 auto;
            }

            .containerM{
                max-width: 900px;
                margin: 0 auto;
                background-color: azure;
            }

            header h1{
                color: teal;
                font-weight: normal;
                padding: 10px 0px;
                margin: 0;
            }

            nav {
                display: flex;
                justify-content: center;
                gap: 10px;
            }

            nav a {
                text-decoration: none;
                color: white;
                padding-top: 3px;
                background-color: teal;
                
                display: block;
                text-align: center;
                width: 150px;
                height: 25px;
                border-radius: 5px;
            }

            nav a:hover{
                background-color:cadetblue;
            }

            nav a:visited{
                color: white;
            }

            main h1{
                font-weight: normal;
                margin: 0px;
                color:teal;
            }

            section{
                padding: 10px;
                background-color: azure;
            }

            main section{
                text-align: center;
            }

            main section table {
                margin: 0 auto;
                text-align: center;
                width: 600px;
            }

            main section table thead tr{
                color: white;
                font-weight: normal;
                background-color: teal;
            }

            main section table tbody tr:hover {
                background-color: cadetblue;
            }

            main section th, td {
                border: 1px solid cadetblue;
                padding: 7px;
            }

            footer{
                background-color: teal;
            }

            .containerF{
                max-width: 900px;
                margin: 0 auto;

            }

            footer {
                color: white;
                text-align: center;
                margin: 0;
                padding: 10px;
            }

            footer a {
                color: white;
            }

        </style>
</head>
<body>
    <header>
        <div class="containerH">
            <h1 style="text-align: center; ">Prognoza</h1>
            <nav>
                <a href="index.php">Početna</a>
                <a href="admin.php">Admin Login</a>
            </nav>
        </div>
    </header>

    <main>
        <div class="containerM">
            <section>
                <h1>Trenutna prognoza po gradovima koristeći API:</h1>
                <table>
                    <thead>
                        <tr>
                            <th>Grad</th>
                            <th>Temperatura (°C)</th>
                            <th>Vlaga (%)</th>
                            <th>Tlak (hPa)</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php
                        $gradovi = ["Zagreb","London", "Sarajevo", "Paris", "New York", "Berlin", "Tokyo"];
                        $api_key  = "07eea2d96db5adc733dc08f64939e4e7";

                        foreach ($gradovi as $grad) {
                            $api_call = "http://api.openweathermap.org/data/2.5/weather?q=" . $grad . "&units=metric&appid=" . $api_key;

                            $weather_data = json_decode(file_get_contents($api_call), true);

                            if (isset($weather_data['main'])) {
                                $temp = $weather_data['main']['temp'];
                                $hum = $weather_data['main']['humidity'];
                                $pre = $weather_data['main']['pressure'];

                                echo '
                                    <tr>
                                        <td>' . $grad . '</td>
                                        <td>' . $temp . '</td>
                                        <td>' . $hum . '</td>
                                        <td>' . $pre . '</td>
                                    </tr>
                                ';
                            } else {
                                echo '
                                    <tr>
                                        <td>' . $grad . '</td>
                                        <td colspan="3">Podaci nisu dostupni</td>
                                    </tr>
                                ';
                            }
                        }
                    ?>
                    </tbody>
                </table>
            </section>

            
        </div>
    </main>
    <footer>
        <div class="containerF">
            <div class="sadrzaj">
                © Antonio Jukić
                <a href="https://github.com/ajukic-tvz/NTPWS_projekt" target="_blank">Github</a>
                &amp; Prognoza. All rights reserved.
            </div>
        </div>
    </footer>

</body>

</html>

