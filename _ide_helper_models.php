<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Book
 *
 * @property string $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $title
 * @property string|null $series
 * @property int|null $series_index
 * @property string|null $author_surname
 * @property string|null $author_forename
 * @property string|null $co_author
 * @property string|null $genre
 * @property string|null $edition
 * @property string $shelf_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BookUser> $bookUsers
 * @property-read int|null $book_users_count
 * @property-read mixed $author_name
 * @property-read mixed $author_surname_char
 * @property-read mixed $book_user_avg_rating
 * @property-read mixed $integer_hash
 * @property-read mixed $series_text
 * @property-read mixed $was_read
 * @property-read \App\Models\Shelf $shelf
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Database\Factories\BookFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Book newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Book newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Book query()
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereAuthorForename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereAuthorSurname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereCoAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereEdition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereGenre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereSeries($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereSeriesIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereShelfId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereUpdatedAt($value)
 */
	class Book extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BookUser
 *
 * @property string $book_id
 * @property string $user_id
 * @property \App\Enums\ReadStatus|null $read
 * @property string|null $rating
 * @property string|null $comments
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Book $book
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\BookUserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|BookUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BookUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BookUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|BookUser whereBookId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookUser whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookUser whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookUser whereRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookUser whereUserId($value)
 */
	class BookUser extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Shelf
 *
 * @property string $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $title
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Book> $books
 * @property-read int|null $books_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Database\Factories\ShelfFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Shelf newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Shelf newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Shelf query()
 * @method static \Illuminate\Database\Eloquent\Builder|Shelf whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shelf whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shelf whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shelf whereUpdatedAt($value)
 */
	class Shelf extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property string $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string|null $two_factor_confirmed_at
 * @property string|null $remember_token
 * @property int|null $current_team_id
 * @property string|null $profile_photo_path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BookUser> $bookUsers
 * @property-read int|null $book_users_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Book> $books
 * @property-read int|null $books_count
 * @property-read mixed $readable
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read string $profile_photo_url
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Shelf> $shelves
 * @property-read int|null $shelves_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCurrentTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProfilePhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorConfirmedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

