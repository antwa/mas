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
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class InstansiEditScreen extends Screen
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
        return 'Edit Data Instansi';
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
            Layout::block([
                InstansiEditLayout::class,
            ])
                ->title('Instansi')
                ->description('Manipulasi Data instansi'),

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
