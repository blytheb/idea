<?php

use App\Models\User;
use App\Notifications\EmailChanged;
use Illuminate\Support\Facades\Notification;

it('requires authentication', function () {
    $this->get(route('profile.edit'))->assertRedirect('/login');
});

it('edits a profile', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    visit(route('profile.edit'))
        ->assertValue('name', $user->name)
        ->fill('name', 'New Name')
        ->assertValue('email', $user->email)
        ->fill('email', 'new@email.com')
        ->click('Update Account')
        ->assertSee('Profile updated');

    expect($user->fresh())->toMatchArray([
        'name' => 'New Name',
        'email' => 'new@email.com',
    ]);

});

it('notifies the original email if updated', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    Notification::fake();

    $origionalEmail = $user->email;

    visit(route('profile.edit'))

        ->assertValue('email', $user->email)
        ->fill('email', 'new@email.com')
        ->click('Update Account')
        ->assertSee('Profile updated');

    Notification::assertSentOnDemand(EmailChanged::class, fn (EmailChanged $notification, $routes, $notifiable) => $notifiable->routes['mail'] === $origionalEmail);

});
