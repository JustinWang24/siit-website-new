<script type="application/ecmascript">
    var intakeManager = new Vue({
        el:"#intake-manager-app",
        data: {
            savingPage: false,
            currentPage: {
                id: '{{ $intake->id }}',
                last_updated_user_id: '{{ session('user_data.id') }}',
                type:'{{ $intake->type ? $intake->type : \App\Models\Catalog\InTake::TYPE_PUBLIC }}',
                title:'{{ $intake->title }}',
                code:'{{ $intake->code }}',
                seats:'{{ $intake->seats }}',
                course_id:'{{ $intake->course_id ? $intake->course_id : 0 }}',   // 所属的课程，可以为0
                scheduled:'{{ $intake->scheduled }}',   // 部门
                online_date:'{{ $intake->online_date }}',   // 工种
                offline_date:'{{ $intake->offline_date }}',
                description: '{!! $intake->description !!}',
                description_cn: '{!! $intake->description_cn !!}'
            }
        },
        created: function(){
            $('#intake-manager-app').removeClass('invisible');
        },
        methods: {
            savePage: function(formName){
                // 验证并保存当前正在编辑的目录信息
                this._savePage();
            },
            _savePage: function(){
                $('#intake-items-form').submit();
                // 保存 event 信息到服务器的方法
                this.savingPage = true;
                var that = this;
                // 由于使用了 vuejs-editor, 需要单独通过下面的方式获取
                this.currentPage.description = this.$refs.pageContentEditor.getContent();
                this.currentPage.description_cn = this.$refs.pageCnContentEditor.getContent();

                axios.post(
                    '/api/intakes/save',
                    {intake: this.currentPage}
                ).then(function(res){
                    if(res.data.error_no == 100){
                        // 成功
                        that._notify('success','DONE!','Intake Saved!');
                        that.currentPage.id = res.data.data.msg;
                    }else{
                        // 失败
                        that._notify('error','Error','Can not save Intake, please try later!');
                    }
                    that.savingPage = false;
                });
            },
            _notify: function(type, title, msg){
                // 显示弹出消息的方法
                this.$notify({title:title,message:msg,type:type});
            }
        }
    });
</script>