<?php

namespace App\Imports;

use App\Models\Customer;
use App\Models\Depend;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class DependsImport05 implements ToModel, WithHeadingRow, SkipsOnError, WithValidation, SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;

    /**
     * Rows skipped because the dependent carries no usable national code.
     *
     * @var array<int, array<string, mixed>>
     */
    public array $skipped = [];

    /**
     * Rows skipped because the two national codes in the sheet collide.
     *
     * @var array<int, array<string, mixed>>
     */
    public array $duplicates = [];

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
     * Invisible direction/format marks and non-breaking spaces.
     */
    private const INVISIBLES = '/[\x{00A0}\x{200B}\x{200E}\x{200F}\x{202A}-\x{202E}\x{2066}-\x{2069}\x{FEFF}]/u';

    private const WHITESPACE = '/[\s\x{00A0}\x{2000}-\x{200A}\x{202F}\x{3000}]+/u';

    /**
     * Dependents are linked to a parent customer by national code.
     * relation_id 1=همسر, 2=پسر, 3=دختر, 4=پدر, 5=مادر.
     */
    private const SEX_BY_RELATION = [
        1 => 'f',
        2 => 'm',
        3 => 'f',
        4 => 'm',
        5 => 'f',
    ];

    /**
     * @var array<string, bool>
     */
    private array $seen = [];

    public function model(array $row)
    {
        $nationalCode = $this->nationalCode($row['national_code'] ?? null);
        $parentCode = $this->nationalCode($row['parent'] ?? null);

        if ($nationalCode === null) {
            $this->skip($row, 'کد ملی بیمه شده خالی یا نامعتبر است');

            return null;
        }

        if (isset($this->seen[$nationalCode])) {
            $this->duplicates[] = [
                'national_code' => $nationalCode,
                'name' => (string) ($row['name'] ?? ''),
                'family' => (string) ($row['family'] ?? ''),
            ];

            return null;
        }

        $customer = $parentCode === null ? null : Customer::where('national_code', $parentCode)->first();

        if ($customer === null) {
            $this->skip($row, 'بیمه شده اصلی با کد ملی '.$parentCode.' یافت نشد');

            return null;
        }

        $birthDate = $this->date($row['birth_date'] ?? null);

        if ($birthDate === null) {
            $this->skip($row, 'تاریخ تولد خالی یا نامعتبر است (ستون تاریخ تولد اجباری می باشد)');

            return null;
        }

        $this->seen[$nationalCode] = true;

        $relationId = $this->relation($row['relation_id'] ?? null);

        return new Depend([
            'name' => $this->text($row['name'] ?? null),
            'family' => $this->text($row['family'] ?? null),
            'father' => $this->text($row['father'] ?? null),
            'sex' => self::SEX_BY_RELATION[$relationId] ?? 'm',
            'national_code' => $nationalCode,
            'birth_certificate' => $this->identifier($row['birth_certificate'] ?? null),
            'birth_date' => $birthDate,
            'mobile' => $this->mobile($row['mobile'] ?? null),
            'user_id' => 2,
            'customer_id' => $customer->id,
            'relation_id' => $relationId,
            'active' => 1,
        ]);
    }

    public function rules(): array
    {
        return [
            '*.national_code' => ['unique:depends,national_code'],
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.national_code.unique' => 'کد ملی تکراری می باشد',
        ];
    }

    /**
     * Persian text normalized to single spaces without invisible characters.
     */
    private function text($value): ?string
    {
        $clean = preg_replace(self::WHITESPACE, ' ', $this->scrub((string) $value)) ?? '';
        $clean = trim($clean);

        return $clean === '' ? null : $clean;
    }

    private function identifier($value): ?string
    {
        return $this->digits($value);
    }

    /**
     * Ten digit national code, left padded when Excel stored it as a number.
     */
    private function nationalCode($value): ?string
    {
        $digits = $this->digits($value);

        if ($digits === null || strlen($digits) > 10) {
            return null;
        }

        return str_pad($digits, 10, '0', STR_PAD_LEFT);
    }

    private function mobile($value): ?string
    {
        $digits = $this->digits($value);

        if ($digits !== null && strlen($digits) === 10 && str_starts_with($digits, '9')) {
            $digits = '0'.$digits;
        }

        return $digits;
    }

    /**
     * Jalali date normalized to Y/m/d; empty cells stay null because the column is nullable.
     */
    private function date($value): ?string
    {
        $clean = trim($this->scrub((string) $value));

        if (! preg_match('/^(\d{4})[\/\-.](\d{1,2})[\/\-.](\d{1,2})$/', $clean, $m)) {
            return null;
        }

        return sprintf('%04d/%02d/%02d', $m[1], $m[2], $m[3]);
    }

    private function relation($value): ?int
    {
        $digits = $this->digits($value);

        return $digits === null ? null : (int) $digits;
    }

    private function scrub(string $value): string
    {
        return strtr(preg_replace(self::INVISIBLES, ' ', $value) ?? $value, self::DIGITS);
    }

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

    /**
     * @param  array<string, mixed>  $row
     */
    private function skip(array $row, string $reason): void
    {
        $this->skipped[] = [
            'name' => (string) ($row['name'] ?? ''),
            'family' => (string) ($row['family'] ?? ''),
            'national_code' => (string) ($row['national_code'] ?? ''),
            'parent' => (string) ($row['parent'] ?? ''),
            'reason' => $reason,
        ];
    }
}
