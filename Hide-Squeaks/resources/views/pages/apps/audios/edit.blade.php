<!-- resources/views/audios/edit.blade.php -->

<x-default-layout>

    @section('title')
        Edit Audio
    @endsection

    @section('breadcrumbs')
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('audios.index') }}">Audio Management</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Audio</li>
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
                        <h2 class="fw-bold">Edit Audio</h2>
                    </div>
                </div>
                <!--end::Card header-->

                <!--begin::Content-->
                <div class="card-body py-4 mx-20">
                    <!--begin::Form-->
                    <form action="{{ route('audios.update', $audio->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Audio File</label>
                            <!--end::Label-->

                            <!--begin::Input-->
                            <input type="file" name="audio_file"
                                class="form-control form-control-solid mb-3 mb-lg-0" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2" name="title">Title</label>
                            <!--end::Label-->

                            <!--begin::Input-->
                            <input type="text" name="title" class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="Enter Title" value="{{ $audio->title }}" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2" name="type">Type</label>
                            <!--end::Label-->
                            <select class="form-select form-select-solid form-select-sm" name="type"
                                data-control="select2" data-hide-search="true">
                                <option value="free" @if ($audio->type == 'free') selected @endif selected>Free
                                </option>
                                <option value="paid" @if ($audio->type == 'paid') selected @endif>Paid</option>
                            </select>
                            <!--begin::Input-->
                            {{-- <input type="text" name="type" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter Type" value="{{ $audio->type }}" /> --}}
                            <!--end::Input-->
                        </div>
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2" name="price">Treats</label>
                            <!--end::Label-->

                            <!--begin::Input-->
                            <input type="text" name="price" class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="Enter Treats" value="{{ $audio->price }}" />
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
