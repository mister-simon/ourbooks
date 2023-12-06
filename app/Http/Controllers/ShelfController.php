<?php

namespace App\Http\Controllers;

use App\Models\Shelf;
use App\Scopes\OrderByTitle;
use App\Scopes\ShelfBookCount;
use Illuminate\Support\Facades\Auth;

class ShelfController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Shelf::class);

        $user = Auth::user();

        $shelves = $user
            ->shelves()
            ->tap(new OrderByTitle)
            ->tap(new ShelfBookCount)
            ->with(['users' => fn ($query) => $query->select('name', 'profile_photo_path')])
            ->get();

        $invites = $user
            ->invites()
            ->with(['shelf' => fn ($query) => $query->tap(new ShelfBookCount)])
            ->get();

        $shelfAuthorCounts = Shelf::getShelfAuthors([
            ...$shelves->modelKeys(),
            ...$invites->pluck('shelf_id')->all(),
        ]);

        return view('shelves.index', [
            'shelves' => $shelves,
            'invites' => $invites,
            'authorCounts' => $shelfAuthorCounts,
        ]);
    }
}
