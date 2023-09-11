<?php

namespace App\Filament\Resources\StudentClassResource\Pages;

use App\Filament\Resources\StudentClassResource;
use App\Models\HomeRoom;
use App\Models\Period;
use App\Models\Student;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Resources\Pages\Page;
use Livewire\Features\SupportRedirects\Redirector;

class FormStudentClass extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = StudentClassResource::class;

    protected static string $view = 'filament.resources.student-class-resource.pages.form-student-class';

    public $students = [];
    public $homerooms = '';
    public $periode = '';

    function mount() : void {
        $this->form->fill();
    }

    // function getFormSchema(): array
    // {
    //     return $form
    //         ->schema([

    //         ])->columns(3);
    // }

    function form(Form $form) : Form {
        return $form
            ->schema([
                Select::make("students")
                    ->label("Student")
                    ->multiple()
                    ->searchable()
                    ->options(Student::all()->pluck('name', 'id')),
                Select::make("homerooms")
                    ->label("Class")
                    ->searchable()
                    ->options(HomeRoom::all()->pluck('classroom.name', 'id')),
                Select::make("periode")
                    ->label("Periode")
                    ->searchable()
                    ->options(Period::all()->pluck('name', 'id'))
            ])->columns(3);
    }

    function save() : \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse {
        $students = $this->students;
        $insert = [];
        foreach($students as $student) {
            $insert[] = [
                'student_id' => $student,
                'home_room_id' => $this->homerooms,
                'period_id' => $this->periode,
                'is_open' => 1,
            ];
        }

        StudentClassResource::getModel()::insert($insert);
        return redirect()->to('admin/student-classes');
    }
}
