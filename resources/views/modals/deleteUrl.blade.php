<div class="delete-pic my-2">
    <?xml version="1.0" ?>
    <svg id="Icons" style="width: 120px;" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
        xmlns:xlink="http://www.w3.org/1999/xlink">
        <defs>
            <style>
                .cls-1 {
                    fill: url(#linear-gradient);
                }

                .cls-2 {
                    fill: #ff7391;
                }
            </style>
            <linearGradient gradientUnits="userSpaceOnUse" id="linear-gradient" x1="12" x2="12"
                y1="0.787" y2="23.088">
                <stop offset="0" stop-color="#ff4867" />
                <stop offset="1" stop-color="#e50031" />
            </linearGradient>
        </defs>
        <circle class="cls-1" cx="12" cy="12" r="11" />
        <path class="cls-2"
            d="M13.414,12l3.293-3.293a1,1,0,1,0-1.414-1.414L12,10.586,8.707,7.293A1,1,0,1,0,7.293,8.707L10.586,12,7.293,15.293a1,1,0,1,0,1.414,1.414L12,13.414l3.293,3.293a1,1,0,0,0,1.414-1.414Z" />
    </svg>
</div>
<h4 class="text-dark">Are you sure you want to delete this?</h4>
<a href="JavaScript:void(0)" id="" class="delete-data btn btn-danger mt-2" data-url={{ @$url}} data-title="Are you sure?" data-body="Once is delete, all medicine and subcategory will be deleted related to this category!" data-icon="" data-success="Category successfully deleted!" data-cancel="Category is safe!">Delete</a>
<form id="delete" class="delete" method="post" action="{{ @$url }}" >
    @csrf
    <input type="" name="id" value="{{ @$id }}">
    <button type="submit" class=" ok btn btn-danger mt-2">Delete {{ @$id }}</button>
</form>
<button type="button" class="btn btn-primary mt-2" data-dismiss="modal">Cancel</button>

@section('scripts')
    <script>
        // $(document).on('click', '.delete', function(e) {
        //   $('#delete').on('submit', function (e) {
        //     e.preventDefault();
        //     // let url = $(this).data('url');
        //     // console.log(url);
        //     var form = new FormData($(this)[0]);
        //     postMultipartAjax($(this).attr('action'), form, '', formHndlError);
        // });

        $('.delete').on('submit', function(e) {
                // $(this).parent("form").submit();
                e.preventDefault();
                var form = new FormData($(this)[0]);
                postMultipartAjax($(this).attr('action'), form, '', formHndlError);
            });
    </script>
@endsection
