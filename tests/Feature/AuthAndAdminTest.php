<?php

namespace Tests\Feature;

use App\Models\Cast;
use App\Models\Film;
use App\Models\Genre;
use App\Models\Kritik;
use App\Models\Peran;
use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AuthAndAdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_and_registration_pages_are_available_to_guests(): void
    {
        $this->get(route('login'))->assertOk()->assertSee('Sign in to your account');
        $this->get(route('register'))->assertOk()->assertSee('Create a new account');
    }

    public function test_registration_creates_a_regular_user_and_logs_them_in(): void
    {
        $response = $this->post(route('register.store'), [
            'name' => 'Test User',
            'email' => 'person@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $user = User::where('email', 'person@example.com')->firstOrFail();

        $response->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($user);
        $this->assertSame('user', $user->role->name);
        $this->assertNotSame('password123', $user->password);
        $this->assertDatabaseHas('profiles', ['id' => $user->profile_id]);
    }

    public function test_admin_login_redirects_to_the_dashboard_and_regular_users_are_denied(): void
    {
        $user = $this->createUser('user');
        $admin = $this->createUser('admin');

        $this->actingAs($user)->get(route('admin.dashboard'))->assertForbidden();

        $this->post(route('logout'));
        $this->post(route('login.store'), [
            'email' => $admin->email,
            'password' => 'password123',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($admin);
        $this->get(route('admin.dashboard'))->assertOk();
    }

    public function test_account_menu_contains_only_profile_and_logout_and_profile_requires_login(): void
    {
        view()->share('genres', Genre::all());

        $user = $this->createUser('user');

        $this->get(route('profile.me'))->assertRedirect(route('login'));

        $this->actingAs($user)
            ->get(route('home'))
            ->assertOk()
            ->assertSee('My Profile')
            ->assertSee('Log out')
            ->assertDontSee('Admin Dashboard');

        $this->get(route('profile.me'))
            ->assertOk()
            ->assertSee('My Profile')
            ->assertSee($user->name)
            ->assertSee($user->email);
    }

    public function test_admin_can_create_update_and_delete_a_film(): void
    {
        Storage::fake('public');

        $admin = $this->createUser('admin');
        $genre = Genre::create(['name' => 'Drama']);
        $this->actingAs($admin);
        $this->get(route('admin.films.create'))->assertOk();

        $this->post(route('admin.films.store'), [
            'title' => 'Test Film',
            'sinopsis' => 'Film synopsis.',
            'year' => 2024,
            'genre_id' => $genre->id,
            'poster' => new UploadedFile(
                public_path('template/images/m1.jpg'),
                'poster.jpg',
                'image/jpeg',
                null,
                true
            ),
        ])->assertRedirect(route('admin.films.index'));

        $film = Film::where('title', 'Test Film')->firstOrFail();
        $this->assertStringStartsWith('storage/posters/', $film->getRawOriginal('poster'));
        $this->get(route('admin.films.index'))->assertOk()->assertSee('Test Film');
        $this->get(route('admin.films.edit', $film))->assertOk();

        $this->put(route('admin.films.update', $film), [
            'title' => 'Updated Film',
            'sinopsis' => 'Updated synopsis.',
            'year' => 2025,
            'genre_id' => $genre->id,
        ])->assertRedirect(route('admin.films.index'));

        $this->assertDatabaseHas('films', ['id' => $film->id, 'title' => 'Updated Film']);

        $this->delete(route('admin.films.destroy', $film))
            ->assertRedirect(route('admin.films.index'));
        $this->assertDatabaseMissing('films', ['id' => $film->id]);
    }

    public function test_film_page_shows_cast_and_review_author_names_and_reviews_require_login(): void
    {
        view()->share('genres', Genre::all());

        $user = $this->createUser('user');
        $genre = Genre::create(['name' => 'Drama']);
        $film = Film::create([
            'title' => 'Cast Test Film',
            'sinopsis' => 'A film synopsis.',
            'year' => 2024,
            'poster' => 'template/images/m1.jpg',
            'genre_id' => $genre->id,
        ]);
        $cast = Cast::create(['name' => 'Jane Actor', 'age' => 30, 'bio' => 'Performer']);
        Peran::create([
            'film_id' => $film->id,
            'cast_id' => $cast->id,
            'actor' => 'Lead Character',
        ]);
        Kritik::create([
            'film_id' => $film->id,
            'user_id' => $user->id,
            'comment' => 'A great film.',
            'rating' => 5,
        ]);

        $this->get(route('movies.show', $film))
            ->assertOk()
            ->assertSee('Jane Actor')
            ->assertSee('Lead Character')
            ->assertSee('User')
            ->assertSee('A great film.');

        auth()->logout();
        $this->post(route('movies.reviews.store', $film), [
            'comment' => 'Guest review',
            'rating' => 4,
        ])->assertRedirect(route('login'));

        $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'password123',
        ])->assertRedirect(route('movies.show', $film));

        $this->post(route('movies.reviews.store', $film), [
            'comment' => 'Another great film.',
            'rating' => 4,
        ])
            ->assertRedirect(route('movies.show', $film))
            ->assertSessionHas('status', 'Your review has been posted.');

        $this->assertDatabaseHas('kritiks', [
            'film_id' => $film->id,
            'user_id' => $user->id,
            'comment' => 'Another great film.',
            'rating' => 4,
        ]);

        $this->get(route('movies.show', $film))
            ->assertOk()
            ->assertSee('Another great film.');
    }

    public function test_newest_reviews_appear_first_and_older_reviews_are_paginated(): void
    {
        view()->share('genres', Genre::all());

        $user = $this->createUser('user');
        $genre = Genre::create(['name' => 'Drama']);
        $film = Film::create([
            'title' => 'Review Pagination Film',
            'sinopsis' => 'A film synopsis.',
            'year' => 2024,
            'poster' => 'template/images/m1.jpg',
            'genre_id' => $genre->id,
        ]);

        foreach (range(1, 12) as $number) {
            Kritik::create([
                'film_id' => $film->id,
                'user_id' => $user->id,
                'comment' => 'Review number '.str_pad((string) $number, 2, '0', STR_PAD_LEFT),
                'rating' => 5,
            ]);
        }

        $this->get(route('movies.show', $film))
            ->assertOk()
            ->assertSee('Review number 12')
            ->assertDontSee('Review number 01')
            ->assertSee('reviews_page=2');

        $this->get(route('movies.show', $film).'?reviews_page=2')
            ->assertOk()
            ->assertSee('Review number 01');
    }

    public function test_admin_can_filter_and_delete_reviews(): void
    {
        $admin = $this->createUser('admin');
        $reviewer = $this->createUser('user');
        $genre = Genre::create(['name' => 'Drama']);
        $film = Film::create([
            'title' => 'Review Admin Film',
            'sinopsis' => 'A film synopsis.',
            'year' => 2024,
            'poster' => 'template/images/m1.jpg',
            'genre_id' => $genre->id,
        ]);
        $fiveStarReview = Kritik::create([
            'film_id' => $film->id,
            'user_id' => $reviewer->id,
            'comment' => 'Excellent review to keep.',
            'rating' => 5,
        ]);
        $oneStarReview = Kritik::create([
            'film_id' => $film->id,
            'user_id' => $reviewer->id,
            'comment' => 'One star review to remove.',
            'rating' => 1,
        ]);

        $this->actingAs($admin)
            ->get(route('admin.reviews.index', ['rating' => 5]))
            ->assertOk()
            ->assertSee('Excellent review to keep.')
            ->assertDontSee('One star review to remove.');

        $this->delete(route('admin.reviews.destroy', [
            'kritik' => $oneStarReview->id,
            'rating' => 1,
        ]))
            ->assertRedirect(route('admin.reviews.index', ['rating' => 1]))
            ->assertSessionHas('status', 'Review deleted successfully.');

        $this->assertDatabaseMissing('kritiks', ['id' => $oneStarReview->id]);
        $this->assertDatabaseHas('kritiks', ['id' => $fiveStarReview->id]);
    }

    public function test_movie_catalog_filters_by_search_and_genre(): void
    {
        $genre = Genre::create(['name' => 'Drama']);
        $otherGenre = Genre::create(['name' => 'Comedy']);

        $matchingFilm = Film::create([
            'title' => 'Searchable Drama',
            'sinopsis' => 'A quiet story.',
            'year' => 2024,
            'poster' => 'template/images/m1.jpg',
            'genre_id' => $genre->id,
        ]);
        Film::create([
            'title' => 'Unrelated Comedy',
            'sinopsis' => 'A funny story.',
            'year' => 2023,
            'poster' => 'template/images/m2.jpg',
            'genre_id' => $otherGenre->id,
        ]);

        $this->get(route('movies').'?q=Searchable&genre='.$genre->id)
            ->assertOk()
            ->assertSee($matchingFilm->title)
            ->assertDontSee('Unrelated Comedy');

        $this->get(route('genre', $otherGenre->id))
            ->assertOk()
            ->assertSee('Unrelated Comedy')
            ->assertDontSee($matchingFilm->title);
    }

    private function createUser(string $roleName): User
    {
        $role = Role::firstOrCreate(['name' => $roleName]);
        $profile = Profile::create(['umur' => 0, 'bio' => '', 'alamat' => '']);

        return User::create([
            'name' => ucfirst($roleName),
            'email' => $roleName.'@example.com',
            'password' => 'password123',
            'role_id' => $role->id,
            'profile_id' => $profile->id,
        ]);
    }
}
