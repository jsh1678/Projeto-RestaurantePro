<?php

namespace App\Support;

class PixPayload
{
    public static function make(float $amount, string $txid): string
    {
        $key = (string) config('pix.key');
        if ($key === '') {
            return '';
        }

        $merchantAccount = self::field('00', 'BR.GOV.BCB.PIX')
            . self::field('01', $key);

        $payload = self::field('00', '01')
            . self::field('26', $merchantAccount)
            . self::field('52', '0000')
            . self::field('53', '986')
            . self::field('54', number_format($amount, 2, '.', ''))
            . self::field('58', 'BR')
            . self::field('59', self::normalize((string) config('pix.merchant_name'), 25))
            . self::field('60', self::normalize((string) config('pix.merchant_city'), 15))
            . self::field('62', self::field('05', self::normalizeTxid($txid)))
            . '6304';

        return $payload . self::crc16($payload);
    }

    private static function field(string $id, string $value): string
    {
        return $id . str_pad((string) strlen($value), 2, '0', STR_PAD_LEFT) . $value;
    }

    private static function normalize(string $value, int $limit): string
    {
        $ascii = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $value) ?: $value;
        $ascii = strtoupper(preg_replace('/[^A-Z0-9 .-]/i', '', $ascii) ?? '');

        return substr(trim($ascii), 0, $limit);
    }

    private static function normalizeTxid(string $txid): string
    {
        $txid = preg_replace('/[^A-Z0-9]/i', '', $txid) ?? 'PEDIDO';

        return substr(strtoupper($txid), 0, 25);
    }

    private static function crc16(string $payload): string
    {
        $crc = 0xFFFF;
        $length = strlen($payload);

        for ($i = 0; $i < $length; $i++) {
            $crc ^= ord($payload[$i]) << 8;

            for ($bit = 0; $bit < 8; $bit++) {
                $crc = ($crc & 0x8000)
                    ? (($crc << 1) ^ 0x1021)
                    : ($crc << 1);
                $crc &= 0xFFFF;
            }
        }

        return strtoupper(str_pad(dechex($crc), 4, '0', STR_PAD_LEFT));
    }
}
