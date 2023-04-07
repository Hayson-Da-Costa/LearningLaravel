<?php

use App\Http\Controllers\FallbackContoller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostsController;
use Illuminate\Support\Facades\Route;

/* Manually creating the Routes  */
//GET
// Route::get('/blog', [PostsController::class, 'index'])->name('blog.index');
// Route::get('/blog/{id?}', [PostsController::class, 'show'])->name('blog.show');


/*Routes using Regular expressions with the help of Helper functions */
// Route::get('/blog/{id?}', [PostsController::class, 'show'])->whereNumber('id');
// Route::get('/blog/{name?}', [PostsController::class, 'show'])->whereAlpha('name');

// Route::get('/blog/{id?}/{name?}', [PostsController::class, 'show'])
// ->whereNumber('id')
// ->whereAlpha('name');

//POST
// Route::get('/blog/create', [PostsController::class, 'create'])->name('blog.create');
// Route::post('/blog', [PostsController::class, 'store'])->name('blog.store');

//PUT or PATCH
// Route::get('/blog/edit/{id}', [PostsController::class, 'edit'])->name('blog.edit');
// Route::patch('/blog/{id}', [PostsController::class, 'update'])->name('blog.update');

//DELETE
// Route::get('/blog/{id}', [PostsController::class, 'destroy'])->name('blog.destroy');


/** Using Route Prefix  */
Route::prefix('/blog') -> group( function(){
    Route::get('/', [PostsController::class, 'index'])->name('blog.index');
    Route::get('/create', [PostsController::class, 'create'])->name('blog.create'); /*It's not 
    the point to have /create route on the first place, but it is mandatory to have 
    it before /{id}. Otherwise router tries to get post with id "create" */
    Route::get('/{id?}', [PostsController::class, 'show'])->name('blog.show');
    Route::post('/', [PostsController::class, 'store'])->name('blog.store');
    Route::get('/edit/{id}', [PostsController::class, 'edit'])->name('blog.edit');
    Route::patch('/{id}', [PostsController::class, 'update'])->name('blog.update');
    Route::delete('/{id}', [PostsController::class, 'destroy'])->name('blog.destroy');
});
 

/* Creating the Resource Controller */
// Route::resource('blog', PostsController::class);


/* Creating a single action Controller and route for Invoke method */
Route::get('/', HomeController::class);


//Multiple HTTP verbs
// Route::match(['GET','POST'], '/blog', [PostsController::class, 'index']);
// Route::any('/blog', [PostsController::class, 'index']);

//VIEW method
// Route::view('/blog', 'blog.index', ['name'=>'code with me']);


/* Creating a Fallback Routes */
Route::fallback(FallbackContoller::class);