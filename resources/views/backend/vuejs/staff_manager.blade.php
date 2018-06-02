<script type="application/ecmascript">
    var PagesManager = new Vue({
        el:"#staff-manager-app",
        data: {
            savingPage: false,
            currentPage: {
                id: '{{ $staff->id }}',
                status:'{{ $staff->status ? 1 : 0 }}',
                name:'{{ $staff->name }}',
                staff_badge_code:'{{ $staff->staff_badge_code }}',
                job_title:'{{ $staff->job_title }}',
                brand_id:'{{ $staff->brand_id ? $staff->brand_id : 0 }}',   // 所属的校区，可以为0
                type:'{{ $staff->type ? $staff->type : \App\Models\Staff::TRAINING_STAFF }}',   // 类型
                division:'{{ $staff->division ? $staff->division : 0 }}',   // 部门
                job_group:'{{ $staff->job_group ? $staff->job_group : 0 }}',   // 工种
                password:'{{ $staff->password }}',
                email:'{{ $staff->email }}',
                phone:'{{ $staff->phone }}',
                fax:'{{ $staff->fax }}',
                feature_image:'{{ $staff->feature_image }}',
                content: '{!! $staff->content !!}'
            },
            rules: {
                name: [
                    { required: true, message: 'Name is Required', trigger: 'blur' }
                ],
                email: [
                    { required: true, message: 'Email is Required', trigger: 'blur' }
                ],
                phone: [
                    { required: true, message: 'Contact phone is Required', trigger: 'blur' }
                ],
                job_title: [
                    { required: true, message: 'Job Title is Required', trigger: 'blur' }
                ]
            }
        },
        created: function(){
            $('#staff-manager-app').removeClass('invisible');
        },
        methods: {
            savePage: function(formName){
                // 验证并保存当前正在编辑的目录信息
                var that = this;
                this.$refs[formName].validate(
                    function(valid){
                        if (valid) {
                            that._savePage();
                        } else {
                            that._notify('error','Error','表单验证失败');
                            return false;
                        }
                    }
                );
            },
            _savePage: function(){
                // 保存 event 信息到服务器的方法
                this.savingPage = true;
                var that = this;
                // 由于使用了 vuejs-editor, 需要单独通过下面的方式获取
                this.currentPage.content = this.$refs.pageContentEditor.getContent();

                axios.post(
                    '/api/staff/save',
                    {staff: this.currentPage}
                ).then(function(res){
                    if(res.data.error_no == 100){
                        // 成功
                        that._notify('success','DONE!','Staff Saved!');
                        that.currentPage.id = res.data.data.msg;
                    }else{
                        // 失败
                        that._notify('error','Error','Can not save staff, please try later!');
                    }
                    that.savingPage = false;
                });
            },
            _notify: function(type, title, msg){
                // 显示弹出消息的方法
                this.$notify({title:title,message:msg,type:type});
            },
            handleFeatureImageSuccess: function(res, file){
                this.currentPage.feature_image = res.url;
            },
            beforeImageUpload(file) {
                const isJPG = file.type === 'image/jpeg';
                const isPNG = file.type === 'image/png';
                const isLt2M = file.size / 1024 / 1024 < 2;

                if (!isJPG && !isPNG) {
                    this.$message.error('上传头像图片只能是 JPG 或 PNG 格式!');
                }
                if (!isLt2M) {
                    this.$message.error('上传头像图片大小不能超过 2MB!');
                }
                return (isJPG || isPNG) && isLt2M;
            }
        }
    });
</script>