<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Clima e Previsão do tempo</title>
    <style>
    .container{
        margin: 0 auto;
    }
    img{
        width: 100%;
        height: 100%;
        display: block;
    }
    .Cabebcalio{
        width: 100%;
        text-align: center;
        padding-left: 5%;
    }
    .listaItens {
        border-radius: 15px;   
        height: 800px; 
        width: 98%;
        background-color: rgb(16, 102, 141);
        padding: 15px;
        display: flex;
    }
    p{
        font-family: sans-serif;
        font-size: large;
    }
    h1{
        font-size: 40px;
        font-family: sans-serif;
        font-weight: 300;
        color:rgb(16, 102, 141);
    }
    .letras1{
        width: 30%;
    }
    .letras2{
        width: 70%;
    }
    .ParteDia{
        display: flex;
        width: 100%;
    }
    .Description{
        width: 97.5%;
        height: 20%;
        background-color: white;
        margin: 2px;
        border-radius: 10px; 
        padding: 1%;
    }
    .letras1 div{
        margin: 2px;
        border-radius: 5px;   
        background-color: white;
        display: flex;
        justify-content: space-between;
        padding: 3%;
    }
    .ParteDia div{
        width: 25%;
        height: 200px;
        margin: 3px;
        border-radius: 5px;   
        background-color: white;
        padding: 5%;
    }
    .letras1 div:hover{
        background-color: azure;
    }
    .weather-icon{
        height: 45%;
        width: 90%;
    }
    h2{
        font-family: sans-serif;
        font-weight: 300;
    }
    </style>
<?php
date_default_timezone_set('America/Sao_Paulo');
$data_atual = date('Y-m-d');
$url = "http://apiadvisor.climatempo.com.br/api/v1/forecast/locale/5092/days/15?token=42268fe84ba6f0345b79640e3156e5c9";
$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false,
]);
$response = curl_exec($curl);
if ($response === false) {
    echo 'Erro ao conectar à API: ' . curl_error($curl);
    exit;
}
curl_close($curl);
$dados = json_decode($response, true);
if (isset($dados['error'])) {
    echo "<p>Erro na resposta da API: " . $dados['error'] . "</p>";
} else {
    if (isset($dados['data']) && is_array($dados['data']) && count($dados['data']) > 0) {
        $climaAtual = $dados['data'][0]; 
        $temperaturaMax = $climaAtual['temperature']["max"] ?? 'Não disponível';
        $temperaturaMin = $climaAtual['temperature']["min"] ?? 'Não disponível';
        $chuvaPrecipitacao = $climaAtual['rain']['precipitation'] ?? 'Não disponível';
        $chuvaProbabilidade = $climaAtual['rain']['probability'] ?? 'Não disponível';
        $umidadeMax = $climaAtual['humidity']['max'] ?? 'Não disponível';
        $umidadeMin = $climaAtual['humidity']['min'] ?? 'Não disponível';
        $condicao = $climaAtual['condition'][0] ?? 'Não disponível';
        $vento_velocidade = $climaAtual['wind']["velocity_avg"] ?? 'Não disponível';
        $vento_direcao = $climaAtual['wind']['direction'] ?? 'Não disponível';
        $orvalio = $climaAtual['sun']['sunrise'] ?? 'Não disponível';
        $crepusculo = $climaAtual['sun']['sunset'] ?? 'Não disponível';
        $dawn_condicao = $climaAtual['text_icon']['icon']['dawn'] ?? 'Não disponível';
        $morning_condicao = $climaAtual['text_icon']['icon']['morning'] ?? 'Não disponível';
        $afternoon_condicao = $climaAtual['text_icon']['icon']['afternoon'] ?? 'Não disponível';
        $night_condicao = $climaAtual['text_icon']['icon']['night'] ?? 'Não disponível';
        $descricao_condicao = $climaAtual['text_icon']['text']['pt'] ?? 'Não disponível';
        $chuva = $climaAtual['rain']['probability'] ?? 0;
        } else {
        echo "<p>Não foi possível obter as informações de clima.</p>";
    }
    if ($chuva < 50) {
        $icone = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-droplet" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M7.21.8C7.69.295 8 0 8 0q.164.544.371 1.038c.812 1.946 2.073 3.35 3.197 4.6C12.878 7.096 14 8.345 14 10a6 6 0 0 1-12 0C2 6.668 5.58 2.517 7.21.8m.413 1.021A31 31 0 0 0 5.794 3.99c-.726.95-1.436 2.008-1.96 3.07C3.304 8.133 3 9.138 3 10a5 5 0 0 0 10 0c0-1.201-.796-2.157-2.181-3.7l-.03-.032C9.75 5.11 8.5 3.72 7.623 1.82z"/><path fill-rule="evenodd" d="M4.553 7.776c.82-1.641 1.717-2.753 2.093-3.13l.708.708c-.29.29-1.128 1.311-1.907 2.87z"/></svg>';
    } elseif ($chuva < 75) {
        $icone = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-droplet" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M7.21.8C7.69.295 8 0 8 0q.164.544.371 1.038c.812 1.946 2.073 3.35 3.197 4.6C12.878 7.096 14 8.345 14 10a6 6 0 0 1-12 0C2 6.668 5.58 2.517 7.21.8m.413 1.021A31 31 0 0 0 5.794 3.99c-.726.95-1.436 2.008-1.96 3.07C3.304 8.133 3 9.138 3 10a5 5 0 0 0 10 0c0-1.201-.796-2.157-2.181-3.7l-.03-.032C9.75 5.11 8.5 3.72 7.623 1.82z"/><path fill-rule="evenodd" d="M4.553 7.776c.82-1.641 1.717-2.753 2.093-3.13l.708.708c-.29.29-1.128 1.311-1.907 2.87z"/></svg><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-droplet" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M7.21.8C7.69.295 8 0 8 0q.164.544.371 1.038c.812 1.946 2.073 3.35 3.197 4.6C12.878 7.096 14 8.345 14 10a6 6 0 0 1-12 0C2 6.668 5.58 2.517 7.21.8m.413 1.021A31 31 0 0 0 5.794 3.99c-.726.95-1.436 2.008-1.96 3.07C3.304 8.133 3 9.138 3 10a5 5 0 0 0 10 0c0-1.201-.796-2.157-2.181-3.7l-.03-.032C9.75 5.11 8.5 3.72 7.623 1.82z"/><path fill-rule="evenodd" d="M4.553 7.776c.82-1.641 1.717-2.753 2.093-3.13l.708.708c-.29.29-1.128 1.311-1.907 2.87z"/></svg>';
    } else {
        $icone ='<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-droplet" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M7.21.8C7.69.295 8 0 8 0q.164.544.371 1.038c.812 1.946 2.073 3.35 3.197 4.6C12.878 7.096 14 8.345 14 10a6 6 0 0 1-12 0C2 6.668 5.58 2.517 7.21.8m.413 1.021A31 31 0 0 0 5.794 3.99c-.726.95-1.436 2.008-1.96 3.07C3.304 8.133 3 9.138 3 10a5 5 0 0 0 10 0c0-1.201-.796-2.157-2.181-3.7l-.03-.032C9.75 5.11 8.5 3.72 7.623 1.82z"/><path fill-rule="evenodd" d="M4.553 7.776c.82-1.641 1.717-2.753 2.093-3.13l.708.708c-.29.29-1.128 1.311-1.907 2.87z"/></svg><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-droplet" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M7.21.8C7.69.295 8 0 8 0q.164.544.371 1.038c.812 1.946 2.073 3.35 3.197 4.6C12.878 7.096 14 8.345 14 10a6 6 0 0 1-12 0C2 6.668 5.58 2.517 7.21.8m.413 1.021A31 31 0 0 0 5.794 3.99c-.726.95-1.436 2.008-1.96 3.07C3.304 8.133 3 9.138 3 10a5 5 0 0 0 10 0c0-1.201-.796-2.157-2.181-3.7l-.03-.032C9.75 5.11 8.5 3.72 7.623 1.82z"/><path fill-rule="evenodd" d="M4.553 7.776c.82-1.641 1.717-2.753 2.093-3.13l.708.708c-.29.29-1.128 1.311-1.907 2.87z"/></svg><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-droplet" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M7.21.8C7.69.295 8 0 8 0q.164.544.371 1.038c.812 1.946 2.073 3.35 3.197 4.6C12.878 7.096 14 8.345 14 10a6 6 0 0 1-12 0C2 6.668 5.58 2.517 7.21.8m.413 1.021A31 31 0 0 0 5.794 3.99c-.726.95-1.436 2.008-1.96 3.07C3.304 8.133 3 9.138 3 10a5 5 0 0 0 10 0c0-1.201-.796-2.157-2.181-3.7l-.03-.032C9.75 5.11 8.5 3.72 7.623 1.82z"/><path fill-rule="evenodd" d="M4.553 7.776c.82-1.641 1.717-2.753 2.093-3.13l.708.708c-.29.29-1.128 1.311-1.907 2.87z"/></svg>';
    
    }
}
?>
</head>
<body>
<div class="container">
    <div class="Cabecalio"><h1>Bombinhas</h1></div>
<div class="listaItens">
 <div class="letras1">
     <div><p>Temperatura Minima:</p><?php echo"<p>
        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-arrow-down' viewBox='0 0 16 16'>
        <path fill-rule='evenodd' d='M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1'/>
        </svg>
        {$temperaturaMax}°C</p>"; ?></div>
     <div><p>Temperatura Maxima:</p><?php echo"<p>
        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-arrow-up' viewBox='0 0 16 16'>
        <path fill-rule='evenodd' d='M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5'/>
        </svg>
        {$temperaturaMin}°C</p>";?></div>
     <div><p>Chuva precipitação:</p><?php echo"<p>{$chuvaPrecipitacao}mm</p>";?></div>
     <div><p>Chuva probabilidade:</p><?php echo"<p>{$icone}{$chuvaProbabilidade}%</p>";?></div>
     <div><p>Umidade Minima:</p><?php echo "<p>{$umidadeMin}%</p>";?></div>
     <div><p>Umidade Maxima:</p><?php echo "<p>{$umidadeMax}%</p>";?></div>
     <div><p>Velocidade do vento:</p><?php echo "<p>{$vento_velocidade} km/h</p>";?></div>
     <div><p>Direção do vento:</p><?php echo "<p>{$vento_direcao}</p>";?></div>
     <div><p>Nescer do Sol:</p><?php echo "<p>{$orvalio}</p>";?></div>
     <div><p>Crepusculo:</p><?php echo "<p>{$crepusculo}</p>";?></div>
 </div>
 <div class="letras2">
    <div class="ParteDia" >
        <div><?php echo "<img src='realistic/70px/{$morning_condicao}.png' alt='Ícone do clima' class='weather-icon'>";?><br><h2>Manhã</h2></div>
        <div><?php echo "<img src='realistic/70px/{$afternoon_condicao}.png' alt='Ícone do clima' class='weather-icon'>";?><br><h2>Tarde</h2></div>
        <div><?php echo "<img src='realistic/70px/{$dawn_condicao}.png' alt='Ícone do clima' class='weather-icon'>";?><br><h2>Anoitecer</h2></div>
        <div><?php echo "<img src='realistic/70px/{$night_condicao}.png' alt='Ícone do clima' class='weather-icon'>";?><br><h2>Noite</h2></div>   
    </div>
    <div class="Description">
        <p><?php echo "Condição:<br>{$descricao_condicao}" ?></p>
    </div>
 </div>
</div>
</div>
</body>
</html>
<?php              
                   
                   
                   
                   
                   
