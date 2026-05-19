<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AuthController;

function getAllProducts(): array {
    return [
        'woman' => [
            1 => ['id'=>1,'name'=>'Linen Tops',    'price'=>799000, 'category'=>'woman','img'=>'images/woman/p1_woman.jpg','colors'=>['White','Beige','Black'],         'sizes'=>['XS','S','M','L','XL'],            'desc'=>'Atasan linen ringan dan breathable, cocok untuk tampilan kasual sehari-hari maupun semi-formal.'],
            2 => ['id'=>2,'name'=>'Floral Dress',  'price'=>599000, 'category'=>'woman','img'=>'images/woman/p2_woman.jpg','colors'=>['Pink','Blue','Green'],            'sizes'=>['XS','S','M','L'],                 'desc'=>'Dress floral dengan potongan feminin, sempurna untuk acara santai maupun outing.'],
            3 => ['id'=>3,'name'=>'Slim Jeans',    'price'=>599000, 'category'=>'woman','img'=>'images/woman/p3_woman.jpg','colors'=>['Light Blue','Dark Blue','Black'], 'sizes'=>['25','26','27','28','29','30'],     'desc'=>'Slim jeans dengan bahan denim berkualitas, nyaman dipakai seharian.'],
            4 => ['id'=>4,'name'=>'Casual Blouse', 'price'=>450000, 'category'=>'woman','img'=>'images/woman/p4_woman.jpg','colors'=>['Navy','White','Dusty Pink'],      'sizes'=>['S','M','L','XL'],                 'desc'=>'Blouse kasual dengan desain modern, mudah dipadukan dengan berbagai outfit.'],
            5 => ['id'=>5,'name'=>'Mini Skirt',    'price'=>399000, 'category'=>'woman','img'=>'images/woman/p5_woman.jpg','colors'=>['Cream','White','Black'],          'sizes'=>['XS','S','M','L'],                 'desc'=>'Mini skirt dengan layer ruffles yang manis, cocok untuk gaya Korean style.'],
            6 => ['id'=>6,'name'=>'Denim Jacket',  'price'=>899000, 'category'=>'woman','img'=>'images/woman/p6_woman.jpg','colors'=>['Blue Denim','Black Denim'],       'sizes'=>['S','M','L','XL'],                 'desc'=>'Jaket denim oversize dengan detail bordir, pilihan sempurna untuk layer outfit.'],
        ],
        'man' => [
            1 => ['id'=>1,'name'=>'Casual Shirt',  'price'=>499000, 'category'=>'man','img'=>'images/man/p1_man.jpg','colors'=>['Light Blue','White','Olive'],          'sizes'=>['S','M','L','XL','XXL'],           'desc'=>'Kemeja kasual dengan bahan ringan, ideal untuk tampilan santai yang tetap rapi.'],
            2 => ['id'=>2,'name'=>'Slim Chinos',   'price'=>599000, 'category'=>'man','img'=>'images/man/p2_man.jpg','colors'=>['Khaki','Navy','Olive'],                'sizes'=>['28','29','30','31','32','33'],     'desc'=>'Chinos slim fit dengan bahan stretch, nyaman dan stylish untuk berbagai kesempatan.'],
            3 => ['id'=>3,'name'=>'Bomber Jacket', 'price'=>899000, 'category'=>'man','img'=>'images/man/p3_man.jpg','colors'=>['Black','Olive','Navy'],                'sizes'=>['S','M','L','XL'],                 'desc'=>'Bomber jacket dengan bahan premium, memberikan tampilan maskulin yang modern.'],
            4 => ['id'=>4,'name'=>'Basic T-Shirt', 'price'=>349000, 'category'=>'man','img'=>'images/man/p4_man.jpg','colors'=>['White','Black','Grey','Navy'],         'sizes'=>['S','M','L','XL','XXL'],           'desc'=>'Kaos basic dengan bahan cotton combed 30s, lembut dan menyerap keringat.'],
            5 => ['id'=>5,'name'=>'Straight Jeans','price'=>649000, 'category'=>'man','img'=>'images/man/p5_man.jpg','colors'=>['Light Blue','Dark Blue','Black'],      'sizes'=>['28','29','30','31','32','33','34'],'desc'=>'Jeans straight cut dengan denim tebal berkualitas, tahan lama dan stylish.'],
            6 => ['id'=>6,'name'=>'Long Coat',     'price'=>1299000,'category'=>'man','img'=>'images/man/p6_man.jpg','colors'=>['Camel','Black','Grey'],                'sizes'=>['S','M','L','XL'],                 'desc'=>'Long coat elegan dengan bahan wool blend, sempurna untuk tampilan formal maupun smart casual.'],
        ],
        'kids' => [
            1 => ['id'=>1,'name'=>'Minimalis Dress','price'=>399000,'category'=>'kids','img'=>'images/kids/kids_p1.jpeg','colors'=>['Cream','White','Pink'],            'sizes'=>['2T','3T','4T','5T','6T'],  'desc'=>'Dress minimalis anak dengan desain simpel dan elegan, cocok untuk berbagai kesempatan.'],
            2 => ['id'=>2,'name'=>'Top Dress',      'price'=>299000,'category'=>'kids','img'=>'images/kids/kids_p2.jpeg','colors'=>['Yellow','Pink','Blue'],            'sizes'=>['2T','3T','4T','5T','6T'],  'desc'=>'Top dress anak yang lucu dan nyaman, bahan lembut untuk kulit sensitif anak.'],
            3 => ['id'=>3,'name'=>'Mini Dress',     'price'=>399000,'category'=>'kids','img'=>'images/kids/kids_p3.jpeg','colors'=>['Green','Pink','White'],            'sizes'=>['3T','4T','5T','6T','7T'],  'desc'=>'Mini dress anak dengan detail renda yang menggemaskan.'],
            4 => ['id'=>4,'name'=>'Skirt Bassball', 'price'=>399000,'category'=>'kids','img'=>'images/kids/kids_p4.jpeg','colors'=>['Blue','Black','Pink'],             'sizes'=>['2T','3T','4T','5T','6T'],  'desc'=>'Rok baseball anak yang trendy, cocok dipadukan dengan kaos casual.'],
            5 => ['id'=>5,'name'=>'T-shirt Salur',  'price'=>359000,'category'=>'kids','img'=>'images/kids/kids_p5.jpeg','colors'=>['Red Stripe','Blue Stripe'],        'sizes'=>['3T','4T','5T','6T','7T'],  'desc'=>'Kaos salur anak berbahan cotton nyaman, cocok untuk aktivitas sehari-hari.'],
            6 => ['id'=>6,'name'=>'Kemeja & Jeans', 'price'=>899000,'category'=>'kids','img'=>'images/kids/kids_p5.jpeg','colors'=>['White/Blue','White/Black'],        'sizes'=>['4T','5T','6T','7T','8T'],  'desc'=>'Set kemeja dan jeans anak yang stylish, tampil rapi dan nyaman sekaligus.'],
        ],
    ];
}

// ========================
// HALAMAN UMUM (bebas tanpa login)
// ========================
Route::get('/', function () { return view('home'); })->name('home');
Route::get('/about', function () { return view('about'); })->name('about');

Route::get('/search', function () {
    $query    = request('q');
    $products = [
        ['name'=>'Linen Tops',    'price'=>'Rp 799.000',  'category'=>'woman','image'=>'images/products/p1.webp'],
        ['name'=>'Floral Dress',  'price'=>'Rp 599.000',  'category'=>'woman','image'=>'images/products/p2.webp'],
        ['name'=>'Slim Jeans',    'price'=>'Rp 599.000',  'category'=>'woman','image'=>'images/products/p3.webp'],
        ['name'=>'Casual Blouse', 'price'=>'Rp 450.000',  'category'=>'woman','image'=>'images/products/p1.webp'],
        ['name'=>'Mini Skirt',    'price'=>'Rp 399.000',  'category'=>'woman','image'=>'images/products/p2.webp'],
        ['name'=>'Denim Jacket',  'price'=>'Rp 899.000',  'category'=>'woman','image'=>'images/products/p3.webp'],
        ['name'=>'Casual Shirt',  'price'=>'Rp 499.000',  'category'=>'man',  'image'=>'images/products/p1.webp'],
        ['name'=>'Slim Chinos',   'price'=>'Rp 599.000',  'category'=>'man',  'image'=>'images/products/p2.webp'],
        ['name'=>'Bomber Jacket', 'price'=>'Rp 899.000',  'category'=>'man',  'image'=>'images/products/p3.webp'],
        ['name'=>'Basic T-Shirt', 'price'=>'Rp 299.000',  'category'=>'man',  'image'=>'images/products/p1.webp'],
        ['name'=>'Straight Jeans','price'=>'Rp 649.000',  'category'=>'man',  'image'=>'images/products/p2.webp'],
        ['name'=>'Long Coat',     'price'=>'Rp 1.299.000','category'=>'man',  'image'=>'images/products/p3.webp'],
    ];
    $results = array_filter($products, fn($p) => str_contains(strtolower($p['name']), strtolower($query)));
    return view('search', ['results' => $results, 'query' => $query]);
})->name('search');

// ========================
// PRODUK (bebas tanpa login)
// ========================
Route::get('/woman', function () {
    return view('woman', ['products' => getAllProducts()['woman']]);
})->name('woman');

Route::get('/man', function () {
    return view('man', ['products' => getAllProducts()['man']]);
})->name('man');

Route::get('/kids', function () {
    return view('kids', ['products' => getAllProducts()['kids']]);
})->name('kids');

Route::get('/product/{category}/{id}', function ($category, $id) {
    $all = getAllProducts();
    if (!isset($all[$category][$id])) abort(404);
    $product = $all[$category][$id];
    $related = collect($all[$category])->filter(fn($p) => $p['id'] !== (int)$id)->take(3)->values();
    return view('product.detail', compact('product', 'related'));
})->name('product.detail');

// ========================
// CART (bebas tanpa login)
// ========================
Route::get('/cart',               [CartController::class, 'index'])      ->name('cart.index');
Route::post('/cart/add',          [CartController::class, 'add'])        ->name('cart.add');
Route::post('/cart/update/{id}',  [CartController::class, 'update'])     ->name('cart.update');
Route::post('/cart/remove/{id}',  [CartController::class, 'remove'])     ->name('cart.remove');
Route::post('/cart/batch-remove', [CartController::class, 'batchRemove'])->name('cart.batch-remove');

// ========================
// AUTH (bebas tanpa login)
// ========================
Route::get('/login',     [AuthController::class, 'showLogin'])   ->name('login');
Route::post('/login',    [AuthController::class, 'login'])       ->name('login.post');
Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])    ->name('register.post');

// ========================
// HALAMAN YANG BUTUH LOGIN
// ========================
Route::middleware('auth')->group(function () {
    Route::post('/logout',           [AuthController::class,   'logout'])  ->name('logout');
    Route::get('/dashboard',         [AuthController::class,   'dashboard'])->name('dashboard');
    Route::get('/checkout',          [CheckoutController::class,'index'])  ->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class,'process'])->name('checkout.process');
    Route::get('/checkout/success',  [CheckoutController::class,'success'])->name('checkout.success');
});

use App\Http\Controllers\AdminController;

    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);

    Route::get('/admin/products', [AdminController::class, 'products']);

    Route::get('/admin/orders', [AdminController::class, 'orders']);

    Route::get('/admin/reports', [AdminController::class, 'reports']);


    use App\Http\Controllers\SuperAdminController;


    Route::get('/superadmin/dashboard', [SuperAdminController::class, 'dashboard']);

    Route::get('/superadmin/admins', [SuperAdminController::class, 'admins']);

    Route::get('/superadmin/users', [SuperAdminController::class, 'users']);

    Route::get('/superadmin/transactions', [SuperAdminController::class, 'transactions']);

    Route::get('/superadmin/reports', [SuperAdminController::class, 'reports']);

    Route::get('/superadmin/auditlog', [SuperAdminController::class, 'auditlog']);
