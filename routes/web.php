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

Route::get('/', 'Frontend\Pages@index')->name('home');
Route::get('/contact-us', 'Frontend\Pages@contact_us')->name('contact_us');
Route::post('/contact-us', 'Frontend\Pages@contact_us_handler');
Route::get('/terms', 'Frontend\Pages@terms')->name('terms');
Route::get('/switch-language/{lang?}', 'Frontend\Pages@switch_language')->name('switch_language');
Route::get('/staff-profile', 'Frontend\Pages@view_staff_profile');
Route::get('/intake-latest', 'Frontend\Pages@intake_latest')->name('intake_latest');

// 特定的URI
Route::prefix('page')->group(function(){
    Route::get('/blog', 'Frontend\Pages@blog');
    Route::get('/blog/{uri}', 'Frontend\Pages@blog_view');
    Route::get('/news', 'Frontend\Pages@news');
    Route::get('/news/{uri}', 'Frontend\Pages@news_view');

    // 查看某个独立页面内容的路由
    Route::get('/{uri}', 'Frontend\Pages@view');
});

// 加载产品目录的内容
Route::get('/category/view/{uri}', 'Frontend\Categories@view');
Route::post('/products/add_to_cart','Frontend\ShoppingCartController@add_to_cart');
Route::get('/view_cart','Frontend\ShoppingCartController@view_cart');
Route::post('/cart/remove','Frontend\ShoppingCartController@remove_item');
Route::post('/checkout','Frontend\ShoppingCartController@prepare_checkout');

Route::prefix('catalog')->group(function(){
    Route::get('product/{uri}', 'Frontend\Products@view');
    Route::get('brand/load', 'Frontend\Products@view_by_brand');
    Route::any('course/book/{id?}', 'Frontend\EnrollController@course_enroll')->name('course.book');
    Route::post('course/confirm-book', 'Frontend\EnrollController@course_enroll_confirm');

    // 显示Offer Letter
    Route::get('course/offer-letter', 'Frontend\EnrollController@show_offer_letter')
        ->name('enrol.offer_letter');
    Route::get('course/get-offer-letter/{orderUuid}', 'Frontend\EnrollController@get_offer_letter')
        ->name('enrol.get_offer_letter');
    Route::post('course/confirm-offer-letter', 'Frontend\EnrollController@confirm_offer_letter')
        ->name('enrol.confirm_offer_letter');
});

// 前端页面显示相关路由组
Route::prefix('frontend')->group(function () {
    // 用户登录与注册
    Route::post('customer/is_email_exist', 'Frontend\CustomersController@is_email_exist');
    Route::get('customers/login', 'Frontend\CustomersController@login')->name('customer_login');
    Route::post('customers/login', 'Frontend\CustomersController@login_check');
    Route::post('customers/login-ajax','Frontend\CustomersController@login_check_ajax');    // 客户登录的ajax方式
    Route::get('customers/forget-password', 'Frontend\CustomersController@forget_password');
    Route::get('customers/register', 'Frontend\CustomersController@register');
    Route::post('customer/register', 'Frontend\CustomersController@save');
    Route::post('customer/quick-checkout-register', 'Frontend\CustomersController@quick_checkout_register');
    Route::get('wholesalers/register', 'Frontend\CustomersController@register_wholesale');
    Route::post('wholesalers/register', 'Frontend\CustomersController@save_wholesale');

    // 支付订单, 从我的订单历史中而来
    Route::get('pay_order','Frontend\CheckoutController@pay_order')
        ->name('frontend.order.pay');

    Route::get('place_order_checkout','Frontend\CheckoutController@place_order_checkout')
        ->name('customer.checkout');
    Route::post('place_order_checkout','Frontend\CheckoutController@place_order_checkout');

    /**
     * 学生的课程相关开始
     */
    Route::get('my_courses','Frontend\Courses@my_courses')->name('student_courses');
    Route::post('login-my-courses','Frontend\Courses@my_courses_login');
    Route::post('change-axuser-password','Frontend\Courses@change_axuser_password');
    /**
     * 学生的课程相关结束
     */
    Route::get('my_orders/{userUuid?}/{clearCart?}','Frontend\Orders@my_orders');
    // 客户的个人档案
    Route::get('my_profile/{userUuid?}','Frontend\CustomersController@my_profile');
    Route::post('my_profile/{userUuid?}','Frontend\CustomersController@my_profile');
    Route::post('update_password','Frontend\CustomersController@update_password');

    Route::get('view_order/{userUuid}/{orderUuid}','Frontend\Orders@view_order');

    // FC 用来管理某个订单的路由
    Route::get('approve_order/{userUuid}/{orderUuid}','Frontend\Orders@approve');
    Route::get('decline_order/{userUuid}/{orderUuid}','Frontend\Orders@decline');
    Route::post('decline_order/{userUuid}/{orderUuid}','Frontend\Orders@decline'); // 通过Ajax的方式拒绝订单的路由
});

Auth::routes();

Route::prefix('backend')->middleware('auth')->group(function(){
    // 联系的 Leads 列表
    Route::get('leads','Backend\Pages@leads');
    Route::get('leads/delete/{id}','Backend\Pages@lead_delete');

    // 目录相关
    Route::get('menus/index','Backend\Menus@index');
    Route::get('menus/add','Backend\Menus@add');
    Route::get('menus/edit/{id}','Backend\Menus@edit');
    Route::get('menus/delete/{id}','Backend\Menus@delete');
    Route::post('menus/save','Backend\Menus@persistent');

    // 静态页相关
    Route::get('pages/index','Backend\Pages@index');
    Route::get('pages/add','Backend\Pages@add');
    Route::get('pages/edit/{id}','Backend\Pages@edit');
    Route::get('pages/delete/{id}','Backend\Pages@delete');
    Route::post('pages/save','Backend\Pages@persistent');

    // 博客内容相关
    Route::get('blog/index','Backend\Blog@index');
    Route::get('blog/add','Backend\Blog@add');
    Route::get('blog/edit/{id}','Backend\Blog@edit');
    Route::get('blog/delete/{id}','Backend\Blog@delete');
    Route::post('blog/save','Backend\Blog@persistent');

    // 新闻相关
    Route::get('news/index','Backend\Press@index');
    Route::get('news/add','Backend\Press@add');
    Route::get('news/edit/{id}','Backend\Press@edit');
    Route::get('news/delete/{id}','Backend\Press@delete');
    Route::post('news/save','Backend\Press@persistent');

    // Events 相关
    Route::get('events/index','Backend\Events@index');
    Route::get('events/add','Backend\Events@add');
    Route::get('events/edit/{id}','Backend\Events@edit');
    Route::get('events/delete/{id}','Backend\Events@delete');
    Route::post('events/save','Backend\Events@persistent');

    // Staff 相关
    Route::get('staff/index','Backend\StaffController@index');
    Route::get('staff/add','Backend\StaffController@add');
    Route::get('staff/edit/{id}','Backend\StaffController@edit');
    Route::get('staff/delete/{id}','Backend\StaffController@delete');

    // Staff 相关
    Route::get('intakes/index','Backend\IntakesController@index');
    Route::get('intakes/add','Backend\IntakesController@add');
    Route::get('intakes/edit/{id}','Backend\IntakesController@edit');
    Route::get('intakes/delete/{id}','Backend\IntakesController@delete');
    Route::get('intakes/items-manager/{id}','Backend\IntakesController@items_manager');
    Route::post('intakes/save-items','Backend\IntakesController@save_items');

    // Widgets
    Route::get('widgets/sliders','Backend\Widgets@list_sliders');
    Route::get('widgets/blocks','Backend\Widgets@list_blocks');
    Route::get('blocks/add','Backend\Widgets@add_block');
    Route::get('blocks/edit/{id}','Backend\Widgets@edit_block');
    Route::get('blocks/delete/{id}','Backend\Widgets@delete_block');
    Route::post('blocks/save','Backend\Widgets@save_block');
    Route::get('widgets/galleries','Backend\Widgets@list_galleries');

    // 网站设置
    Route::post('configuration/save','Backend\Home@save_config');

    /**
     * 以下为电商相关内容的管理
     */
    // 网站的产品目录管理
    Route::get('categories', 'Backend\Categories@index')->name('categories');
    // 运费管理
    Route::get('shipment', 'Backend\Shipment@index')->name('shipment_manager');
    Route::get('shipment/add', 'Backend\Shipment@add');
    Route::post('shipment/save', 'Backend\Shipment@save');
    Route::get('shipment/edit/{id}', 'Backend\Shipment@edit');
    Route::get('shipment/delete/{uuid}', 'Backend\Shipment@delete');

    // 网站的产品管理
    Route::get('products', 'Backend\Products@index')->name('products');
    Route::get('products/add', 'Backend\Products@add');
    Route::get('products/edit/{id}', 'Backend\Products@edit');
    Route::get('products/delete/{uuid}', 'Backend\Products@delete');
    Route::get('products/related/{uuid}', 'Backend\Products@related');
    Route::post('products/save-related-products', 'Backend\Products@save_related_products');

    // 网站组合产品
    Route::get('group-products/add', 'Backend\GroupProducts@add');

    /**
     * 管理某个属性集的路由
     */
    Route::get('attribute-sets', 'Backend\AttributeSet@index')->name('attribute_set');
    Route::get('attribute-sets/add', 'Backend\AttributeSet@add');
    Route::post('attribute-sets/save', 'Backend\AttributeSet@save');
    Route::get('attribute-sets/edit/{id}', 'Backend\AttributeSet@edit');
    Route::get('attribute-sets/delete/{id}', 'Backend\AttributeSet@delete');
    Route::get('attribute-sets/listing/{id}/{productAttributeId?}', 'Backend\AttributeSet@listing');
    Route::get('attribute-sets/delete-product-attribute/{id}', 'Backend\AttributeSet@delete_product_attribute');

    /**
     * 客户管理
     */
    Route::get('customers','Backend\Customers@index')->name('customers');
    Route::get('customers/add','Backend\Customers@add');
    Route::get('users/add','Backend\Users@add');
    Route::get('customers/edit/{id}','Backend\Customers@edit');
    Route::get('customers/delete/{id}','Backend\Customers@delete');
    Route::get('users/delete/{id}','Backend\Users@delete');
    Route::get('users/edit/{id}','Backend\Users@edit');
    Route::post('customers/save','Backend\Customers@save');
    Route::post('users/save','Backend\Users@save');

    Route::get('system-users','Backend\Users@index')->name('system-users');
    Route::get('update-password','Backend\Users@update_password');
    Route::post('update-password','Backend\Users@update_password_handler');
    Route::get('wechat-config','Backend\AttributeSet@index');

    /**
     * 订单管理的路由
     */
    Route::get('orders', 'Backend\Orders@my_orders')->name('orders');
    Route::get('orders/view/{orderId}', 'Backend\Orders@view');
    Route::post('orders/ajax_search', 'Backend\Orders@ajax_search');
    Route::get('orders/ajax_issue_invoice/{id}', 'Backend\Orders@ajax_issue_invoice');  // 切换订单的状态到发票已开的状态

    /**
     * 合作经销商管理
     */
    Route::get('groups', 'Backend\Groups@index')->name('groups');
    Route::get('groups/view-students', 'Backend\Groups@view_students')->name('admin.view.group.students');
    Route::get('groups/view-orders', 'Backend\Groups@view_orders')->name('admin.view.group.orders');
    Route::get('groups/add', 'Backend\Groups@add');
    Route::get('groups/import', 'Backend\Groups@import');
    Route::get('groups/edit/{id}', 'Backend\Groups@edit');
    Route::get('groups/delete/{id}', 'Backend\Groups@delete');
    Route::post('groups/save','Backend\Groups@save');

    /**
     * 品牌管理
     */
    Route::get('brands', 'Backend\Brands@index')->name('brands');
    Route::get('brands/add', 'Backend\Brands@add');
    Route::get('brands/edit/{id}', 'Backend\Brands@edit');
    Route::get('brands/delete/{id}', 'Backend\Brands@delete');
    Route::post('brands/save','Backend\Brands@save');
});

Route::prefix('group')->group(function (){
    Route::get('login', 'Group\Index@login')->name('group.login');
    Route::post('login', 'Group\Index@login_action')->name('group.login.action');
    Route::post('logout', 'Group\Index@logout')->name('group.logout');

    // 经销商主页
    Route::get('portal', 'Group\Index@portal')->name('group.portal');
    Route::get('students', 'Group\Index@students')->name('group.students');
    Route::get('orders', 'Group\Index@orders')->name('group.orders');
    Route::get('payments', 'Group\Index@payments')->name('group.payments');
});

Route::get('/home', 'Backend\Home@index');
