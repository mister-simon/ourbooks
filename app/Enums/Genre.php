<?php

namespace App\Enums;

enum Genre: string
{
    case ActionAdventure = 'Action Adventure';
    case Anthology = 'Anthology';
    case Art = 'Art';
    case Autobiography = 'Autobiography';
    case Biography = 'Biography';
    case Childrens = "Children's";
    case Classic = 'Classic';
    case ComicGraphicNovel = 'Comic / Graphic Novel';
    case ComingOfAgeFiction = 'Coming-of-Age Fiction';
    case CookBook = 'Cook book';
    case Dictionary = 'Dictionary';
    case Drama = 'Drama';
    case Fantasy = 'Fantasy';
    case Fiction = 'Fiction';
    case GothicFiction = 'Gothic Fiction';
    case Health = 'Health';
    case HistoricalFiction = 'Historical Fiction';
    case History = 'History';
    case Horror = 'Horror';
    case Humour = 'Humour';
    case Manga = 'Manga';
    case Mystery = 'Mystery';
    case NonFiction = 'Non-Fiction';
    case Play = 'Play';
    case Poetry = 'Poetry';
    case PsychologicalFiction = 'Psychological Fiction';
    case ReligiousText = 'Religious Text';
    case Reference = 'Reference';
    case Romance = 'Romance';
    case Satire = 'Satire';
    case SciFi = 'Sci-fi';
    case Science = 'Science';
    case SelfHelp = 'Self Help';
    case Thriller = 'Thriller';
    case Travel = 'Travel';
    case YaDystopia = 'YA Dystopia';
    case YaFiction = 'YA Fiction';

    public static function select()
    {
        return collect(self::cases())
            ->keyBy('value')
            ->map(fn (Genre $genre) => __($genre->value))
            ->sort();
    }
}
