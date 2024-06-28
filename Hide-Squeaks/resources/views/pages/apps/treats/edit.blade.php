<!-- resources/views/audios/edit.blade.php -->

<x-default-layout>

    @section('title')
        Edit Treat
    @endsection

    @section('breadcrumbs')
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('treats-deal.index') }}">Treat Deal</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Treat</li>
            </ol>
        </nav>
    @endsection

    <div id="kt_app_content" class="app-content flex-column-fluid">

        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">

            <!--begin::Card-->
            <div class="card">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <h2 class="fw-bold">Edit Treat Deal</h2>
                    </div>
                </div>
                <!--end::Card header-->

                <!--begin::Content-->
                <div class="card-body py-4 mx-20">
                    <!--begin::Form-->
                    <form action="{{ route('treats-deal.update', $treats->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2" name="treats">Treats</label>
                            <!--end::Label-->

                            <!--begin::Input-->
                            <input type="text" name="treats" class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="Enter Treats" value="{{ $treats->treats }}" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2" name="price">Price</label>
                            <!--end::Label-->

                            <!--begin::Input-->
                            <input type="text" name="price" class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="Enter Price" value="{{ $treats->price }}" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2" name="status">Status</label>
                            <!--end::Label-->
                            <select class="form-select form-select-solid form-select-sm" name="status"
                                data-control="select2" data-hide-search="true">
                                <option value="0" @if ($treats->status == 0) selected @endif selected>Off
                                </option>
                                <option value="1" @if ($treats->status == 1) selected @endif>On</option>
                            </select>
                            <!--begin::Input-->
                            {{-- <input type="text" name="type" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter Type" value="{{ $audio->type }}" /> --}}
                            <!--end::Input-->
                        </div>
                        <!--begin::Actions-->
                        <div class="text-center pt-10 mb-5">
                            <button type="submit" class="btn btn-primary">
                                <span class="indicator-label">Update</span>
                                <span class="indicator-progress">
                                    Please wait... <span
                                        class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
</x-default-layout>
