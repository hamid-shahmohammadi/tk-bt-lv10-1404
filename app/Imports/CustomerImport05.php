<?php

namespace App\Imports;

use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CustomerImport05 implements ToModel, WithHeadingRow, SkipsOnError, WithValidation, SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;

    /**
     * Persian and Arabic-Indic digits mapped to ASCII.
     */
    private const DIGITS = [
        '۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4',
        '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9',
        '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4',
        '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9',
    ];

    /**
     * Invisible direction/format marks that must never reach the database.
     */
    private const INVISIBLES = '/[\x{200B}\x{200E}\x{200F}\x{202A}-\x{202E}\x{2066}-\x{2069}\x{FEFF}]/u';

    /**
     * @param  array  $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $nationalCode = $this->nationalCode($row['national_code'] ?? null);

        return new Customer([
            'personnel_code' => $this->identifier($row['personnel_code'] ?? null),
            'name' => $this->text($row['name'] ?? null),
            'family' => $this->text($row['family'] ?? null),
            'father' => $this->text($row['father'] ?? null),
            'birth_date' => $this->date($row['birth_date'] ?? null),
            'birth_certificate' => $this->identifier($row['birth_certificate'] ?? null),
            'national_code' => $nationalCode,
            'booklet_number' => $this->identifier($row['booklet_number'] ?? null),
            'account_number' => $this->identifier($row['account_number'] ?? null),
            'mobile' => $this->mobile($row['mobile'] ?? null),
            'sheba' => $this->sheba($row['sheba'] ?? null),
            'username' => $nationalCode,
            'password' => Hash::make((string) $nationalCode),
            'organization_id' => 2,
            'user_id' => 2,
            'active' => 1,
        ]);
    }

    public function rules(): array
    {
        return [
            '*.national_code' => ['unique:customers,national_code'],
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.national_code.unique' => 'کد ملی تکراری می باشد',
        ];
    }

    /**
     * Persian text normalized to a single-spaced trimmed string.
     */
    private function text($value): ?string
    {
        $clean = preg_replace('/[\s\x{00A0}\x{2000}-\x{200A}\x{202F}\x{3000}]+/u', ' ', $this->scrub((string) $value)) ?? '';
        $clean = trim($clean, " \t\n\r\0\x0B\xC2\xA0");

        return $clean === '' ? null : $clean;
    }

    /**
     * Digit-only identifiers kept as strings so leading zeros survive.
     */
    private function identifier($value): ?string
    {
        return $this->digits($value);
    }

    /**
     * Iranian national code: ten digits, left padded when Excel stored it as a number.
     */
    private function nationalCode($value): ?string
    {
        $digits = $this->digits($value);

        if ($digits !== null && strlen($digits) < 10) {
            $digits = str_pad($digits, 10, '0', STR_PAD_LEFT);
        }

        return $digits;
    }

    /**
     * Mobile numbers normalized to the domestic 09xxxxxxxxx form.
     */
    private function mobile($value): ?string
    {
        $digits = $this->digits($value);

        if ($digits !== null && strlen($digits) === 10 && str_starts_with($digits, '9')) {
            $digits = '0'.$digits;
        }

        return $digits;
    }

    /**
     * Jalali date normalized to Y/m/d with zero padded month and day.
     */
    private function date($value): ?string
    {
        $clean = trim($this->scrub((string) $value));

        if (! preg_match('/^(\d{4})[\/\-.](\d{1,2})[\/\-.](\d{1,2})$/', $clean, $m)) {
            return $clean === '' ? null : $clean;
        }

        return sprintf('%04d/%02d/%02d', $m[1], $m[2], $m[3]);
    }

    /**
     * IBAN normalized to the compact IR plus digits form without spaces.
     */
    private function sheba($value): ?string
    {
        $clean = strtoupper($this->scrub((string) $value));
        $compact = preg_replace('/[\s\x{00A0}\x{2000}-\x{200A}\x{202F}\x{3000}]+/u', '', $clean) ?? '';

        return $compact === '' ? null : $compact;
    }

    /**
     * Remove direction marks and convert Persian/Arabic digits to ASCII.
     */
    private function scrub(string $value): string    {
        return strtr(preg_replace(self::INVISIBLES, '', $value) ?? $value, self::DIGITS);
    }

    /**
     * Keep only ASCII digits, never losing leading zeros and never using float notation.
     */
    private function digits($value): ?string
    {
        if ($value === null) {
            return null;
        }

        if (is_int($value) || is_float($value)) {
            $value = sprintf('%.0F', $value);
        }

        $digits = preg_replace('/\D+/', '', $this->scrub((string) $value)) ?? '';

        return $digits === '' ? null : $digits;
    }
}
