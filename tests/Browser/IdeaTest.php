<?php

use App\Models\Idea;
use App\Models\User;

it('creates a new idea', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    visit('/ideas')
        ->click('@create-idea-btn')
        ->fill('title', 'Some example title')
        ->click('@btn-status-completed')
        ->fill('description', 'some example text')
        ->fill('new-link', 'http://google.com')
        ->click('@submit-new-link-btn')
        ->fill('new-link', 'http://example.com')
        ->click('@submit-new-link-btn')
        ->fill('new-step', 'do a thing')
        ->click('@submit-new-step-btn')
        ->fill('new-step', 'do it again')
        ->click('@submit-new-step-btn')
        ->click('Create')
        ->assertPathIs('/ideas');

    expect($idea = $user->ideas()->first())->toMatchArray([
        'title' => 'Some example title',
        'status' => 'completed',
        'description' => 'some example text',
        'links' => ['http://google.com', 'http://example.com'],
    ]);

    expect($idea->steps)->toHaveCount(2);

});

it('edits an existing idea', function () {
    $this->actingAs($user = User::factory()->create());

    $idea = Idea::factory()->for($user)->create();

    visit(route('idea.show', $idea))
        ->click('@edit-idea-btn')
        ->fill('title', 'Some example title')
        ->click('@btn-status-completed')
        ->fill('description', 'some example text')
        ->fill('new-link', 'http://google.com')
        ->click('@submit-new-link-btn')
        ->fill('new-link', 'http://example.com')
        ->click('@submit-new-link-btn')
        ->fill('new-step', 'do a thing')
        ->click('@submit-new-step-btn')
        ->fill('new-step', 'do it again')
        ->click('@submit-new-step-btn')
        ->click('Create')
        ->assertPathIs('/ideas');

    expect($idea = $user->ideas()->first())->toMatchArray([
        'title' => 'Some example title',
        'status' => 'completed',
        'description' => 'some example text',
        'links' => ['http://google.com', 'http://example.com'],
    ]);

    expect($idea->steps)->toHaveCount(2);

});
