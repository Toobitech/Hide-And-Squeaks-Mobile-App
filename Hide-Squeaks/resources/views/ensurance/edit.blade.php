<!-- resources/views/audios/edit.blade.php -->

<x-default-layout>

    @section('title')
        Edit Ensurance Policy
    @endsection

    @section('breadcrumbs')
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('ensurance.index') }}">Ensurance Policy</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Ensurance Policy</li>
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
                        <h2 class="fw-bold">Edit Ensurance Policy</h2>
                    </div>
                </div>
                <!--end::Card header-->

                <!--begin::Content-->
                <div class="card-body py-4 mx-20">
                    <!--begin::Form-->
                    <form action="{{ route('ensurance.update', $ensurance->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')


                        <!--end::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fw-semibold fs-6 mb-2" name="paragraph">Paragraph</label>
                            <!--end::Label-->

                            <!--begin::Input-->
                            <textarea name="paragraph" id="editor" class="editor form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter Paragraph" >{{ $ensurance->paragraph }}</textarea>
                            <!--end::Input-->
                        </div>

                        <!--begin::Actions-->
                        <div class="text-center pt-10 mb-5">
                            <button type="submit" class="btn btn-primary">
                                <span class="indicator-label">Update</span>
                                <span class="indicator-progress">
                                    Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
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
