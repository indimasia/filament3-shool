<?php

namespace App\Livewire;

use App\Models\Student;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Livewire\Component;

class Home extends Component implements HasForms
{
    use InteractsWithForms;

    public $name = '';
    public $gender = '';
    public $birthday = '';
    public $religion = '';
    public $contact = '';
    public $profile;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
                TextInput::make("profile")
                    ->type('file')
                    ->extraAttributes(['class' => 'rounded'])
            ]);
    }

    public function render()
    {
        return view('livewire.home');
    }

    function save() : void {
        $data = $this->form->getState();

        if($this->profile) {
            $uploadedFile = $this->profile;
            $filename = time() . "_"  .$uploadedFile->getClientOriginalName();
            $path = $uploadedFile->storeAs('public/students', $filename);
            $data['profile'] = "students/".$filename;
        }

        // dd($data);
        Student::create($data);

        Notification::make()
            ->success()
            ->title("Murid {$this->name} Telah Mendaftar")
            ->sendToDatabase(User::role('admin')->get());

        $this->reset();

        session()->flash('message', 'Data berhasil disimpan.');
    }
}
