<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Instansi;

use App\Models\Instansi;
use App\Orchid\Layouts\Instansi\InstansiEditLayout;
use App\Orchid\Layouts\Instansi\InstansiListLayout;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Orchid\Platform\Models\User;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class InstansiListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'data' =>  Instansi::defaultSort('id', 'desc')
                ->paginate()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'Instansi';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Menajemen data instansi.';
    }

    public function permission(): ?iterable
    {
        return [];
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make(__('Add'))
                ->icon('bs.plus-circle')
                ->route('platform.data.instansi.create'),
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
           InstansiListLayout::class,

            Layout::modal('asyncEditModal', InstansiEditLayout::class)
                ->async('asyncGetData'),
        ];
    }

    /**
     * @return array
     */
    public function asyncGeData(Instansi $data): iterable
    {
        return [
            'data' => $data,
        ];
    }

    public function save(Request $request, Instansi $data): void
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
        Toast::info(__('Data was saved.'));
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
