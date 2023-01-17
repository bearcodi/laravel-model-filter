<?php

use Carbon\Carbon;
use Lacodix\LaravelModelFilter\Enums\SearchMode;
use function Pest\Faker\faker;
use Tests\Models\Post;

beforeEach(function () {
    Post::factory()
        ->state([
            'title' => 'no '.faker()->words(4, true).' test',
        ])
        ->create();

    Post::factory()
        ->state([
            'title' => 'no '.faker()->words(2, true).' test '.faker()->words(2, true).' no',
        ])
        ->create();

    Post::factory()
        ->state([
            'title' => 'test '.faker()->words(4, true).' no',
        ])
        ->create();

    Post::factory()
        ->state([
            'title' => 'test',
        ])
        ->create();

    Post::factory()
        ->state([
            'content' => 'no '.faker()->words(4, true).' test',
        ])
        ->create();

    Post::factory()
        ->state([
            'content' => 'no '.faker()->words(2, true).' test '.faker()->words(2, true).' no',
        ])
        ->create();

    Post::factory()
        ->state([
            'content' => 'test '.faker()->words(4, true).' no',
        ])
        ->create();

    Post::factory()
        ->state([
            'content' => 'test',
        ])
        ->create();
});

it('can be found by search for multiple value', function () {
    expect(Post::search('test')->count())->toEqual(8);
});

it('can be found by search for overwritten fields', function () {
    expect(Post::search('test', ['title'])->count())->toEqual(4);
});

it('can be found by search for overwritten modes', function () {
    expect(Post::search('test', [
        'title' => SearchMode::EQUAL,
        'content' => SearchMode::LIKE
    ])
        ->count())->toEqual(5)
        ->and(Post::search('test', [
            'title' => SearchMode::EQUAL,
            'content' => SearchMode::EQUAL
        ])
        ->count())->toEqual(2)
        ->and(Post::search('test', [
            'title' => SearchMode::STARTS_WITH,
            'content' => SearchMode::ENDS_WITH
        ])->count())->toEqual(4);
});
