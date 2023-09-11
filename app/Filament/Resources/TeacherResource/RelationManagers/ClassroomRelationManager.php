<?php

namespace App\Filament\Resources\TeacherResource\RelationManagers;

use App\Models\Classroom;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClassroomRelationManager extends RelationManager
{
    protected static string $relationship = 'classroom';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make("classroom_id")
                    ->label("Kelas")
                    ->relationship("classroom", "name")
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)->unique(Classroom::class, 'name')
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', \Str::slug($state))),
                        Hidden::make('slug'),
                    ])
                    ->createOptionAction(
                        fn (Action $action) => $action->modalHeading("Add Classroom")->modalButton("Add Classroom")->modalWidth('2xl'),
                    )
                    ->searchable(),
                Select::make("period_id")
                    ->label("Tahun Ajaran")
                    ->options(\App\Models\Period::all()->pluck('name', 'id'))
                    ->relationship("period", "name")
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)->unique(Classroom::class, 'name')
                    ])
                    ->createOptionAction(
                        fn (Action $action) => $action->modalHeading("Add Period")->modalButton("Add Period")->modalWidth('2xl'),
                    )
                    ->searchable(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('classroom.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('period.name')
                    ->searchable()
                    ->sortable(),
                ToggleColumn::make("is_open"),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
}
