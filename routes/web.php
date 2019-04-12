<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/blog', function () {
    return view('blog.index');
});

Route::get('/', function () {
    return view('blog.index');
});

Route::get('/blog/post', function () {
    return view('blog.post');
});

Route::get('/blog/post/{id}', function($id){
	return view('blog.post', ['id'=>$id] );
})->name('blog.post');

Route::get('/admin', function () {
    return view('admin.index');
});

Route::get('/partials/admin-header', function () {
    return view('partials.admin-header');
});

Route::get('/partials/admin-header/posts', function () {
    return view('admin.index');
})->name('admin.index');

Route::get('/admin/create', function () {
    return view('admin.create');
})->name('admin.create');

Route::get('/edit/{id}', function ($id) {
    return view('admin.edit', ['id'=>$id]);
})->name('admin.edit');

Route::get('edit', function () {
    return view('admin.edit');
})->name('admin.update');

Route::get('/about', function(){
	return view('other.about');
})->name('about');

Route::post('create', function(\Illuminate\Http\Request $request, \Illuminate\Validation\Factory $validator ) {
   $validation = $validator->make( $request->all(), ['title' =>'required | min:5','content' => 'required | min :10']);
    if( $validation->fails()) {
    return redirect()->back()->withErrors($validation);
    }
    return redirect()->route('admin.index')->with('info','Post created, Title:'.$request->input('title'));
})->name('admin.create');

Route::group([ ’prefix’ => ’admin’] , function () {
    Route::get ( ’’, [
        ’uses’ => ’PostController@getAdminIndex’,
        ’as’ => ’admin.index’
    ]);
    Route::get(’create’, [
        ’uses’ => ’PostController@getAdminCreate’,
        ’as’ => ’admin.create’
    ]);
    Route::post ( ’create’ , [
        ’uses’ => ’PostController@postAdminCreate’,
        ’as’ => ’admin.create’
    ]);
    Route::get(’edit/{id}’, [
        ’uses’ => ’PostController@getAdminEdit’,
        ’as’ => ’admin.edit’
    ]);
    Route::post ( ’edit’, [
        ’uses’ => ’PostController@postAdminUpdate’ ,
        ’as’ => ’admin.update’
    ]);
});
