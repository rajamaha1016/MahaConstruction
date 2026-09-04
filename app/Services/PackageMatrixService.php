<?php

namespace App\Services;

use App\Models\Setting;
use App\Models\PackageDetail;

class PackageMatrixService
{
    /**
     * Get the active matrix for a division.
     * Returns custom data if saved in Setting, otherwise returns default specs.
     */
    public static function getMatrix(string $division = 'residential'): array
    {
        $division = strtolower(trim($division));
        $key = 'spec_matrix_' . $division;

        try {
            $setting = Setting::where('key', $key)->first();
            if ($setting && !empty($setting->value)) {
                return self::parseMatrix($setting->value, $division);
            }
        } catch (\Throwable $e) {
            // fallback if db or table error
        }

        return self::getDefaultMatrix($division);
    }

    /**
     * Parse raw JSON or array into normalized matrix structure.
     */
    public static function parseMatrix($raw, string $division = 'residential'): array
    {
        $division = strtolower(trim($division));
        $default = self::getDefaultMatrix($division);

        if (empty($raw)) {
            return $default;
        }

        $data = is_string($raw) ? json_decode($raw, true) : $raw;
        if (!is_array($data) || empty($data['headers']) || empty($data['rows'])) {
            return $default;
        }

        // Clean headers
        $headers = array_values(array_map('trim', (array) $data['headers']));
        if (empty($headers)) {
            $headers = $default['headers'];
        }

        // Clean rows
        $cleanRows = [];
        foreach ($data['rows'] as $row) {
            $feature = trim($row['feature'] ?? $row['specification'] ?? $row['title'] ?? '');
            if ($feature === '') {
                continue;
            }

            $values = [];
            $rawValues = $row['values'] ?? [];

            if (is_array($rawValues)) {
                // If indexed by column name or numeric index
                foreach ($headers as $idx => $headerName) {
                    if (array_key_exists($headerName, $rawValues)) {
                        $values[] = (string) $rawValues[$headerName];
                    } elseif (array_key_exists($idx, $rawValues)) {
                        $values[] = (string) $rawValues[$idx];
                    } else {
                        $values[] = '';
                    }
                }
            } else {
                $values = array_fill(0, count($headers), '');
            }

            $cleanRows[] = [
                'feature' => $feature,
                'values'  => $values,
            ];
        }

        if (empty($cleanRows)) {
            return $default;
        }

        return [
            'is_custom' => true,
            'division'  => $division,
            'headers'   => $headers,
            'rows'      => $cleanRows,
        ];
    }

    /**
     * Save matrix data for a division into settings.
     */
    public static function saveMatrix(string $division, array $matrixData): array
    {
        $division = strtolower(trim($division));
        $key = 'spec_matrix_' . $division;

        $headers = array_values(array_map('trim', (array) ($matrixData['headers'] ?? [])));
        $rawRows = (array) ($matrixData['rows'] ?? []);

        $cleanRows = [];
        foreach ($rawRows as $row) {
            $feature = trim($row['feature'] ?? '');
            if ($feature === '') {
                continue;
            }

            $rowVals = [];
            $vals = (array) ($row['values'] ?? []);
            foreach ($headers as $idx => $h) {
                if (array_key_exists($h, $vals)) {
                    $rowVals[] = (string) $vals[$h];
                } elseif (array_key_exists($idx, $vals)) {
                    $rowVals[] = (string) $vals[$idx];
                } else {
                    $rowVals[] = '';
                }
            }

            $cleanRows[] = [
                'feature' => $feature,
                'values'  => $rowVals,
            ];
        }

        $payload = [
            'is_custom' => true,
            'division'  => $division,
            'headers'   => $headers,
            'rows'      => $cleanRows,
        ];

        $json = json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        Setting::updateOrCreate(
            ['key' => $key],
            ['value' => $json]
        );

        return $payload;
    }

    /**
     * Default specifications matrix for Residential builds.
     */
    public static function getDefaultMatrix(string $division = 'residential'): array
    {
        $division = strtolower(trim($division));

        if ($division === 'commercial') {
            return [
                'is_custom' => false,
                'division'  => 'commercial',
                'headers'   => ['STANDARD SHELL', 'PREMIUM CORPORATE', 'ELITE COMMERCIAL'],
                'rows'      => [
                    [
                        'feature' => 'STRUCTURAL STEEL',
                        'values'  => ['Fe-500 TMT structural steel', 'Fe-550 TMT (JSW Steel)', 'Fe-550D High Ductility Steel']
                    ],
                    [
                        'feature' => 'CEMENT GRADE',
                        'values'  => ['OPC 53 grade cement', 'Ultratech / Ambuja cement', 'High-performance Ready Mix Concrete (M30+)']
                    ],
                    [
                        'feature' => 'STRUCTURAL SYSTEM',
                        'values'  => ['RCC framed structure', 'RCC frame + shear walls', 'Post-tensioned slabs & composite columns']
                    ],
                    [
                        'feature' => 'FLOORING',
                        'values'  => ['Vitrified floor tiles', 'Granite / double charged vitrified', 'Heavy-duty epoxy / imported Italian marble']
                    ],
                    [
                        'feature' => 'SANIRY & MEP',
                        'values'  => ['Core commercial plumbing & electrical', 'Jaquar CP sets + DG backup provision', 'Kohler touchless sensors, BMS & fire hydrants']
                    ],
                    [
                        'feature' => 'ELEVATOR / ACCESS',
                        'values'  => ['Core elevator shaft ready', 'Passenger elevator shaft + motor room', 'High-speed automatic elevators with card access']
                    ],
                    [
                        'feature' => 'EXTERIOR FACADE',
                        'values'  => ['Weatherproof base plaster finish', 'Curtain wall glass & ACP panel cladding', 'Unitized double-glazed structural facade']
                    ],
                    [
                        'feature' => 'STRUCTURAL WARRANTY',
                        'values'  => ['10 Years', '15 Years', '20 Years']
                    ],
                    [
                        'feature' => 'DELIVERY TIMELINE',
                        'values'  => ['14 Months', '18 Months', '24 Months']
                    ]
                ]
            ];
        }

        // Default Residential Matrix
        return [
            'is_custom' => false,
            'division'  => 'residential',
            'headers'   => ['BASIC', 'PREMIUM', 'LUXURY'],
            'rows'      => [
                [
                    'feature' => 'STRUCTURAL STEEL',
                    'values'  => ['Fe-500 TMT (Standard)', 'Fe-550 TMT (JSW / Vizag)', 'Fe-550 TMT (Tata Tiscon / JSPL)']
                ],
                [
                    'feature' => 'CEMENT QUALITY',
                    'values'  => ['Coromandel / ACC', 'Ultratech Premium / Dalmia', 'Birla Super / ACC Gold']
                ],
                [
                    'feature' => 'SAND & AGGREGATES',
                    'values'  => ['M-Sand blockwork', 'Double-washed M-Sand', 'Premium river sand']
                ],
                [
                    'feature' => 'FLOOR TILES',
                    'values'  => ['Vitrified tiles (2\'×2\')', 'Kajaria double charged (4\'×2\')', 'Italian Travertine / marble slabs']
                ],
                [
                    'feature' => 'BATHROOM FITTINGS',
                    'values'  => ['Parryware / Metro CP', 'Jaquar sanitary & CP sets', 'Kohler / Grohe premium']
                ],
                [
                    'feature' => 'ELECTRICAL WIRING',
                    'values'  => ['Kundan / Anchor wires', 'Polycab + Roma switches', 'Finolex + Legrand switches']
                ],
                [
                    'feature' => 'MAIN DOOR',
                    'values'  => ['Solid flush door', 'Teak wood luxury door', 'First-grade carved Teak']
                ],
                [
                    'feature' => 'WALL FINISH',
                    'values'  => ['Asian Paints Emulsion', 'Apex Ultima weather coat', 'Royale textured / custom panels']
                ],
                [
                    'feature' => 'STRUCTURAL WARRANTY',
                    'values'  => ['10 Years', '15 Years', '20 Years']
                ],
                [
                    'feature' => 'DELIVERY TIMELINE',
                    'values'  => ['12 Months', '14 Months', '18 Months']
                ]
            ]
        ];
    }
}
