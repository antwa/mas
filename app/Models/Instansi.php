<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use IteratorAggregate;
use Orchid\Access\UserInterface;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Filters\Types\WhereDateStartEnd;
use Orchid\Screen\AsSource;
use Orchid\Filters\Filterable;
class Instansi extends Model  implements UserInterface
{
    use HasFactory, AsSource,Filterable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table='instansi';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pub_id',
        'nama',
        'alamat',
        'kepala',
        'no_kepala',
        'website',
        'email',
        'telpon',
        'created_by',
        'updated_by',
    ];

    /**
     * Name of columns to which http sorting can be applied
     *
     * @var array
     */
    protected $allowedSorts = [
        'nama',
        'created_at',
        'updated_at',
        'created_by',
    ];

    /**
     * The attributes for which you can use filters in url.
     *
     * @var array
     */
    protected $allowedFilters = [
        'id'         => Where::class,
        'nama'       => Like::class,
        'nama_kepala'       => Like::class,
        'no_kepala'       => Like::class,
        'email'      => Like::class,
        'updated_at' => WhereDateStartEnd::class,
        'created_at' => WhereDateStartEnd::class,
    ];
    public function getRoles()
    {
        // TODO: Implement getRoles() method.
    }
}
