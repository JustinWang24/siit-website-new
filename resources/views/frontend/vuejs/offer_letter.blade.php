<script type="application/javascript">
    var OfferLetterApp = new Vue({
      el: '#offer-letter-app',
      data:{

      },
      created: function(){
        console.log(222);
      },
      methods:{
        onSignConfirmed: function(dataURL){
          console.log(dataURL);
        }
      }
    });
</script>