<?php
$cambio = [
    "dollaro" => 1.08,
    "yen" => 142.50,
    "franchi" => 0.92,
    "sterline" => 0.86
];

$importo = isset($_GET['importo']) ? floatval($_GET['importo']) : 0;
$valuta = isset($_GET['valuta']) ? $_GET['valuta'] : 'dollaro';

$giornoDellaSettimana = date("w"); // 0 per domenica, 1 per lunedì, ecc.
$giorno = date("d-m-Y");
$giornoItaliano = ["Domenica", "Lunedì", "Martedì", "Mercoledì", "Giovedì", "Venerdì", "Sabato"];
$commissione = 0;
$commissioneMaggiore = false;

if ($giornoDellaSettimana == 0 || $giornoDellaSettimana == 6) { // Sabato o Domenica
    $commissione = 0.05;
    $commissioneMaggiore = true;
} else { // Lunedì - Venerdì
    $commissione = 0.025;
}

$importoConCommissione = $importo * (1 + $commissione);
$importoInValuta = $importoConCommissione * $cambio[$valuta];
$importoNetto = $importo * $cambio[$valuta];

?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Risultato Cambio</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            text-align: center;
            padding: 50px;
        }
        h1 {
            color: #333;
        }
        .result-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 350px;
            margin: 0 auto;
        }
        .flag {
            width: 30px;
            height: 20px;
            vertical-align: middle;
            margin-left: 10px;
        }
        a {
            text-decoration: none;
            color: #4CAF50;
        }
    </style>
</head>
<body>
    <h1>Risultato Cambio</h1>
    <div class="result-container">
        <p>Data: <?php echo $giorno . " - " . $giornoItaliano[$giornoDellaSettimana]; ?></p>
        <p>Importo in Euro: €<?php echo number_format($importo, 2); ?> <img src="https://www.worldometers.info/img/flags/it-flag.gif" alt="Bandiera Italia" class="flag"></p>
        <p>Importo in <?php echo ucfirst($valuta); ?> (al netto commissioni): <?php echo number_format($importoNetto, 2); ?> <img src="https://www.worldometers.info/img/flags/<?php echo ($valuta == 'dollaro' ? 'us' : ($valuta == 'yen' ? 'jp' : ($valuta == 'franchi' ? 'ch' : 'gb'))); ?>-flag.gif" alt="Bandiera <?php echo ucfirst($valuta); ?>" class="flag"></p>
        
        <?php if ($commissioneMaggiore): ?>
            <p>Commissione di cambio (5%): €<?php echo number_format($importo * 0.05, 2); ?></p>
        <?php else: ?>
            <p>Commissione di cambio (2.5%): €<?php echo number_format($importo * 0.025, 2); ?></p>
        <?php endif; ?>
        
        <p>Importo dopo commissione: <?php echo number_format($importoInValuta, 2); ?> <?php echo strtoupper($valuta[0] . substr($valuta, 1)); ?> <img src="https://www.worldometers.info/img/flags/<?php echo ($valuta == 'dollaro' ? 'us' : ($valuta == 'yen' ? 'jp' : ($valuta == 'franchi' ? 'ch' : 'gb'))); ?>-flag.gif" alt="Bandiera <?php echo ucfirst($valuta); ?>" class="flag"></p>
        
        <a href="valuta.html">Torna alla pagina principale</a>
    </div>
</body>
</html>
