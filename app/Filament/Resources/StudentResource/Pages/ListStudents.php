<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use App\Imports\ImportStudents;
use App\Models\Student;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\View\View;
use Excel;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListStudents extends ListRecords
{
    protected static string $resource = StudentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    function getHeader(): ?View
    {
        $data = Actions\CreateAction::make();
        return view('filament.resources.studentResource.upload-file-header', compact('data'));
    }

    public $file = '';

    function save() : void {
        if($this->file) {
            Excel::import(new ImportStudents, $this->file);
        }
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All Students'),
            'accept' => Tab::make('Accepted Students')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', "accept")),
            'off' => Tab::make('Off Students')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', "off")),
        ];
    }
}
