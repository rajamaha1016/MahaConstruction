<?php

namespace App\Support;

/**
 * Deterministic badge styling for partner/vendor logos we don't have
 * actual brand artwork for — a colored initials badge, similar to how
 * the banking/vendor cards were originally prototyped.
 */
class BrandColor
{
    /**
     * Known brand -> [initials, hex color], loosely matching each
     * brand's real-world identity color so the badges stay recognizable.
     */
    protected static array $known = [
        'HDFC BANK'            => ['HDFC', '#004C8F'],
        'STATE BANK OF INDIA'  => ['SBI',  '#22409A'],
        'SBI HOME LOANS'       => ['SBI',  '#22409A'],
        'ICICI BANK'           => ['ICICI', '#B4131A'],
        'AXIS BANK'            => ['AXIS', '#97144D'],
        'KOTAK MAHINDRA'       => ['KMB',  '#ED1C24'],
        'YES BANK'             => ['YES',  '#00477B'],
        'IDFC FIRST BANK'      => ['IDFC', '#8A1C64'],
        'INDIAN BANK'          => ['IND',  '#0D5EAF'],
        'UCO BANK'             => ['UCO',  '#8B1E3F'],
        'BANK OF INDIA'        => ['BOI',  '#E31B23'],
        'CANARA BANK'          => ['CAN',  '#FFB300'],
        'JSW STEEL'            => ['JSW',  '#E31E24'],
        'ASIAN PAINTS'         => ['AP',   '#EE2E24'],
        'KAJARIA TILES'        => ['KAJ',  '#C8102E'],
        'RAMCO SUPERGRADE'     => ['RAM',  '#005BAA'],
        'PARRYWARE'            => ['PAR',  '#00539F'],
        'NIPPON PAINT'         => ['NP',   '#004EA2'],
        'JAQUAR'               => ['JAQ',  '#1A1A1A'],
        'TATA TISCON'          => ['TATA', '#153B6B'],
        'ULTRATECH CEMENT'     => ['UTC',  '#8B1E1E'],
    ];

    protected static array $palette = [
        '#B4131A', '#004C8F', '#8A1C64', '#005BAA', '#E31E24',
        '#153B6B', '#8B1E3F', '#22409A', '#97144D', '#00539F',
    ];

    public static function initials(string $name): string
    {
        $key = strtoupper(trim($name));
        if (isset(static::$known[$key])) {
            return static::$known[$key][0];
        }

        $words = preg_split('/\s+/', trim($name));
        $letters = array_map(fn ($w) => mb_strtoupper(mb_substr($w, 0, 1)), array_slice($words, 0, 3));

        return implode('', $letters) ?: '?';
    }

    public static function for(string $name): string
    {
        $key = strtoupper(trim($name));
        if (isset(static::$known[$key])) {
            return static::$known[$key][1];
        }

        $hash = crc32($key);
        return static::$palette[$hash % count(static::$palette)];
    }
}
