<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class Shelf extends Model
{
    use HasUlids;
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'users' => AsCollection::class,
    ];

    public function setUserAttribute($user)
    {
        $this->addUser($user);
    }

    public function addUser($user)
    {
        if ($this->users === null) {
            $this->users = [];
        }

        $this->users = $this
            ->users
            ->push($user)
            ->unique();
    }

    public function removeUser($user)
    {
        if ($this->users === null) {
            $this->users = [];
        }

        $this->users = $this
            ->users
            ->diff($user);
    }

    public function getUrl()
    {
        return URL::signedRoute('shelf', [
            'shelf' => $this,
        ]);
    }
}
