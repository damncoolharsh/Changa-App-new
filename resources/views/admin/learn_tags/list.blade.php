@extends('layouts/main')

@section('title', 'Dashboard')


@section('content')

<body class="bg-theme bg-theme1">
    <div id="wrapper">
       
            @include('panels/sidebar')
            @include('panels/navbar')


        <div class="content-wrapper">
            <div class="container-fluid">
        
            <!--Start Custromer Content-->
                <section id="customer-list">
                    <div class="row mb-2">
                      <div class="col-md-12">
                        <h5>Tags <span class="float-right"><a href="{{route('create.learn_tags')}}" class="btn btn-primary">Create</a></span></h5>
                      </div>
                    </div>
                  
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                              <div class="card-body">
                                <div class="table-responsive">
                                  <table class="table">
                                    <thead>
                                      <tr>
                                        <th scope="col">Sr. No.</th>
                                        <th scope="col">Tag</th>
                                        <th scope="col">Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      @foreach ($mediate_tags as $key => $user)
                                      <tr>
                                        <th scope="row">{{ $key+1 }}</th>
                                        <td>{{$user->tag}}</td>
                                        <td>
                                            <a href="{{route('edit.learn_tags',$user->id)}}" class="btn btn-warning">Edit</a>
                                            <a href="javascript:void(0)" data-url="{{route('delete.learn_tags',$user->id)}}" class="btn btn-danger openModal">Delete</a>
                                        </td>
                                      </tr>
                                      @endforeach
                                    </tbody>
                                  </table>
                                  {{ $mediate_tags->links('pagination::bootstrap-4') }}
                                </div>
                              </div>
                            </div>
                          </div>
                    </div>
                   
                </section>
            <!--End Custromer Content-->
              
            <!--start overlay-->
                  <div class="overlay toggle-menu"></div>
                <!--end overlay-->
                
            </div>
            <!-- End container-fluid-->
            
            </div>

            <!--Start Back To Top Button-->
            <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
            <!--End Back To Top Button-->

            {{-- @include('modals/delete_users')     --}}

              <!-- Delete Modal Start -->
  <!-- Modal -->
  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header text-center">
          <h3 class="modal-title text-dark" id="exampleModalLongTitle">Delete Modal</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body text-center">
          <h4 class="text-dark">Are you sure you want to delete this?</h4>
        </div>
        <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <a class="btn btn-danger" id="delete-tag-link" href="">Delete</a>
        </div>
        <div class="modal-footer text-center">
          
        </div>
      </div>
    </div>
  </div>
  <!-- Delete Modal End -->
    
        </div>
    
        
    @endsection 

    @section('scripts')
        <script>
          var deleteButton;
          $(document).on('click', '.openModal', function (e) {
            e.preventDefault();
            var url = $(this).data('url');
            deleteButton = $(this);
            $('#delete-tag-link').attr('href', url);
            $('#exampleModalCenter').modal('show');
        });

        $(document).on('click', '#delete-tag-link', function (e) {
            e.preventDefault();
            var url = $(this).attr('href');
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.valid) {
                        $('#exampleModalCenter').modal('hide');
                        deleteButton.closest('tr').remove();
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert('Something went wrong, Please try again...');
                }
            });
        });

      $(document).on('click', '.ok', function(e) {
      // $('.delete').on('submit', function (e) {
        $(this).parent("form").submit();
        e.preventDefault();
        // let url = $(this).data('url');
        // console.log(url);
        var form = new FormData($(this)[0]);
        postMultipartAjax($(this).attr('action'), form, '', formHndlError);
    });
        </script>
    @endsection