<script src="{{ asset('assets/js/core/app.js') }}"></script> {{-- BS Jquery --}}
<script src="{{ asset('assets/js/utils/js.cookie.js') }}"></script> {{-- Cookie --}}
<script src="{{ asset('assets/js/core/argon.js') }}?v=1.2.0"></script> {{-- Argon --}}
<script src="{{ asset('assets/js/utils/sweetalert.min.js') }}"></script> {{-- SA --}}
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="{{ asset('assets/js/utils/filepond.js') }}"></script> {{-- FP --}}
<script src="{{ asset('assets/js/utils/filepond-plugin-file-validate-size.js') }}"></script>
<script src="{{ asset('assets/js/utils/filepond-plugin-file-validate-type.js') }}"></script>
<script src="{{ asset('assets/js/utils/toastr.min.js') }}"></script> {{-- Notif --}}
{{-- <script src="{{ asset('assets/js/utils/select2.min.js') }}"></script> select --}}
<script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script> {{-- Lightbox --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<script src="{{ asset('assets/js/shared/utils.js') }}"></script>
<script src="https://www.momentcrm.com/embed"></script>
<script>
    // window.addEventListener('load', function() {
    //     var body = document.getElementsByTagName('body')[0];
    //     body.classList.add('loaded');
    // });
    MomentCRM('init', {
        'teamVanityId': 'furfect',
        'doChat': true,
        'doTracking': true,
    });
</script>
