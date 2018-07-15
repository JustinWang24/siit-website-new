<script type="application/javascript">
    var OfferLetterApp = new Vue({
      el: '#offer-letter-app',
      data:{
        imageBlob: null,
        order:'{{ $order->uuid }}'
      },
      created: function(){

      },
      methods:{
        onSignConfirmed: function(dataURL){
          this.imageBlob = dataURL;
          axios.post('{{ route('enrol.confirm_offer_letter') }}',{signature:this.imageBlob, order: this.order})
              .then(function(res){
                if(res.data.error_no === 100){
                  // 图片保存成功, 跳转到学生的订单列表页面
                  window.location.href = res.data.data.r;
                }
              });
        }
      }
    });
</script>