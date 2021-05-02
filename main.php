<?php

const TWITCH_TOKEN = 'oauth:Mytoken123';// LINK gerar token: https://twitchapps.com/tmi/
const TWITCH_NICK = 'TWITCH_NICK';//Seu nick na twitch
const TWITCH_PORT = 6667;
const TWITCH_URL = 'irc.chat.twitch.tv';

const BOT_NOME = 'BotTWITCH';//Nome para o bot
const BOT_CHANNELS_TWITCH = [
    // Apelido => Canal
    'ME' => 'Canal_de_destino',
    //'Cellbit' => 'cellbit',
    //'Gaules' => 'gaules',
    //'Alanzoka' => 'alanzoka',
];

// Abrir a aconexão
$socket = fsockopen(TWITCH_URL, TWITCH_PORT,$erro_code,$erro_message);


// Enviar informação de autenticação
fputs($socket, "PASS " . TWITCH_TOKEN . "\n");
fputs($socket, "NICK " . TWITCH_NICK . "\n");

//Conectar aos canais
foreach (BOT_CHANNELS_TWITCH as $apelido => $canal) { 
    echo "Connect to channel: " . $apelido . PHP_EOL;
    fputs($socket, "JOIN #" . $canal . "\n");
    echo PHP_EOL;
}

while (true) {
        
    echo 'Erro code: ' . $erro_code . PHP_EOL;
    echo 'Erro message: ' . $erro_message . PHP_EOL;

    while ($data = fgets($socket, 128)) {
        echo $data . PHP_EOL;
        flush();

        $ex = explode(' :', $data);

        //Manter a conexao com a twitch
        if($ex[0] == "PING"){
            fputs($socket, "PONG :" . $ex[1] . "\n");
        }
    }
}
