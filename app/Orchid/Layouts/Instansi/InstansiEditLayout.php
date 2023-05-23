<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Instansi;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class InstansiEditLayout extends Rows
{
    /**
     * The screen's layout elements.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [

            Input::make('i.nama')
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

        ];
    }
}
