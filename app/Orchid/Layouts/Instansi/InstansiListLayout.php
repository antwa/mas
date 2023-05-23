<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Instansi;


use App\Models\Instansi;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class InstansiListLayout extends Table
{
    /**
     * @var string
     */
    public $target = 'data';

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [

            TD::make('nama', __('nama'))
                ->sort()
                ->cantHide()
                ->filter(Input::make()),

            TD::make('alamat', __('Alamat'))
                ->sort()
                ->filter(Input::make()),
            TD::make('kepala', __('Kepala'))
                ->sort()
                ->filter(Input::make()),
            TD::make('no_kepala', __('NIP'))
                ->sort()
                ->filter(Input::make()),

            TD::make('email', __('Email'))
                ->sort()
//                ->cantHide()
                ->filter(Input::make()),
            TD::make('website', __('Website'))
                ->sort()
                ->filter(Input::make()),
            TD::make('telpon', __('Telepon'))
                ->sort()
                ->filter(Input::make()),

            TD::make('updated_at', __('Last edit'))
                ->sort(),
            TD::make('created_at', __('Created at'))
                ->sort(),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (Instansi $data) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([
                        Link::make(__('Edit'))
                            ->route('platform.data.instansi.edit', $data->pub_id)
                            ->icon('bs.pencil'),
                        Button::make(__('Delete'))
                            ->icon('bs.trash3')
                            ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                            ->method('remove', [
                                'id' => $data->pub_id,
                            ]),
                    ])),
        ];
    }
}
