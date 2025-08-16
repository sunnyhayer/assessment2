# Laravel Admin Portal CRUD Application Report

## Overview

This report describes the development of an admin portal application built using the Laravel framework. The main goal was to create a comprehensive CRUD (Create, Read, Update, Delete) system for managing blog posts and categories with admin-only access. The application allows authenticated admin users to create, list, edit, and delete both blog posts and categories, with posts being linked to categories through foreign key relationships. 

## Project Setup

I used Composer to initialize the Laravel project.

```bash
composer create-project laravel/laravel assessment2
```

Laravel 12 comes with SQLite by default, I needed to switch to MySQL for better compatibility with XAMPP. This required updating both the `.env` file and database configuration:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=my_assessment2_db
DB_USERNAME=
DB_PASSWORD=
```


## Creating Models and Migrations

The project required two main models: Post and Category. I created both models with their migrations using Artisan commands:

```bash
php artisan make:model Post -m
php artisan make:model Category -m
```

The Category migration was straightforward with just a few fields:
- id (auto-increment, primary key)
- name (varchar, max 50 characters, not null)
- content (text, nullable)
- timestamps (created_at, updated_at)

The Post migration was more complex because it needed foreign key relationships:
- id (auto-increment, primary key)
- title (varchar, max 50 characters, not null)
- content (text, nullable)
- user_id (foreign key to users table)
- category_id (foreign key to categories table)
- is_active (enum: 'Yes', 'No', default 'Yes')
- timestamps

The important thing was the foreign key constraints and both tables need to use `$table->id()` (which creates BIGINT UNSIGNED) rather than mixing `$table->increments()` with `$table->foreignId()`.

## Model Configuration

Both models needed proper configuration for mass assignment and relationships. The Post model required the `HasFactory` trait and fillable attributes:

```php
protected $fillable = ['title', 'content', 'user_id', 'category_id', 'is_active'];
```

I also set up the model relationships:
- Post belongs to Category
- Post belongs to User  
- Category has many Posts


## Factory and Seeder

To test the application with realistic data, I created factories for both models:

```bash
php artisan make:factory PostFactory --model=Post
php artisan make:factory CategoryFactory --model=Category
```

The factories used Faker to generate dummy data. The CategoryFactory was simple, but the PostFactory needed to handle the foreign key relationships properly by either creating related models or linking to existing ones.

I also created seeders to populate the database with 5 categories and 10 posts for testing. This made development much easier since I didn't have to manually create test data every time I reset the database.

## Authentication and Middleware

I needed to create custom middleware.

```php
->withMiddleware(function (Middleware $middleware): void {
    $middleware->alias([
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
    ]);
})
```

The AdminMiddleware checks if the user is authenticated and has an 'admin' role before allowing access to the CRUD routes.

## Routing and Controller

I created separate controllers for Posts and Categories:

```bash
php artisan make:controller PostController
php artisan make:controller CategoryController
```

Both controllers follow the same pattern with methods for:
- `index()` – Lists all items
- `create()` – Shows form to create new item
- `edit($id)` – Shows form to edit existing item
- `save(Request $request, $id = null)` – Handles both create and update
- `delete($id)` – Deletes an item

The routes were grouped under an 'admin' prefix with authentication middleware:

```php
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    // Posts routes
    Route::get('/posts/all', [PostController::class, 'index'])->name('posts.all');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    // ... other routes
});
```

I used route model binding to automatically inject the models into controller methods, which made the code cleaner and more secure.

## Blade Views

I created a view structure with Bootstrap styling:

**Layout Structure:**
- `posts/index.blade.php` – Post listing with edit/delete links
- `posts/create.blade.php` – Post creation form
- `posts/edit.blade.php` – Post editing form
- Similar structure for categories
- `errors/404.blade.php` – Custom 404 page

## Challenges Faced

### Foreign Key Constraint Errors
The biggest challenge was getting the foreign key relationships to work. I kept getting MySQL error 1005 about incorrectly formed foreign key constraints. The problem was mixing different integer types - some tables used `INT UNSIGNED` while others used `BIGINT UNSIGNED`. The solution was to consistently use `$table->id()` for all primary keys.

### Laravel 12 Middleware Changes
Coming from older Laravel versions, I initially tried to register middleware in `app/Http/Kernel.php`, but Laravel 12 moved this to `bootstrap/app.php`. It took some research to figure out the new `$middleware->alias()` syntax.

### Vite Asset Compilation Issues
The default Laravel installation expected compiled assets from Vite, but I didn't need complex frontend build tools for this project. I solved this by either running `npm run build` or removing the `@vite` directives and using CDN links for Bootstrap instead.

### Edit Forms Creating New Records
Initially, my edit forms were creating new records instead of updating existing ones. This happened because I was using `@method('POST')` incorrectly and my controller logic wasn't properly checking for the `$id` parameter. The fix was ensuring the edit forms posted to the correct route with the ID parameter.

### View Cache Problems
Several times I got "View not found" errors even when the files existed. Laravel was loading cached versions of old views. Running `php artisan view:clear` and `php artisan cache:clear` resolved these issues.

### Route Model Binding Setup
Getting route model binding to work required adding the model bindings to the service provider and ensuring the route parameters matched the model names exactly.

## Conclusion
The experience taught me valuable lessons about Laravel 12's new middleware system, the importance of consistent database column types for foreign keys, and proper MVC architecture. Working through the various challenges - from foreign key constraints to view caching issues - gave me a much deeper understanding of Laravel's internals.
