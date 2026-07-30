<?php

namespace App\Traits;

trait HasTranslations
{
    public function getAttribute($key)
    {
        if (in_array($key, $this->translatable ?? [])) {
            return $this->getTranslation($key, app()->getLocale());
        }
        return parent::getAttribute($key);
    }

    public function getTranslation(string $key, string $locale)
    {
        $value = $this->attributes[$key] ?? null;
        if (!$value) return null;

        $translations = json_decode($value, true);
        return $translations[$locale] ?? $translations[config('app.fallback_locale')] ?? null;
    }

    public function setTranslation(string $key, array $translations): self
    {
        $this->attributes[$key] = json_encode($translations);
        return $this;
    }

    public function getAllTranslations(string $key): array
    {
        return json_decode($this->attributes[$key] ?? '{}', true) ?: [];
    }
}
