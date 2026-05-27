<?php

namespace App\Filament\Pages;

use App\Models\ArtistApplicationField;
use Filament\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

class ArtistApplicationSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static string|\UnitEnum|null $navigationGroup = 'مدیریت';
    protected static ?string $title = 'فیلدهای فرم هنرمند';
    protected static ?string $navigationLabel = 'فرم درخواست هنرمند';
    protected static ?string $slug = 'artist-application-settings';
    protected static ?int $navigationSort = 6;

    public array $data = [];

    public function mount(): void
    {
        $fields = ArtistApplicationField::orderBy('sort_order')->get()->map(fn($f) => [
            'key'         => $f->key,
            'label'       => $f->label,
            'type'        => $f->type,
            'options'     => $f->options ? implode("\n", $f->options) : '',
            'required'    => $f->required,
            'is_active'   => $f->is_active,
            'sort_order'  => $f->sort_order,
            'placeholder' => $f->placeholder,
            'help_text'   => $f->help_text,
        ])->toArray();

        $this->form->fill(['fields' => $fields]);
    }

    public function form(Schema $form): Schema
    {
        return $form->statePath('data')->schema([
            Section::make('فیلدهای فرم درخواست هنرمند')
                ->description('ترتیب فیلدها را با sort_order تنظیم کنید. فیلدهای غیرفعال در فرم کاربر نمایش داده نمی‌شوند.')
                ->schema([
                    Repeater::make('fields')
                        ->label('')
                        ->schema([
                            TextInput::make('key')
                                ->label('کلید داخلی (انگلیسی، بدون فاصله)')
                                ->required()
                                ->placeholder('مثال: stage_name')
                                ->helperText('فقط حروف انگلیسی و _'),
                            TextInput::make('label')
                                ->label('عنوان فارسی')
                                ->required()
                                ->placeholder('مثال: نام هنری'),
                            Select::make('type')
                                ->label('نوع فیلد')
                                ->options(ArtistApplicationField::$types)
                                ->required()
                                ->live(),
                            Textarea::make('options')
                                ->label('گزینه‌ها (برای select — هر گزینه در یک خط)')
                                ->rows(3)
                                ->placeholder("گزینه اول\nگزینه دوم\nگزینه سوم")
                                ->visible(fn($get) => $get('type') === 'select'),
                            TextInput::make('placeholder')
                                ->label('راهنمای ورودی (placeholder)'),
                            TextInput::make('help_text')
                                ->label('متن راهنما زیر فیلد'),
                            TextInput::make('sort_order')
                                ->label('ترتیب نمایش')
                                ->numeric()
                                ->default(0),
                            Toggle::make('required')
                                ->label('اجباری')
                                ->default(true),
                            Toggle::make('is_active')
                                ->label('فعال')
                                ->default(true),
                        ])
                        ->columns(2)
                        ->collapsible()
                        ->itemLabel(fn(array $state) => $state['label'] ?? 'فیلد جدید')
                        ->addActionLabel('+ افزودن فیلد جدید')
                        ->reorderable('sort_order'),
                ]),
        ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        // حذف همه فیلدهای قبلی و جایگزینی
        ArtistApplicationField::truncate();

        foreach ($data['fields'] as $i => $fieldData) {
            $options = null;
            if ($fieldData['type'] === 'select' && !empty($fieldData['options'])) {
                $options = array_filter(array_map('trim', explode("\n", $fieldData['options'])));
                $options = array_values($options);
            }

            ArtistApplicationField::create([
                'key'         => $fieldData['key'],
                'label'       => $fieldData['label'],
                'type'        => $fieldData['type'],
                'options'     => $options,
                'required'    => $fieldData['required'] ?? false,
                'is_active'   => $fieldData['is_active'] ?? true,
                'sort_order'  => $fieldData['sort_order'] ?? $i,
                'placeholder' => $fieldData['placeholder'] ?? null,
                'help_text'   => $fieldData['help_text'] ?? null,
            ]);
        }

        Notification::make()
            ->title('فیلدهای فرم با موفقیت ذخیره شدند ✅')
            ->success()
            ->send();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('ذخیره فیلدها')
                ->icon('heroicon-o-check')
                ->color('success')
                ->action('save'),
            Action::make('preview')
                ->label('پیش‌نمایش فرم')
                ->icon('heroicon-o-eye')
                ->url(route('artist-application.show'))
                ->openUrlInNewTab()
                ->color('gray'),
        ];
    }

    public function getView(): string
    {
        return 'filament.pages.artist-application-settings';
    }
}
