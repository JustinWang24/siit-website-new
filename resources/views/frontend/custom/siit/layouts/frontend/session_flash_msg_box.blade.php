@if(session('msg'))
    <?php $flashMsg = session('msg'); ?>
    <div class="container p-0 pl-20 pr-20 pt-10 mt-10 mb-10" id="flash-message-content-wrap">
        <div class="content pb-10">
            <div class="notification is-{{ $flashMsg['status'] }}">
                <button class="delete" id="hide-flash-message-btn"></button>
                {{ $flashMsg['content'] }}
            </div>
        </div>
    </div>
    <script type="application/javascript">
        var HideFlashMessageButton = document.getElementById('hide-flash-message-btn');
        HideFlashMessageButton.addEventListener('click', function(e){
            document.getElementById('flash-message-content-wrap').className += ' hidden';
        });
    </script>
@endif