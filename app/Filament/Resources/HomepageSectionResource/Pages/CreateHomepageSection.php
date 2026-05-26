<?php

namespace App\Filament\Resources\HomepageSectionResource\Pages;

use App\Filament\Resources\HomepageSectionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateHomepageSection extends CreateRecord
{
    protected static string $resource = HomepageSectionResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['sort_order'] = (\App\Models\HomepageSection::max('sort_order') ?? 0) + 1;

        if (empty($data['title'])) {
            $data['title'] = preg_replace('/\s+/', '-', trim(mb_strtolower($data['title_fa'] ?? '')))
                ?: 'section-' . time();
        }

        return $data;
    }
}
