<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ImageResource\RelationManagers\ImagesRelationManager;
use App\Filament\Resources\SpecialtyResource\Pages;
use App\Filament\Resources\SpecialtyResource\RelationManagers;
use App\Filament\Resources\SpecialtyResource\RelationManagers\SurgeriesRelationManager;
use App\Models\Specialty;
use App\Models\Surgery;
use Filament\Forms;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SpecialtyResource extends Resource
{
    protected static ?string $model = Specialty::class;
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $navigationGroup  = 'Dashboard';
    public static ?string $label = 'Especialidad';
    protected static ?string $pluralModelLabel  = 'Especialidades';
    protected static ?string $navigationIcon = 'heroicon-o-star';

    protected static ?int $navigationSort = 1;

    public static function formPlaceholderDate()
    {
        return Forms\Components\Section::make()
            ->columnSpan(1)
            ->schema([
                Forms\Components\Placeholder::make('created_at')
                    ->label('Fecha de creacion')
                    ->content(
                        fn ($record): ?string =>
                        $record->created_at->translatedFormat('M j, Y h:i a') . ' (' . $record->created_at?->diffForHumans() . ')'
                    ),

                Forms\Components\Placeholder::make('updated_at')
                    ->label('Ultima modificacion')
                    ->content(
                        fn ($record): ?string =>
                        $record->created_at->translatedFormat('M j, Y h:i a') . ' (' . $record->created_at?->diffForHumans() . ')'
                    ),

            ])->hidden(fn ($record) => $record === null);
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                self::formPlaceholderDate(),
                Forms\Components\Section::make()
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')->required()->maxLength(255)->label('Titulo')->columnSpan(3),
                        Forms\Components\TextInput::make('slug')->required()->maxLength(255)->label('Url')->columnSpan(3)
                            ->prefix(url('/specialty') . '/')
                            ->suffix('.com'),

                        Forms\Components\Textarea::make('entry')->required()->maxLength(255)->label('Pequeña descripcion'),
                        Forms\Components\Toggle::make('active')->inline(false)->label('Visible'),
                        Forms\Components\Fieldset::make('Metadata')
                            ->relationship('meta')
                            ->schema([
                                Forms\Components\TextInput::make('title')->label('Titulo'),
                                Forms\Components\Textarea::make('desc')->label('Descripcion'),
                                Forms\Components\Textarea::make('extra')->label('Extra metadata')->columnSpan(2),

                            ]),
                        Forms\Components\FileUpload::make('image')->directory('/img/specialties')
                            ->image()
                            ->maxSize(1024)
                            ->label('Imagen')
                            ->columnSpan(3),
                        Forms\Components\FileUpload::make('thumb')
                            ->directory('/img/specialties')
                            ->image()
                            ->maxSize(1024)
                            ->label('Imagen')
                            ->columnSpan(3),

                        Forms\Components\RichEditor::make('description')->disableToolbarButtons([
                            'attachFiles',
                            'strike',
                        ])->columnSpanFull()->label('Descripcion amplia'),

                    ])




            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                ImageColumn::make('image')
                    ->label('Imagen')
                    ->checkFileExistence(false),

                TextColumn::make('name')
                    ->color('primary')
                    ->weight(FontWeight::Medium)
                    ->url(fn (Specialty $record): string => route('specialty', $record->slug))
                    ->openUrlInNewTab()
                    ->description(fn (Specialty $record): string => $record->slug)->label('Nombre Url'),

                TextColumn::make('surgeries.name')
                    ->label('Cirugias')
                    ->badge()
                    ->color('info'),

                TextColumn::make('doctors.name')
                    ->label('Doctores')
                    ->badge()
                    ->color('success'),

                IconColumn::make('active')->label('activo')->boolean(),

                TextColumn::make('created_at')
                    ->label('Modificado')
                    ->since(),

            ])
            ->filters([
                //
            ])

            ->actions([
                Tables\Actions\EditAction::make()->icon(null)->color('info'),
                Tables\Actions\DeleteAction::make()->icon(null),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])->defaultSort('id', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            ImagesRelationManager::class,
            RelationManagers\SurgeriesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSpecialties::route('/'),
            'create' => Pages\CreateSpecialty::route('/create'),
            'edit' => Pages\EditSpecialty::route('/{record}/edit'),
        ];
    }
}
