<div class="container mb-20 mt-20">
    <div class="content pt-20 mt-20" id="offer-letter-app">
        @for($i=1;$i<8;$i++)
            @include('frontend.custom.siit.enroll.offer_letter_pdf.page_'.$i)
            <br>
        @endfor
    </div>
</div>