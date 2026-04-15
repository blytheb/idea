<?php

use App\Models\Idea;
use App\Models\User;

it('creates a new idea', function () {
    $user=User::factory()->create();
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
        ->click('Create')
        ->assertPathIs('/ideas');

    expect($user->ideas()->first())->toMatchArray([
        'title'=> 'Some example title',
        'status' => 'completed',
        'description' => 'some example text',
        'links' => ['http://google.com', 'http://example.com']
    ]);

});
