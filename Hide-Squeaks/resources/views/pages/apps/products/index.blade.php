<x-default-layout>

    @section('title')
       Product Management
    @endsection
 @section('breadcrumbs')
    {{ Breadcrumbs::render('products.index') }}
@endsection
<div id="kt_app_content" class="app-content  flex-column-fluid " >
    
<div class="card">
    <!--begin::Card header-->
    <div class="card-header border-0 pt-6">
        <!--begin::Card title-->
       <div class="card-title">
    <!--begin::Search-->
    <div class="d-flex align-items-center position-relative my-1">
        <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
            <span class="path1"></span><span class="path2"></span>
        </i>
        <input type="text" id="userSearchInput" class="form-control form-control-solid w-250px ps-13" placeholder="Search Product" />
    </div>
    <!--end::Search-->
        </div>
   

    <!--begin::Separator-->
    <div class="separator border-gray-200"></div>
    <!--end::Separator-->

    <!--begin::Content-->
    <div class="px-7 py-5" data-kt-user-table-filter="form">
   
    <!--begin::Add user-->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_user">
        <i class="ki-duotone ki-plus fs-2"></i>        Add Product
    </button>
    <!--end::Add user-->
</div>
<!--end::Toolbar-->

<!--begin::Group actions-->
<div class="d-flex justify-content-end align-items-center d-none" data-kt-user-table-toolbar="selected">
    <div class="fw-bold me-5">
        <span class="me-2" data-kt-user-table-select="selected_count"></span> Selected
    </div>

    <button type="button" class="btn btn-danger" data-kt-user-table-select="delete_selected">
        Delete Selected
    </button>
</div>
<!--end::Group actions-->

<!--begin::Modal - Adjust Balance-->
<div class="modal fade" id="kt_modal_export_users" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Export Users</h2>
                <!--end::Modal title-->

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->

            <!--begin::Modal body-->
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <!--begin::Form-->
                <form id="kt_modal_export_users_form" class="form" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                 
                    <div class="text-center">
                      

                        <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                            <span class="indicator-label">
                                Submit
                            </span>
                            <span class="indicator-progress">
                                Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - New Card-->

<!--begin::Modal - Add task-->
<div class="modal fade" id="kt_modal_add_user" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_add_user_header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Add Product</h2>
                <!--end::Modal title-->

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->

            <!--begin::Modal body-->
            <div class="modal-body px-5 my-7">
                <!--begin::Form-->
                <form id="kt_modal_add_user_form" class="form" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                    <!--begin::Scroll-->
                    <div 
                        class="d-flex flex-column scroll-y px-5 px-lg-10" 
                        id="kt_modal_add_user_scroll" 
                        data-kt-scroll="true" 
                        data-kt-scroll-activate="true" 
                        data-kt-scroll-max-height="auto" 
                        data-kt-scroll-dependencies="#kt_modal_add_user_header" 
                        data-kt-scroll-wrappers="#kt_modal_add_user_scroll" 
                        data-kt-scroll-offset="300px"
                    >
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Product File</label>
                            <!--end::Label-->

                            <!--begin::Input-->
                            <input type="file" name="image"   class="form-control form-control-solid mb-3 mb-lg-0" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2" name="name">Name</label>
                            <!--end::Label-->

                            <!--begin::Input-->
                            <input type="text" name="name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter Name" />
                            <!--end::Input-->
                        </div>
                         <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2" name="price">Price</label>
                            <!--end::Label-->

                            <!--begin::Input-->
                            <input type="text" name="price" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Price" />
                            <!--end::Input-->
                        </div>
                                                                                        <!--end::Roles-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--end::Scroll-->

                    <!--begin::Actions-->
                    <div class="text-center pt-10 mb-5">
                        

                        <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                            <span class="indicator-label">
                                Submit
                            </span>
                            <span class="indicator-progress">
                                Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - Add task-->  
<div class="card-body py-4 mx-20">
        
<!--begin::Table-->
 <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
            <thead>
               <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                  <th class="w-10px pe-2">
                     <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                        <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_table_users .form-check-input" value="1" />
                     </div>
                  </th>
                  <th>Name</th>
                <th>image</th>
                 <th>price</th>
                {{-- <th>Download</th> --}}
                <th>Delete</th>
                <th>Edit</th>
               </tr>
            </thead>
    <tbody class="text-gray-600 fw-semibold">
                    <tr>
              
                  <div class="card-body py-4">
        
        
          
                   @foreach($product as $product)
                <tr>
                  <td>
                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                        <input class="form-check-input" type="checkbox" value="1" />
                    </div>
                </td>
                    <td>{{ $product->name }}</td>
                   <td>
    <img src="{{ asset('storage/' . $product->image) }}" alt="Video Thumbnail" style="width: 100px; height: 100px;">
</td>

                     <td>{{ $product->price }}</td>
                    {{-- <td><a href="{{ asset('storage/' . $audio->file_path) }}" download>Download</a></td> --}}
                    <td class="actions">
                        <form action="{{ route('products.destroy', $product->id) }}" method="post" style="display:inline">
                            @csrf
                            @method('DELETE')
<button type="submit" style="background-color: #a932ff; color: #ffffff; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;" onmouseover="this.style.backgroundColor='#7d3aaf'" onmouseout="this.style.backgroundColor='#a932ff'">Delete</button>
                        </form>
                    </td>
                    <td class="actions">
                        <form action="{{ route('products.edit', $product->id) }}" method="get" style="display:inline">
                            @csrf
                            
<button type="submit" style="background-color: #a932ff; color: #ffffff; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;" onmouseover="this.style.backgroundColor='#7d3aaf'" onmouseout="this.style.backgroundColor='#a932ff'">Edit</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        
     
      </div>
            </tbody>
</table>
<!--end::Table-->    </div>
      </div>
        <!--end::Card toolbar-->
    </div>
    <!--end::Card header-->
</div>
<!--end::Card-->
</div>
<!--end::Content container-->
</div>
<!--end::Content-->
</div>
<!--end::Menu 1-->

    
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        // Function to filter the table based on the search input
        function filterTable() {
            var searchText = $('#userSearchInput').val().toLowerCase();

            $('#kt_table_users tbody tr').each(function () {
                var titleText = $(this).find('td:eq(1)').text().toLowerCase();

                if (titleText.includes(searchText)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }

        // Trigger the filter function when the search input changes
        $('#userSearchInput').on('input', function () {
            filterTable();
        });
    });
</script>
 
    </x-default-layout>
