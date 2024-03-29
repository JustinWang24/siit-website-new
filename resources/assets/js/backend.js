require('./bootstrap');
import './bulma/carousel';
import './bulma/accordion';
import './bulma/tagsinput';
import Slideout from 'slideout';

// 导入
import ClipboardJS from 'clipboard';

window.Vue = require('vue');
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import { Loading } from 'element-ui';
import locale from 'element-ui/lib/locale/lang/en'
Vue.use(ElementUI, {locale});

// 导入子定义的 vue js editor组件
Vue.component('VuejsEditor', require('./components/vuejs-editor/VuejsEditor.vue'));

// Slide out菜单
if(document.getElementById('menu')){
    var slideout = new Slideout({
        'panel': document.getElementById('panel'),
        'menu': document.getElementById('menu'),
        'padding': 256,
        'tolerance': 70
    });

    document.getElementById('panel').addEventListener('click', function(e) {
        if(slideout.isOpen()){
            slideout.close();
        }else{
            let clickedEl = $(e.target);
            if(clickedEl.attr('id') === 'toggle-drawer-btn' || clickedEl.parent().attr('id') === 'toggle-drawer-btn'){
                slideout.toggle();
            }
        }
    });
}

if(document.getElementById('dealer-manager-app')){
    let dealerManagerApp = new Vue({
        el:'#dealer-manager-app',
        data(){
            return {
              keyword:''
            }
        },
        created: function(){

        },
        methods:{
          querySearchAsync: function(queryString,cb){
                if(queryString.length < 2){
                  return;
                }
                let that = this;
                axios.get(
                    '/api/dealers/search?q=' + queryString
                ).then(function(res){
                  if(res.status === 200 && res.data.error_no === 100){
                    // 表示找到了结果
                    cb(res.data.data)
                  }else{
                    cb([]);
                    that.$message('No dealer is found');
                  }
                });
          },
          handleSelect: function(item){
              window.open('/backend/groups/edit/' + item.id, '_blank') ;
          }
        }
    });
}

if(document.getElementById('student-manager-app')){
  let studentManagerApp = new Vue({
    el:'#student-manager-app',
    data(){
      return {
        keyword:'',
        dealer: null
      }
    },
    created: function(){
      let tmp = document.getElementById('dealer-id');
      if(tmp){
        this.dealer = tmp.getAttribute('data-content');
      }
    },
    methods:{
      querySearchAsync: function(queryString,cb){
        if(queryString.length < 2){
          return;
        }
        let that = this;
        axios.post(
            '/api/students/search-ajax',{q:queryString,d:this.dealer}
        ).then(function(res){
          if(res.status === 200 && res.data.error_no === 100){
            // 表示找到了结果
            cb(res.data.data)
          }else{
            cb([]);
            that.$message('No student is found');
          }
        });
      },
      handleSelect: function(item){
        window.open('/backend/customers/edit/' + item.id) ;
      }
    }
  });
}

if(document.getElementById('my-orders-manager-app')){
  let ordersManagerApp = new Vue({
    el:'#my-orders-manager-app',
    data(){
      return {
        keyword:'',
        dealer: null
      }
    },
    created: function(){
      let tmp = document.getElementById('dealer-id');
      if(tmp){
        this.dealer = tmp.getAttribute('data-content');
      }
    },
    methods:{
      querySearchAsync: function(queryString,cb){
        if(queryString.length < 2){
          return;
        }
        let that = this;
        axios.post(
            '/api/orders/search-ajax',{q:queryString,d:this.dealer}
        ).then(function(res){
          if(res.status === 200 && res.data.error_no === 100){
            // 表示找到了结果
            cb(res.data.data)
          }else{
            cb([]);
            that.$message('No student is found');
          }
        });
      },
      handleSelect: function(item){
        window.open('/backend/customers/edit/' + item.id) ;
      }
    }
  });
}

$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    if(jQuery('.btn-delete').length > 0){
        jQuery('.btn-delete').on('click',function(e){
            e.preventDefault();
            if(confirm('Are you sure to remove this record?')){
                window.location.href = $(this).attr('href');
            }
        });
    }

    if(jQuery('.btn-show-modal').length > 0){
        jQuery('.btn-show-modal').on('click',function(e){
            e.preventDefault();
            let targetId = $(this).data('content');
            $(targetId).addClass('is-active');
        });
        jQuery('.btn-hide-modal').on('click',function(e){
            e.preventDefault();
            let targetId = $(this).data('content');
            $(targetId).removeClass('is-active');
        });
    }

    if($('.copy-txt-btn').length > 0){
        // 激活JS拷贝文本到clipboard
        new ClipboardJS('.copy-txt-btn');
    }
    if($('#mainmenu').length>0){
        $('#mainmenu').on('change',function (e) {
            //console.log(e);
            var main_id = e.target.value;
            if (main_id >1){
                $.get('/api/submenu/' + main_id, function (data) {
                //success
                $('#submenu').empty();
                $.each(data, function (index, subObj) {
                    $('#submenu').append('<option value="' + subObj.id + '">' + subObj.name + ' (' + subObj.name_cn + ')' + '</option>');
                    });
                });
            }
        });
    }
});

/**
 * 让 Laravel + Vuejs 可以支持 jsx 语法的实现方法
 * 到 https://github.com/vuejs/babel-plugin-transform-vue-jsx 去安装插件
 * 然后项目的根目录中创建 .babelrc 文件
 * 在文件中输入下面的内容即可
 {
   "presets": ["es2015"],
   "plugins": ["transform-vue-jsx"]
 }
 *
 */

/**
 * 由于在页面嵌入jsx无法解析,因此在这里提供一个全局方法,用来在后台可以对category tree的node的输出进行定制化
 * @param h
 * @param node
 * @param data
 * @param store
 * @returns {boolean}
 */
window.categoryNoteRender = function(h, { node, data, store }){
    if(data.as_link && data.include_in_menu){
        return (
            <div>{data.name}&nbsp;<span class="tag is-link">L</span>&nbsp;<span class="tag is-primary">M</span></div>
    )
    }else if(data.as_link){
        return (
            <div>{data.name}&nbsp;<span class="tag is-link">L</span></div>
    )
    }else if(data.include_in_menu){
        return (
            <div>{data.name}&nbsp;<span class="tag is-primary">M</span></div>
    )
    }else{
        return (
            <div>{data.name}</div>
    )
    }
};

/**
 * 获取一个指定长度为length的字符串的全局方法
 * @param length
 * @returns {string}
 * @private
 */
window._str_random = function(length=6) {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for (var i = 0; i < length; i++)
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
}

/**
 * 把传入的字符串中的空格换成 -
 * @param str
 */
window._replace_space_with_dash = function(str) {
    return str.replace(/(^\s+|[^a-zA-Z0-9 ]+|\s+$)/g,"").replace(/\s+/g, "-");
}
