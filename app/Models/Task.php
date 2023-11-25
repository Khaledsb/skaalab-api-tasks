<?php

namespace App\Models;

use App\Events\TaskUpdate;
use App\Jobs\DispatchUpdateTask;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\Jobs\Job;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'priority',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::updated(function (Task $model) {
            event(new TaskUpdate($model));
        });
    }
}
