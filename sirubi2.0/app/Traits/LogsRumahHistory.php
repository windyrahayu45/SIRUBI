<?php

namespace App\Traits;

use App\Models\RumahHistory;
use Illuminate\Support\Facades\Auth;

trait LogsRumahHistory
{
    /**
     * Mencatat perubahan pada data rumah (single field)
     */
    public function logHistory($rumahId, $kategori, $field, $oldValue, $newValue)
    {
        // Jika tidak ada perubahan → abaikan
        if ($oldValue == $newValue) {
            return;
        }

        RumahHistory::create([
            'rumah_id'   => $rumahId,
            'kategori'   => $kategori,
            'field'      => $field,
            'old_value'  => $oldValue,
            'new_value'  => $newValue,
            'changed_by' => Auth()->user()->id,
            'changed_at' => now(),
        ]);
    }

    /**
 * Log perubahan nested array menjadi per-field
 */
public function logArrayChanges($rumahId, $kategori, $oldData, $newData, $prefix = '')
{
    foreach ($newData as $key => $newValue) {

        $fullKey = $prefix === '' ? $key : $prefix . '.' . $key;
        $oldValue = $oldData[$key] ?? null;

        // Jika value berupa array → masuk rekursif
        if (is_array($newValue)) {
            $this->logArrayChanges($rumahId, $kategori, $oldValue ?? [], $newValue, $fullKey);
            continue;
        }

        // Jika tidak ada perubahan → skip
        if ($oldValue == $newValue) continue;

        // Simpan perubahan (old_value dan new_value bukan JSON)
        RumahHistory::create([
            'rumah_id'   => $rumahId,
            'kategori'   => $kategori,
            'field'      => $fullKey,
            'old_value'  => $oldValue,
            'new_value'  => $newValue,
            'changed_by' => auth()->user()->id,
            'changed_at' => now(),
        ]);
    }
}



    /**
     * Mencatat perubahan otomatis untuk banyak field sekaligus
     * $oldData = model ->toArray()
     * $newData = data baru array
     */
    public function logMultiple($rumahId, $kategori, $oldData, $newData)
    {
        foreach ($newData as $field => $newValue) {
            $oldValue = $oldData[$field] ?? null;

            if ($oldValue != $newValue) {
                $this->logHistory($rumahId, $kategori, $field, $oldValue, $newValue);
            }
        }
    }
}
