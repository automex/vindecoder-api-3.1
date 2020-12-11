<?php
namespace vzhabonos\vindecoder;

/**
 * Class Api
 * @package vzhabonos\vindecoder
 *
 * @property $apiKey
 * @property $secretKey
 */
class Api
{
    const API_PREFIX = 'https://api.vindecoder.eu/3.1';

    const ID_DECODE_INFO = 'info';
    const ID_DECODE = 'decode';
    const ID_STOLEN_CHECK = 'stolen-check';
    const ID_BALANCE = 'balance';

    private static $endpoints = [
        self::ID_DECODE_INFO => 'decode/info',
        self::ID_DECODE => 'decode',
        self::ID_STOLEN_CHECK => 'stolen-check',
        self::ID_BALANCE => 'balance',
    ];

    private $apiKey, $secretKey;

    /**
     * Api constructor.
     * @param string $apiKey
     * @param string $secretKey
     */
    public function __construct(string $apiKey, string $secretKey)
    {
        $this->apiKey = $apiKey;
        $this->secretKey = $secretKey;
    }

    /**
     * @param string $vin
     * @return array|bool|null
     */
    public function decodeInfo(string $vin)
    {
        return $this->makeApiRequest(self::ID_DECODE_INFO, $vin);
    }

    /**
     * @param string $vin
     * @return array|bool|null
     */
    public function decode(string $vin)
    {
        return $this->makeApiRequest(self::ID_DECODE, $vin);
    }

    /**
     * @param string $vin
     * @return array|bool|null
     */
    public function stolenCheck(string $vin)
    {
        return $this->makeApiRequest(self::ID_STOLEN_CHECK, $vin);
    }

    /**
     * @return array|bool|null
     */
    public function balance()
    {
        return $this->makeApiRequest(self::ID_BALANCE);
    }

    /**
     * @param string $id
     * @param null $vin
     * @return mixed
     */
    private function makeApiRequest(string $id, $vin = null)
    {
        if (!empty($vin)) {
            $vin = mb_strtoupper($vin);
        }

        $url = self::API_PREFIX . '/' . $this->apiKey . '/' . $this->generateControlSum($id, $vin) . '/' . $this->getEndpoint($id);
        if (!empty($vin)) {
            $url .= '/' . $vin;
        }
        $url .= '.json';

        return json_decode(file_get_contents($url, false), true);
    }

    /**
     * @param string $id
     * @param string|null $vin
     * @return string|false
     */
    private function generateControlSum(string $id, $vin = null)
    {
        $string = "{$id}|{$this->apiKey}|{$this->secretKey}";

        if (!empty($vin)) {
            $string = "$vin|" . $string;
        }

        return substr(sha1($string), 0, 10);
    }

    /**
     * @param string $id
     * @return string|null
     */
    private function getEndpoint(string $id)
    {
        return self::$endpoints[$id] ?? null;
    }

}