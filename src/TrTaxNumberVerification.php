<?php

namespace NetkodBilisim;

use GuzzleHttp\Client;

class TrTaxNumberVerification
{
    public const API_URL = 'https://ivd.gib.gov.tr/tvd_server';
    protected static ?Client $client = null;
    protected static ?string $token = null;
    protected static array $errorCodeList = [
        1 => 'İşletme tipi tüzel kişi için 1, şahıs şirketi için 2 olmalıdır!',
        2 => 'Vergi numarası geçerli değil!',
        3 => 'Servise ulaşılamıyor!',
        4 => 'Firma bilgileri bulunamadı!',
    ];

    public static function verify(int $company_type, string $tax_number, string $tax_office_no)
    {
        if (! in_array($company_type, [1, 2])) {
            return static::errorResponse(1);
        }

        if (($company_type === 1 && ! TrTaxNumberValidation::validate($tax_number)) || ($company_type === 2 && ! TrIdentityNumberValidation::validate($tax_number))) {
            return static::errorResponse(2);
        }

        $jp = static::makeQuery($company_type, $tax_number, $tax_office_no);
        $response = static::getClient()->post(static::API_URL.'/dispatch', [
            'query' => [
                'cmd' => 'vergiNoIslemleri_vergiNumarasiSorgulama',
                'token' => static::getToken(),
                'jp' => json_encode($jp),
            ],
        ]);
        $response = json_decode($response->getBody());

        if (isset($response->error)) {
            return static::errorResponse(3);
        } else if (isset($response->data) && ! isset($response->data->durum)) {
            return static::errorResponse(4);
        }

        return (object) [
            'status' => true,
            'data' => (object) [
                'title' => $response->data->unvan,
                'tax_no' => $response->data->vkn,
            ],
        ];
    }

    public static function errorResponse(int $errorCode): object
    {
        return (object) [
            'status' => false,
            'error' => (object) [
                'code' => $errorCode,
                'description' => static::$errorCodeList[$errorCode],
            ],
        ];
    }

    public static function makeQuery(int $company_type, string $tax_number, string $tax_office_no): array
    {
        $vkn1 = '';
        $tckn1 = '';
        if ($company_type === 1) {
            $vkn1 = $tax_number;
        } else if ($company_type === 2) {
            $tckn1 = $tax_number;
        }

        return [
            'dogrulama' => [
                'vkn1' => $vkn1,
                'tckn1' => $tckn1,
                'vergidaireleri' => $tax_office_no,
            ],
        ];
    }

    public static function getClient(): Client
    {
        if (static::$client !== null) {
            return static::$client;
        }

        return static::$client = new Client();
    }

    public static function getToken(): string
    {
        if (static::$token !== null) {
            return static::$token;
        }

        $response = static::getClient()->post(static::API_URL.'/assos-login', [
            'query' => [
                'assoscmd' => 'cfsession',
                'fskey' => 'intvrg.fix.session',
                'fuserid' => 'INTVRG_FIX',
            ],
        ]);

        return static::$token = json_decode($response->getBody())->token;
    }
}
