<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use NunoMaduro\Collision\Adapters\Phpunit\State;
use stdClass;
use Filament\Infolists\Components;
use Filament\Infolists\Components\Fieldset;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nis')
                    ->label('NIS'),
                TextInput::make('name')
                    ->label('Nama Siswa'),
                Select::make("gender")
                    ->label("Jenis Kelamin")
                    ->options([
                        'Male' => "Male",
                        "Female" => "Female"
                    ]),
                DatePicker::make("birthday")
                    ->label("Tanggal Lahir"),
                Select::make("religion")
                    ->label("Agama")
                    ->options([
                        'Islam' => "Islam",
                        "Katolik" => "Katolik",
                        "Protestan" => "Protestan",
                        "Hindu" => "Hindu",
                        "Buddha" => "Buddha",
                        "Khonghucu" => "Khonghucu"
                    ]),
                TextInput::make("contact")
                    ->label("Kontak"),
                FileUpload::make("profile")
                    ->label("Foto Siswa")
                    ->directory('students')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('No')->state(
                    static function (HasTable $livewire, stdClass $rowLoop): string {
                        return (string) (
                            $rowLoop->iteration +
                            ($livewire->getTableRecordsPerPage() * (
                                $livewire->getTablePage() - 1
                            ))
                        );
                    }
                ),                
                TextColumn::make('nis')
                    ->label('NIS'),
                TextColumn::make('name')
                    ->label('Nama Siswa'),
                TextColumn::make("gender")
                    ->toggleable(isToggledHiddenByDefault:true)
                    ->label("Jenis Kelamin"),
                TextColumn::make("birthday")
                    ->toggleable(isToggledHiddenByDefault:true)
                    ->label("Tanggal Lahir"),
                TextColumn::make("religion")
                    ->label("Agama"),
                TextColumn::make("contact")
                    ->label("Kontak"),
                Tables\Columns\ImageColumn::make('profile')
                    ->label('Foto Siswa'),
                TextColumn::make('status')
                    ->toggleable(isToggledHiddenByDefault:true)
                    ->label('Status')
                    ->formatStateUsing(fn(string $state): string => ucwords("{$state}")),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    BulkAction::make("Change Status")
                        ->icon("heroicon-o-check-circle")
                        ->requiresConfirmation()
                        ->form([
                            Select::make("status")
                                ->label("Status")
                                ->options([
                                    'accept' => "Accept",
                                    "off" => "Off",
                                    "move" => "Move",
                                    "grade" => "Grade"
                                ])
                                ->required(),
                        ])
                        ->action(fn (Collection $records, array $data) => $records->each->update(['status' => $data['status']])),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
            'view' => Pages\ViewStudent::route('/{record}'),
        ];
    }    

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Components\Section::make()
                    ->schema([
                        Fieldset::make('Biodata')
                            ->schema([
                                Components\Split::make([
                                    Components\ImageEntry::make('profile')
                                        ->hiddenLabel()
                                        ->grow(false),
                                    Components\Grid::make(2)
                                        ->schema([
                                            Components\Group::make([
                                                Components\TextEntry::make('nis'),
                                                Components\TextEntry::make('name'),
                                                Components\TextEntry::make('gender'),
                                                Components\TextEntry::make('birthday'),

                                            ])
                                            ->inlineLabel()
                                            ->columns(1),

                                            Components\Group::make([
                                                Components\TextEntry::make('religion'),
                                                Components\TextEntry::make('contact'),
                                                Components\TextEntry::make('status')
                                                ->badge()
                                                ->color(fn (string $state): string => match ($state) {
                                                    'accept' => 'success',
                                                    'off' => 'danger',
                                                    'grade' => 'success',
                                                    'move' => 'warning',
                                                    'wait' => 'gray'
                                                }),
                                                Components\ViewEntry::make('QRCode')
                                                ->view('filament.resources.student-resource.qrcode'),
                                            ])
                                            ->inlineLabel()
                                            ->columns(1),
                                    ])

                                ])->from('lg')
                            ])->columns(1)
                    ])->columns(2)
            ]);
    }
}
