require('./bootstrap');

// 导入 bulma 所需的Plugin
import './bulma/carousel';
import './bulma/accordion';

// 导入 Slideout 库
import Slideout from 'slideout';

// 导入 fastclick 库
import fastclick from 'fastclick';

// 导入FancyBox库
require('!style-loader!css-loader!@fancyapps/fancybox/dist/jquery.fancybox.css')
require('@fancyapps/fancybox');

// 导入 videojs 库
require('!style-loader!css-loader!video.js/dist/video-js.css');
import videojs from 'video.js';

// 导入 Fotorama
// import './fotorama/fotorama';

// 导入 PhotoSwipe
require('!style-loader!css-loader!photoswipe/dist/photoswipe.css');
require('!style-loader!css-loader!photoswipe/dist/default-skin/default-skin.css');
import 'photoswipe';

// 导入 Slick Carousel
require('!style-loader!css-loader!slick-carousel/slick/slick.css');
require('!style-loader!css-loader!slick-carousel/slick/slick-theme.css');
import 'slick-carousel';

// 导入 animate.css 动画库
require('vue2-animate/dist/vue2-animate.min.css');

window.Vue = require('vue');
// 加载Element UI 库
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
// import { Loading } from 'element-ui';
Vue.use(ElementUI);

// 导入子定义的 vue js editor组件
Vue.component('CatalogViewer', require('./components/catalog-viewer/catalogviewer.vue'));
Vue.component('VuejsSlider', require('./components/vuejs-slider/VuejsSlider.vue'));
Vue.component('VuejsSignaturePad', require('./components/vuejs-signature-pad/vuejs-signature-pad.vue'));
Vue.component('StripePayment', require('./components/payments/stripe/StripePayment.vue'));

fastclick.attach(document.body);

// 注册课程的程序全局变量
let enrollApplication = null;

/**
 * 全局可用的通知函数
 * @param vm
 * @param type
 * @param title
 * @param msg
 * @private
 */
window._notify = function(vm, type, title, msg){
    // 显示弹出消息的方法
    vm.$notify({title:title,message:msg,type:type,position:'bottom-right'});
    return;
}

// 导航菜单的应用
let naviAppEl = document.getElementById('navigation-app');
if(naviAppEl){
    let NavigationApp = new Vue({
        el: '#navigation-app',
        data(){
            return {
                searchKeyword: '',
                result:[]
            }
        },
        methods:{
            handleSelect(item){
                window.location.href = item.uri;
            },
            querySearchAsync(queryString, cb){
                if(queryString.length < 2){
                    return;
                }
                axios.post(
                    '/api/page/search_ajax',
                    {q:queryString}
                ).then(res=>{
                    if(res.status==200 && res.data.error_no == 100){
                        // 表示找到了结果
                        cb(res.data.data.result)
                    }
                });
            }
        }
    });
}

if(document.getElementById('menu')){
    var slideout = new Slideout({
        'panel': document.getElementById('panel'),
        'menu': document.getElementById('menu'),
        'padding': 256,
        'tolerance': 70
    });

    document.querySelector('.toggle-button').addEventListener('click', function() {
        slideout.toggle();
    });
}

// 模仿京东的目录浏览控件
if(document.getElementById('catalog-viewer-app')){
    let catalogViewerApp = new Vue({
        el: '#catalog-viewer-app',
        data(){
            return {
                
            }
        }
    });
}

// Homepage 上播放的视频
if(document.getElementById('homepage-video')){
    let containerWidth = $('.container').width();
    let maskHeight = containerWidth * 0.5625;
    $('#homepage-video-mask').css('height', maskHeight + 'px').css('margin-top', -maskHeight + 'px');

    let videoPlayerObject = videojs('homepage-video',{
        controls: true,
        autoplay: true,
        preload: 'auto',
        loop: true,
        width: containerWidth + 'px'
    });

    videoPlayerObject.ready(function(){
        this.removeClass('is-invisible');
    });
}

$(document).ready(function(){
    // 联系我们功能
    if($('#submit-contact-us-btn').length > 0){
        let theSubmitButton = $('#submit-contact-us-btn');
        theSubmitButton.on('click',function(e){
            e.preventDefault();
            let inputs = $('input');
            let names = [];
            let values = [];
            $.each(inputs, function(idx, input){
                let theInput = $(input);
                if(theInput.attr('name')){
                    names.push(theInput.attr('name'));
                    values.push(theInput.val());
                }
            });

            theSubmitButton.addClass('is-loading');
            axios.post('/contact-us',{
                lead:{
                    name: $('#input-name').val(),
                    email: $('#input-email').val(),
                    phone: $('#input-phone').val(),
                    message: $('#input-message').val()
                }
            }).then(function(res){
                if(res.data.error_no == 100){
                    // 成功
                    $('#txt-on-success').css('display','block');
                    theSubmitButton.css('display','none');
                }else{
                    $('#txt-on-fail').css('display','block');
                }
                theSubmitButton.removeClass('is-loading');
                // 检查是否需要把最新的留言放到Testimonials中
                if($('.testimonials-list').length > 0){
                    let testimonials = $('.testimonials-list');
                    let h = '<p><span class="has-text-link">' +$('#input-name').val()+ ':</span> ' + $('#input-message').val() + '</p>';
                    testimonials.prepend($(h));
                }
            })
        });
    }

    // 检查是否有Slick Carousel
    if($('.slick-carousel-el').length > 0){
        $('.slick-carousel-el').slick();
    }

    // tabs 功能
    if($('.tab-trigger-btn').length > 0){
        $('.tab-trigger-btn').on('click',function(e){
            e.preventDefault();
            $('#tab-contents .tab-pane').addClass('hidden');
            $('.tab-trigger-btn').removeClass('is-active');
            $(this).addClass('is-active');
            let targetTabContent = $(this).children('a').eq(0).attr('href');
            $(targetTabContent).removeClass('hidden');
        });
    }

    // Customer Register
    if($('#general-customer-register-btn').length>0){
        $('#general-customer-register-btn').on('click',function(event){
            event.preventDefault();
            // check if email has existed
            let email = $('#inputEmail').val();
            $('#checkingEmailIcon').removeClass('is-invisible');
            axios.post(
                '/frontend/customer/is_email_exist',
                {email:email}
            ).then(res=>{
                if(res.data.error_no == 100){
                    if(res.data.msg == 'ok'){
                        // 可以注册
                        $('#general-customer-register-form').submit();
                    }else{
                        $('#checkingEmailIcon').addClass('is-invisible');
                        $('#inputEmail').addClass('is-invalid');
                        $('#inputEmailErrorMessage').html('This email has been registered. If this email is yours but you can\'t remember the password, please <a href="/password/reset" style="color:blue;">click here</a> to reset your password.');
                    }
                }
            });
        })
    }

    // 一个特效控件
    if($('.show-mask-on-hover').length > 0){
        $('.show-mask-on-hover').on('mouseover',function(e){
            $(this).children('.mask').eq(0).css('top','0');
        });
        $('.show-mask-on-hover').on('mouseout',function(e){
            $(this).children('.mask').eq(0).css('top','-201px');
        });
    }

    // 处理file 类型的表单field


    // 学生注册报名的功能
    if($('#course-enroll-app').length > 0){
        enrollApplication = new Vue({
                el: '#course-enroll-app',
                data: {
                    user:{
                        email: '',
                        verificationCode: '',
                        password: '',
                        name: '',
                        captcha:'',
                        group_id:null
                    },
                    hasAccount: true,
                    showVerificationField: false,
                    emailField:{
                        errorMsg: '',
                        infoMsg: '',
                        infoMsg2: '',
                        isVerifyingEmail: false,
                        isEmailVerified: false,
                    },
                    verificationField:{
                        errorMsg:'',
                        isVerifyingCode: false
                    },
                    vCode:'',
                    captcha:'',
                    captchaMatched: false,
                    loginAttemptCount: 0,
                    isDoingLogin: false, // 是否正在执行登录操作
                    // 开学日期的相关数据
                    enrollData:{
                        intake_item: null,
                        course_id: null,
                        instance: null
                    },
                    // steps
                    step:{
                        current: 1,
                        total: 4
                    },
                    isChinese: false
                },
                computed: {
                    prevBtnEnable: function(){
                        return this.step.current > 1;
                    },
                    nextBtnEnable: function(){
                        return this.step.current < this.step.total;
                    },
                    showSubmitButton: function(){
                        return this.step.current === this.step.total;
                    }
                },
                watch:{
                    'hasAccount': function(val){
                        if(!val){
                            // 如果选择 I don't have an account
                            this.user.password = '';
                        }
                    },
                    'user.captcha': function(val){
                        if(val === this.captcha){
                            this.captchaMatched = true;
                        }
                    }
                },
                created: function(){
                    // 获取可能的经销商的ID
                    this.user.group_id          = $('#current-group-id').val();
                    this.enrollData.intake_item = $('#current-intake-item').val();
                    this.enrollData.course_id   = $('#current-course-id').val();
                    this.enrollData.instance   = $('#current-instance-id').val();
                    this.isChinese   = $('#current-lang').val() === 'cn';
                    this.loginAttemptCount = 0;
                },
                mounted: function(){
                    $('#course-enroll-app-form').removeClass('is-invisible');
                },
                methods:{
                    // 控制表单一页页显示的几个方法
                    goNext: function(e){
                        e.preventDefault();
                        this.step.current++;
                    },
                    goPrev: function(e){
                        e.preventDefault();
                        if(this.step.current > 0){
                            this.step.current--;
                        }
                    },
                    // 控制表单一页页显示的几个方法结束
                    onSubmit: function(){
                        if(this.loginAttemptCount < 5){
                            this.loginAttemptCount++;
                        }else{
                            window._notify(
                                this,
                                this.isChinese ? '错误' : 'error',
                                this.isChinese ? '尝试次数超过系统限制' : 'You have tried too many times!'
                            );
                            return;
                        }
                        this.isDoingLogin = true;
                        // 学生如果有账号, 可以直接登录
                        if(this.user.email.length > 0 && this.user.password.length > 0){
                            let that = this;
                            axios.post(
                                '/frontend/customers/login-ajax',
                                {email:this.user.email, password: this.user.password}
                            ).then((res)=>{
                                if(res.data.error_no == 100){
                                    that.emailField.infoMsg2 = that.isChinese ? '操作成功, 正在跳转...' : 'Login succeed, we are redirecting ...';
                                    // 登录成功, 那么就要从新加载一下当前页
                                    window.location.href = that._generateReloadUrl(res.data.data.uuid);
                                }else {
                                    // 操作失败
                                    window._notify(that,'error',res.data.data.msg);
                                    // 重置密码为空
                                    that.user.password = '';
                                }
                                that.isDoingLogin = false;
                            });
                        }
                    },
                    // 从服务器端获取验证码
                    getVerificationCode: function(){
                        if(this.user.email.trim().length == 0){
                            this.emailField.errorMsg = this.isChinese ? '请输入一个有效的电子邮件' : 'Please enter a valid email address';
                            return;
                        }
                        this.emailField.errorMsg = '';
                        this.emailField.isVerifyingEmail = true;
                        let that = this;
                        axios.post('/api/students/verify-email',{email: this.user.email,name: this.user.name})
                            .then((res)=>{
                                that.emailField.isVerifyingEmail = false;
                                // 验证方法成功返回数据
                                if(res.data.error_no == 100){
                                    if(res.data.data.result == 'not_valid'){
                                        // 给定的邮件已经不存在
                                        that.emailField.errorMsg = that.isChinese ? '请输入一个有效的电子邮件' : 'Please enter a valid email address';
                                    }else if(res.data.data.result == 'valid'){
                                        if(!res.data.data.emailExisted){
                                            that.vCode = that._decodeVcode(res.data.data.vCode, res.data.data.id);
                                            that.emailField.infoMsg = (that.isChinese ? '验证码已发送到' : 'The verification code is sent to ') + that.user.email;
                                            that.emailField.infoMsg2 = '';
                                            that.showVerificationField = true;
                                            that.captcha = Math.floor((Math.random() * 1000000) + 1) + '';
                                        }else{
                                            // 用户的邮件已经是学生了, 显示让用户输入登录密码的表格, 6位数字
                                            // 给定的邮件已经存在, 需要用户去登录
                                            that.emailField.infoMsg = '';
                                            that.emailField.infoMsg2 = that.isChinese ? '您输入的邮件已经被注册' : 'This email has been registered, please login';
                                            that.hasAccount = true;
                                        }
                                    }
                                }
                            });
                    },
                    // 在用户提交了验证码和captcha码之后提交到服务器的方法
                    verifyCode: function(){
                        this.verificationField.isVerifyingCode = true;
                        if(this.vCode == this.user.verificationCode){
                            // 验证vCode成功
                            this.user.password = Math.floor((Math.random() * 1000000) + 1);
                            let that = this;
                            axios.post(
                                '/api/students/verify-register',{
                                student:this.user
                            }).then((res)=>{
                                if(res.data.error_no == 100){
                                    // 表示注册成功, 从新加载注册页面
                                    window.location.href = that._generateReloadUrl(res.data.data.uuid);
                                }else{
                                    // 表示注册失败, 从新加载注册页面
                                    window._notify(
                                        that,
                                        that.isChinese ? '错误' : 'error',
                                        that.isChinese ? '系统繁忙, 请稍后再试' : 'System is busy, please try again!');
                                    that.verificationField.isVerifyingCode = false;
                                }
                            });
                        }else{
                            this.verificationField.isVerifyingCode = false;
                        }
                    },
                    // 将服务端返回的vcode的顺序从新调整的方法
                    _decodeVcode: function(code, index){
                        let first = code.substring(0,index);
                        let last = code.substring(index);
                        return last + first;
                    },
                    // 获取从新加载当前页面的url
                    _generateReloadUrl: function(userUuid){
                        let intakeItem = 'unax-';
                        if(this.enrollData.intake_item.length > 0){
                          intakeItem = this.enrollData.intake_item;
                        }
                        return '/catalog/course/book/'
                            + intakeItem
                            + '?agent='
                            + this.user.group_id
                            + '&sd='
                            + userUuid
                            + '&instance=' + this.enrollData.instance
                            + '&product_id=' + this.enrollData.course_id;
                    },
                    confirmToEnroll: function(e){
                        e.preventDefault();
                        $('#catalog-course-enroll-form').submit();
                    }
                }
            }
        );
    }

    if($('.has-low-level-menus').length >0){
        $('.has-low-level-menus').on('click',function(val){
          let target = $(this).data('content');
          if($(target).length > 0){
            $(target).toggle();
          }
        });
    }
});