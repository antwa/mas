<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Instansi;

use App\Models\Instansi;
use App\Orchid\Layouts\Instansi\InstansiEditLayout;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Orchid\Platform\Models\Role;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class InstansiNewScreen extends Screen
{
    /**
     * @var $data
     */
    public $data;

    /**
     * Fetch data to be displayed on the screen.
     *
     *
     * @return array
     */
    public function query(Instansi $data): iterable
    {
        return [
            'data'       => $data
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'Tambah Data Instansi';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Manipulasi data instansi.';
    }

    public function permission(): ?iterable
    {
        return [
//            'platform.systems.roles',
        ];
    }

    /**
     * The screen's action buttons.
     *
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make(__('Save'))
                ->icon('bs.check-circle')
                ->method('save'),

            Button::make(__('Remove'))
                ->icon('bs.trash3')
                ->method('remove')
                ->canSee($this->data->exists),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return string[]|\Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [
            Layout::rows([


                Input::make('i.nama')
                    ->title('Nama')
                    ->required()
                    ->placeholder('Nama Instansi')
                    ->help('Nama Instansi yang akan dibuat.')
                    ->max(250)
                    ->required(),

                TextArea::make('i.alamat')
                    ->title('Alamat')
                    ->required()
                    ->rows(5)
                    ->placeholder('Alamat Instansi')
                    ->max(250)
                    ->help('Alamat Instansi yang akan dibuat.'),
                Group::make([

                    Input::make('i.kepala')
                        ->title('Nama Kepala')
                        ->required()
                        ->max(250)
                        ->placeholder('Masukan Nama Kepala instansi')
                        ->help('Nama Kepala Instansi yang akan dibuat.'),
                    Input::make('i.no_kepala')
                        ->title('NIP')
                        ->max(250)
                        ->placeholder('Masukan NIP kepala instansi')
                        ->help('NIP Kepala Instansi yang akan dibuat.'),

                ]),
                Group::make([

                    Input::make('i.website')
                        ->title('Website')
                        ->max(250)
                        ->required()
                        ->type('url')
                        ->placeholder('Masukan Alamat Website')
                        ->help('Website Instansi yang akan dibuat.'),
                    Input::make('i.email')
                        ->title('Email')
                        ->max(250)
                        ->required()
                        ->type('email')
                        ->placeholder('Masukan email instansi')
                        ->help('Email Instansi yang akan dibuat.'),
                    Input::make('i.telpon')
                        ->title('Telepon')
                        ->max(250)
                        ->required()
                        ->mask('(999) 999-9999')
                        ->type('number')
                        ->placeholder('Masukan nomor telpon instansi')
                        ->help('NIP Kepala Instansi yang akan dibuat.'),


                ]),


            ]),


        ];
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request, Role $role)
    {
        $request->validate([
            'role.slug' => [
                'required',
                Rule::unique(Role::class, 'slug')->ignore($role),
            ],
        ]);

        $role->fill($request->get('role'));

        $role->permissions = collect($request->get('permissions'))
            ->map(fn ($value, $key) => [base64_decode($key) => $value])
            ->collapse()
            ->toArray();

        $role->save();

        Toast::info(__('Role was saved'));

        return redirect()->route('platform.systems.roles');
    }

    /**
     * @throws \Exception
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Role $role)
    {
        $role->delete();

        Toast::info(__('Role was removed'));

        return redirect()->route('platform.systems.roles');
    }
}
