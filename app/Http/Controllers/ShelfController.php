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
            ->get();

        $invites = $user
            ->invites()
            ->with(['shelf' => fn ($query) => $query->tap(new ShelfBookCount)])
            ->get();

        $shelfAuthorCounts = Shelf::getShelfAuthors([...$shelves->modelKeys(), ...$invites->pluck('shelf_id')->all()]);

        return view('shelves.index', [
            'shelves' => $shelves,
            'invites' => $invites,
            'authorCounts' => $shelfAuthorCounts,
        ]);
    }

    public function show(Shelf $shelf)
    {
        $this->authorize('view', $shelf);

        $books = $shelf
            ->books()
            ->orderBy('author_surname')
            ->orderBy('author_forename')
            ->orderBy('series')
            ->orderBy('series_index')
            ->orderBy('title')
            ->with('bookUsers.user')
            ->get();

        return view('shelves.show', [
            'shelf' => $shelf,
            'books' => $books,
        ]);
    }
}
