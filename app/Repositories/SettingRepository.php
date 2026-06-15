<?php

declare(strict_types=1);

namespace App\Repositories;

class SettingRepository extends BaseRepository
{
    public function allGrouped(): array
    {
        $rows = $this->fetchAll('SELECT * FROM site_settings ORDER BY locale ASC, setting_key ASC');
        $settings = [];
        foreach ($rows as $row) {
            $settings[$row['locale']][$row['setting_key']] = $row['setting_value'];
        }

        $fallbackLocale = (string) config('app.locale', 'en');
        $fallback = $settings[$fallbackLocale] ?? [];
        foreach (array_keys(config('app.locales', [])) as $locale) {
            $settings[$locale] = array_merge($fallback, $settings[$locale] ?? []);
        }

        return $settings;
    }

    public function saveMany(array $payload): void
    {
        foreach ($payload as $locale => $items) {
            foreach ($items as $key => $value) {
                $this->execute(
                    'INSERT INTO site_settings (locale, setting_key, setting_value, updated_at)
                     VALUES (:locale, :setting_key, :setting_value, NOW())
                     ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value), updated_at = VALUES(updated_at)',
                    [
                        'locale' => $locale,
                        'setting_key' => $key,
                        'setting_value' => $value,
                    ]
                );
            }
        }
    }
}
