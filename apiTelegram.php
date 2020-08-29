<?php
namespace App\Folder;

/**
 * apiTelegram Class
 */
class apiTelegram
{

    /**
     * Токен API Telegram
     * @var string
     */
    private $token = '4444333304:HIuhfiefhiooeBdjbkqodiowqorp';
    /**
     * Чат с ботом
     * @var string
     */
    private $chat_with_bot_id = '235235235';
    /**
     * ID чату, куда отправляются сообщения
     * Узнать id чата - https://api.telegram.org/botBOT:TOKEN/getChat?chat_id=@мойканал
     * Проверка отправки сообщения - https://api.telegram.org/bot[BOT:TOKEN]/sendMessage?chat_id=[chat_id]&text=[text]
     *
     * @param string $text
     * @param string $method
     * @param string $chat_id
     * @param string $parse_mode
     * @param array $proxy
     */
    public function sendInTelegram($text, $method = 'sendMessage', $chat_id, $parse_mode = 'html', $proxy = []) {
        /**
         * Дескриптор cURL
         */
        $ch = curl_init();
        /**
         * Загружаемый URL
         */
        $curl_array['CURLOPT_URL'] = 'https://api.telegram.org/bot' . $this->token . '/'.$method;
        /**
         * TRUE для использования обычного HTTP POST.
         * Данный метод POST использует обычный application/x-www-form-urlencoded, обычно используемый в HTML-формах.
         */
        $curl_array['CURLOPT_POST'] = TRUE;
        /**
         * TRUE для возврата результата передачи в качестве строки из curl_exec() вместо прямого вывода в браузер.
         */
        $curl_array['CURLOPT_RETURNTRANSFER'] = TRUE;
        /**
         * Максимально позволенное количество секунд для выполнения cURL-функций.
         */
        $curl_array['CURLOPT_TIMEOUT'] = 10;
        /**
         * Все данные, передаваемые в HTTP POST-запросе.
         */
        $curl_array['CURLOPT_POSTFIELDS'] = [
            'chat_id' => $chat_id ?? $this->chat_with_bot_id,
            'parse_mode' => $parse_mode,
            'text' => $text,
        ];
        /**
         * Proxy sittings
         */
        if(isset($proxy['ip']) && isset($proxy['port']) && isset($proxy['login']) && isset($proxy['password'])) {
            /**
             * HTTP-прокси, через который будут направляться запросы.
             */
            $curl_array['CURLOPT_PROXY'] = $proxy['ip'].':'.$proxy['port'];

            /**
             * Логин и пароль, записанные в виде "[username]:[password]", используемые при соединении через прокси.
             */
            $curl_array['CURLOPT_PROXYUSERPWD'] = $proxy['login'].':'.$proxy['password'];

            /**
             * Либо CURLPROXY_HTTP (по умолчанию),
             * либо CURLPROXY_SOCKS4, CURLPROXY_SOCKS5, CURLPROXY_SOCKS4A или CURLPROXY_SOCKS5_HOSTNAME.
             */
            $curl_array['CURLOPT_PROXYTYPE'] = CURLPROXY_HTTP;

            /**
             * Методы авторизации HTTP, используемые при соединении с прокси-сервером.
             * Используйте те же самые битовые маски, которые были описаны у параметра CURLOPT_HTTPAUTH.
             * В данный момент для авторизации прокси поддерживаются только CURLAUTH_BASIC и CURLAUTH_NTLM.
             */
            $curl_array['CURLOPT_PROXYAUTH'] = CURLAUTH_BASIC;
        }

        /**
         * Устанавливает несколько параметров для сеанса cURL
         */
        curl_setopt_array($ch, $curl_array);
        /**
         * Выполняет запрос cURL
         */
        curl_exec($ch);
    }

}
