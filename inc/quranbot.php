<?php
$conn = mysqli_connect("localhost", "myquran", "Bintang6$", "myquran");
if (!$conn) die("MySQL DIE");
$API_TELEGRAM = "https://api.telegram.org/bot5503009933:AAG-bRNvM8XDP41eX09nunqWUmt9M4HqNuU";

$output = json_decode(file_get_contents('php://input')); 
$chat_id = $output->message->chat->id; 
$firstname = $output->message->chat->first_name;
$lastname = $output->message->chat->last_name;
$username = isset($output->message->chat->username) ? $output->message->chat->username:false;
$message = $output->message->text;
file_put_contents('log/update.json', json_encode($output));



$phone_number = isset($output->message->contact) ? str_replace('+', '', $output->message->contact->phone_number):false;
$user_location = isset($output->message->location) ? $output->message->location:false;
$button1 = '{"keyboard":[[{"text":"📲📲📲 KIRIM NO.HP 📱📱📱","request_contact":true}]],"resize_keyboard":true,"one_time_keyboard":true}';
$button2 = '{"keyboard":[[{"text":"🗺🗺🗺 KIRIM LOKASI 🗺🗺🗺","request_location":true}]],"resize_keyboard":true,"one_time_keyboard":true}';
$button3 = json_encode([
        "inline_keyboard" => [
            [
                [
                    "text" => "🕌🕌🕋🕋🕋 READ QUR`AN 🕋🕋🕋🕌🕌",
                    "web_app" => ["url" => "https://myquran.click/bot"]
                ]
            ],
            [
                [
                    "text" => "🕌🕋 ID TRANSLATE PER JUZ 🕋🕌",
                    "web_app" => ["url" => "https://myquran.click/bot/juz"]
                ]
            ],
            [
                [
                    "text" => "🕌🕋 ID TRANSLATE PER SURAH 🕋🕌",
                    "web_app" => ["url" => "https://myquran.click/bot/surah"]
                ]
            ],
            [
                [
                    "text" => "🕌🕋 ID, EN TRANSLATE AND TAFSIR 🕋🕌",
                    "web_app" => ["url" => "https://myquran.click/bot/ayah"]
                ]
            ]
        ]
    ]);

if ($chat_id) {
   $checkuser = newUser($chat_id, $username, $firstname, $lastname);
}


if ($phone_number) {
    registerUser($chat_id, $phone_number, $username, $firstname, $lastname);
    sendMessage($chat_id, "Yang kedua\nUntuk meminimalisir buyer BID and RUN, silahkan share lokasi Anda dengan klik tombol <b><em>KIRIM LOKASI</em></b> di bawah ini lalu pilih OK dan ijinkan kami untuk mengakses lokasi Anda saat ini. 🙏🏻\n{$phone}", $button2);
}

if ($user_location) {
    updateLocation($chat_id, $user_location->latitude, $user_location->longitude);
    removeButton($chat_id, "<b>Terima kasih sudah mengikuti step by step pendaftaran dan\nSelamat datang di GO KOI Marketplace</b>");
    sendMessage($chat_id, "Klik tombol dibawah ini untuk melihat lapak para seller kami\n\nHappy shopping 🤗", $button3);    
}

switch ($message) {
    case '/start':
        sendMessage($chat_id, "<b>بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ</b>\n\nLife is so short. Let's make Al-Qur`an Kareem and Sunnah the leader of our life.\n\nWebsite: https://myquran.click\n\nThis bot developed by @cemonggaul\n\nDonate: https://paypal.me/cemonggaul", $button3);
        break;
}


function sendMessage($id, $text, $button = null){
    GLOBAL $API_TELEGRAM;
    switch(isset($button)){
        case true:
            $H = "&reply_markup={$button}";
            $url = "{$API_TELEGRAM}/sendMessage?chat_id={$id}&parse_mode=HTML&text=".urlencode($text).$H;
            break;
        default:
            $url = "{$API_TELEGRAM}/sendMessage?chat_id={$id}&parse_mode=HTML&text=".urlencode($text);
            break;
    }
    return file_get_contents($url);
}

function removeButton($id, $reply)
{
    GLOBAL $API_TELEGRAM;
    $reply_markup = array(
        'remove_keyboard' => true
    );
    $url = "{$API_TELEGRAM}/sendmessage?chat_id={$id}&parse_mode=HTML&text=".urlencode($reply)."&reply_markup=".urlencode(json_encode($reply_markup));
    return file_get_contents($url);
}


function sendFoto($id, $file, $caption, $button = null){
    GLOBAL $API_TELEGRAM;
    switch(isset($button)){
        case true:
            $H = "&reply_markup={$button}";
            $url = "{$API_TELEGRAM}/sendPhoto?chat_id={$id}&caption={$caption}&photo=".$file.$H;
            break;
        default:
            $url = "{$API_TELEGRAM}/sendPhoto?chat_id={$id}&caption={$caption}&photo=".$file;
            break;
    }
    return file_get_contents($url);
}

function checkUserExist($chat_id){
    global $conn;
    $sql = mysqli_query($conn, "SELECT * FROM users WHERE id = '{$chat_id}'");
    while ($row=mysqli_fetch_assoc($sql)) {
        return $row;
    }
}

function newUser($chat_id, $username, $name){
    global $conn;
    $query = "INSERT IGNORE INTO users (chat_id, phone, username, name) VALUES ('{$chat_id}', '{$phone}', '{$username}', '{$firstname} {$lastname}')";    
    if(mysqli_query($conn, $query)){
        file_put_contents('log/register.log', $query."\n", FILE_APPEND);
        return true;
    }
}

function checkPhone($phone){
    global $conn;    
    $query = "SELECT * FROM users WHERE phone = '{$phone}'";
    file_put_contents('log/checkphone.log', $query."\n", FILE_APPEND);
    $sql = mysqli_query($conn, $query);
    while ($row = mysql_fetch_assoc($sql)) {
        return true;
    }
}

function  registerUser($chat_id, $phone_number, $username, $firstname, $lastname){
    global $conn;
    $password = password_hash(123456, PASSWORD_DEFAULT);
    $phone = str_replace('+', '', $phone_number);
    $phone = substr_replace($phone, 0, 0, 2);
    
    $query = "INSERT IGNORE INTO users (id, phone, username, name, password) VALUES ('{$chat_id}', '{$phone}', '{$username}', '{$firstname} {$lastname}', '{$password}')";
    file_put_contents('log/register.log', $query."\n", FILE_APPEND);
    if(mysqli_query($conn, $query)){        
        return true;
    } elseif (checkPhone($phone)) {
        updatePhone($chat_id, $phone);
        return true;
    }
}

function updatePhone($id, $phone){
    global $conn;
    $phone = str_replace('+', '', $phone);
    $phone = substr_replace($phone, 0, 0, 2);
    $query = "UPDATE users SET id = '{$id}' WHERE phone = '{$phone}'";
    file_put_contents('log/phone.log', $query."\n", FILE_APPEND);
    if (mysqli_query($conn, $query)) {
        return $phone;
    }
}

function updateLocation($id, $latitude, $longitude){
    global $conn;
    $query = "UPDATE users SET latitude = '{$latitude}', longitude = '{$longitude}' WHERE id = '{$id}'";
    file_put_contents('log/location.log', $query."\n", FILE_APPEND);
    if (mysqli_query($conn, $query)) {
        return true;
    }
}