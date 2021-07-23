<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/ammo', function () {
    $subdomain = 'terradigital'; //Поддомен нужного аккаунта
    $link = 'https://' . $subdomain . '.amocrm.com/oauth2/access_token'; //Формируем URL для запроса

    /** Соберем данные для запроса */
    $data = [
    	'client_id' => '5a77fdcc-f695-4652-8c1b-75668cbde555',
    	'client_secret' => 'HhBKLHrXaUDmQZZaAp424ciUFnvP16kAWPW2eDZTJc7GS7cbgebnE6gqoLbwbGfR',
    	'grant_type' => 'authorization_code',
    	'code' => 'def502007712b578a6d49a4c08c30cb371bb368561eefbe88b2b645750e8d9837bd91b3a1250aeda3400b948b0b30bc3fd29b83788238a809f36674b76d8365d9700c0a584b04b1df64d2f4ecc11b872dbce8f8507d8bc7ae00739c00176ff42c0f058d2c7028195a22bfd62dac6aeee6a6196b6a5d0023da47459470bd97a32d992cdd01b6f29ff011e18fac70496ae7349947ca50d8e2189f3cbc725f691f74018c77cc4ea8d2ccad966ec0862abfad4976a3a47d915302e1afd228090ec773c63cd24158a1d015b7518dbc1aa91316f07b8993a558418d79fa1516d0bbf5ff309036e1ea8175ae999268810aa1e98a3c0dae96913a5b5a8a6fe616dcb16b4ad4781d2da997c1124b2042aa5b37292d18c53bfc6d2243b654f5d4c77214ce158725eb4f58de35c719b514993209fd6f540fd398327f34de41f6debd0aa60392efbc5e9f61bfa99ac21ec154067beca04188b2a296b7aa0b263d65ea406dcc9b76c6cd0bc78912bf4681bd56a2689c750b141ace8f552be50bb35d836f7a25d420592decaf48c003bbb0c9100f927e2cac835eba5917401b155bc20d3ede61cdbe5e1a60d7a4ed447918fa56524683d0e2b8957ac8ed689ceec9c4f58083ac46f',
    	'redirect_uri' => 'https://terradigita.ro/',
    ];

    /**
     * Нам необходимо инициировать запрос к серверу.
     * Воспользуемся библиотекой cURL (поставляется в составе PHP).
     * Вы также можете использовать и кроссплатформенную программу cURL, если вы не программируете на PHP.
     */
    $curl = curl_init(); //Сохраняем дескриптор сеанса cURL
    /** Устанавливаем необходимые опции для сеанса cURL  */
    curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
    curl_setopt($curl,CURLOPT_URL, $link);
    curl_setopt($curl,CURLOPT_HTTPHEADER,['Content-Type:application/json']);
    curl_setopt($curl,CURLOPT_HEADER, false);
    curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
    $out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
    $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    /** Теперь мы можем обработать ответ, полученный от сервера. Это пример. Вы можете обработать данные своим способом. */
    $code = (int)$code;
    $errors = [
    	400 => 'Bad request',
    	401 => 'Unauthorized',
    	403 => 'Forbidden',
    	404 => 'Not found',
    	500 => 'Internal server error',
    	502 => 'Bad gateway',
    	503 => 'Service unavailable',
    ];

    // try
    // {
    // 	/** Если код ответа не успешный - возвращаем сообщение об ошибке  */
    // 	if ($code < 200 || $code > 204) {
    // 		throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undefined error', $code);
    // 	}
    // }
    // catch(\Exception $e)
    // {
    // 	die('Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
    // }

    /**
     * Данные получаем в формате JSON, поэтому, для получения читаемых данных,
     * нам придётся перевести ответ в формат, понятный PHP
     */
    $response = json_decode($out, true);

    dd($response);

    $access_token = $response['access_token']; //Access токен
    $refresh_token = $response['refresh_token']; //Refresh токен
    $token_type = $response['token_type']; //Тип токена
    $expires_in = $response['expires_in']; //Через сколько действие токена истекает
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
