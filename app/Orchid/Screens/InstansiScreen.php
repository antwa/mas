<?php

namespace App\Orchid\Screens;

use App\Models\Instansi;
use App\Orchid\Layouts\Instansi\InstansiListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class InstansiScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'instansi' =>  Instansi::defaultSort('id', 'desc')->paginate(),

        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Instansi';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Menajemen data instansi";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Tambah Instansi')
                ->modal('instansiModal')
                ->method('create')
                ->icon('plus'),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            InstansiListLayout::class,
            Layout::modal('instansiModal', Layout::rows([

                Input::make('i.nama')
                    ->required()
                    ->title('Nama')
                    ->placeholder('Nama Instansi')
//                    ->popover('Masukan Nama Instansi')
                    ->help('Nama Instansi yang akan dibuat.'),
                TextArea::make('i.alamat')
                    ->title('Alamat')
                    ->required()
                    ->rows(5)
                    ->placeholder('Alamat Instansi')
                    ->help('Alamat Instansi yang akan dibuat.'),
                Input::make('i.kepala')
                    ->title('Nama Kepala')
                    ->required()
                    ->placeholder('Masukan Nama Kepala instansi')
                    ->help('Nama Kepala Instansi yang akan dibuat.'),
                Input::make('i.no_kepala')
                    ->title('NIP')
                    ->placeholder('Masukan NIP kepala instansi')
                    ->help('NIP Kepala Instansi yang akan dibuat.'),

                    Input::make('i.website')
                        ->title('Website')
                        ->required()
                        ->type('url')
                        ->placeholder('Masukan Alamat Website')
                        ->help('Website Instansi yang akan dibuat.'),
                    Input::make('i.email')
                        ->title('Email')
                        ->required()
                        ->type('email')
                        ->placeholder('Masukan email instansi')
                        ->help('Email Instansi yang akan dibuat.'),
                    Input::make('i.telpon')
                        ->title('Telepon')
                        ->required()
                        ->mask('(999) 999-9999')
                        ->type('number')
                        ->placeholder('Masukan nomor telpon instansi')
                        ->help('NIP Kepala Instansi yang akan dibuat.'),
            ]))
                ->title('Tambah Instansi')
                ->applyButton('Simpan'),

        ];
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function create(Request $request)
    {
        $request->validate([
            'i.nama' => 'required|max:250',
            'i.alamat' => 'required',
            'i.kepala' => 'required|max:255',
            'i.no_kepala' => 'max:255',
            'i.website' => 'required|max:255',
            'i.email' => 'required|max:255',
            'i.telpon' => 'required|max:255',
        ]);

        $model = new Instansi();

        $model->nama = $request->input('i.nama');
        $model->alamat = $request->input('i.alamat');
        $model->kepala = $request->input('i.kepala');
        $model->no_kepala = $request->input('i.no_kepala');
        $model->website = $request->input('i.website');
        $model->email = $request->input('i.email');
        $model->telpon = $request->input('i.telpon');
        $model->created_by = auth()->id();
        $model->updated_by = auth()->id();
        $model->pub_id = \Illuminate\Support\Str::uuid();
        $model->save();
    }

    /**
     * remove instansi
     *
     * @param Request $request
     */
    public function remove(Request $request): void
    {
        Instansi::where('pub_id',$request->get('id'))->firstOrFail()->delete();
        Toast::info(__('Data was removed'));
    }
}
