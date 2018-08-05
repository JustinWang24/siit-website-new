<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Jenssegers\Agent\Agent;
use App\Models\Menu;
use App\Models\Configuration;
use Illuminate\Support\Facades\Session;
use App\User;
use App\Models\Catalog\Category;
use Gloudemans\Shoppingcart\Cart;
use App\Models\Catalog\Brand;
use App\Models\Catalog\Product;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * 用来承载View模板数据的container
     *
     * @var array
     */
    public $dataForView = [
        'menuName' => null,
        'pageTitle'=>null,
        'metaKeywords'=>null,
        'metaDescription'=>null,
        'footer'=>null,             // 页脚的Block
        'floatingBox'=>null,        // 页面浮动的Block
        'the_referer'=>null,        // 跟踪客户的referer
        // 和电商相关的部分
        'categoriesTree'=>[],
        'categoriesNav'=>[],
        'cart'=>null
    ];

    // 网站的配置信息对象
    public $siteConfig = null;

    /**
     * 构造函数
     * Controller constructor.
     */
    public function __construct()
    {
        $this->dataForView['agentObject'] = new Agent();
        $this->dataForView['rootMenus'] = Menu::getRootMenus();
        $this->siteConfig = Configuration::find(1);
        $this->dataForView['siteConfig'] = $this->siteConfig;

        // 总是获取 Pathway 目录的数据放到菜单中
        $this->dataForView['pathways'] = [];
        $pathwayCategory = Category::where('uri','University-Pathway-Collection')->first();
        if($pathwayCategory){
            $this->dataForView['pathways'] = $pathwayCategory->productCategories();
        }
        // 总是获取 Pathway 目录的数据放到菜单中

        // 和电商相关
        if(env('activate_ecommerce',false)){
            $categoriesTree = Category::LoadFirstLevelCategoriesInMenu();
            $this->dataForView['categoriesTree'] = $categoriesTree;
            $data = [];
            foreach ($categoriesTree as $category) {
                $data[] = $category->loadForNav();
            }
            $this->dataForView['categoriesNav'] = $data;
            $this->_createCart();
        }
    }

    /**
     * 把用户信息保存到session中
     * @param User $user
     */
    public function _saveUserInSession(User $user){
        Session::put('user_data',[
            'id'=>$user->id,
            'uuid'=>$user->uuid,
            'name'=>$user->name,
            'email'=>$user->email,
            'role'=>$user->role,
            'group'=>$user->group_id,
            'status'=>$user->status,
            // 和Axe使用相关的信息
            'ax_login'      =>$user->axc_login_details,
            'ax_user_id'    =>null,
            'ax_token'      =>null,
            'ax_expired_at' =>null
        ]);
    }

    /**
     * 为其他的控制器类获取购物车实例提供的方法
     * @return \Gloudemans\Shoppingcart\Cart
     */
    public function getCart(){
        if(is_null($this->dataForView['cart'])){
            $this->dataForView['cart'] = $this->_createCart();
        }
        return $this->dataForView['cart'];
    }

    /**
     * 计算购物车中所有货品的重量
     * @return float|int
     */
    public function getTotalWeightInCart(){
        $content = $this->getCart()->content();
        $totalWeight = 0;
        foreach ($content as $item) {
            $totalWeight += isset($item->options['weight']) ? floatval($item->options['weight'])*$item->qty : 0;
        }
        return $totalWeight;
    }

    /**
     * Get an instance of the cart.
     *
     * @return \Gloudemans\Shoppingcart\Cart
     */
    private function _createCart()
    {
        $session = app()->make('session');
        $events = app()->make('events');
        return new Cart($session, $events);
    }

    /**
     * 根据当前的session状态, 决定是否需要登录的操作
     * @return bool
     */
    public function _needLoginToAxcelerate(){
        // 有任何一项为null或者过期, 都需要从新登录 axe
        return is_null(session()->get('user_data.ax_user_id'))
            || is_null(session()->get('user_data.ax_token'))
            || is_null(session()->get('user_data.ax_expired_at'))
            || session()->get('user_data.ax_expired_at') <= date('Y-m-d H:i:s');
    }
}
