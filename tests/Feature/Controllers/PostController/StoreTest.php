<?php

use App\Models\Post;
use App\Models\Topic;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\post;

beforeEach(function () {
    $this->validData = fn () => [
        'title' => 'Hello World',
        'topic_id' => Topic::factory()->create()->getKey(),
        'body' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Sequi veritatis quam, officia sapiente minus, quis dolore est inventore culpa ab animi odit voluptatibus? Animi alias tempora est voluptatibus, aliquam voluptatum ea dolor maxime impedit, iure consectetur cupiditate maiores delectus laudantium, pariatur expedita nostrum enim esse non ut laboriosam accusamus magni. Cumque consectetur fuga ex quod, totam fugiat quaerat perferendis natus sed animi vitae eius alias ducimus rerum placeat laborum hic, cum aliquam pariatur. Adipisci sed fugiat illum voluptas. Laboriosam consequuntur magni magnam incidunt, sequi mollitia labore. Commodi excepturi laborum quaerat est aliquam modi et, ea nesciunt, eaque accusamus quia officiis.'
    ];
});

it('requires authentication', function () {
    post(route('posts.store'))->assertRedirect(route('login'));
});

it('stores a post', function () {
    $user = User::factory()->create();
    $data = value($this->validData);

    actingAs($user)
        ->post(route('posts.store'), $data);

    assertDatabaseHas(Post::class, [
        ...$data,
        'user_id' => $user->id
    ]);
});

it('redirects to the post show page', function () {
    actingAs(User::factory()->create())
        ->post(route('posts.store'), value($this->validData))
        ->assertRedirect(Post::latest('id')->first()->showRoute());
});

it('requires valid data', function (array $badData, array|string $errors) {
    $user = User::factory()->create();

    actingAs($user)
        ->post(route('posts.store'), [...value($this->validData), ...$badData])
        ->assertInvalid($errors);
})->with([
    [['title' => null], 'title'],
    [['title' => true], 'title'],
    [['title' => 1], 'title'],
    [['title' => 1.5], 'title'],
    [['title' => str_repeat('a', 121)], 'title'],
    [['title' => str_repeat('a', 9)], 'title'],
    [['topic_id' => null], 'topic_id'],
    [['topic_id' => -1], 'topic_id'],
    [['body' => null], 'body'],
    [['body' => true], 'body'],
    [['body' => 1], 'body'],
    [['body' => 1.5], 'body'],
    [['body' => str_repeat('a', 10_001)], 'body'],
    [['body' => str_repeat('a', 99)], 'body'],
]);
