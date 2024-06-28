<x-default-layout>

    @section('title')
        Video Management
    @endsection
    @section('breadcrumbs')
        {{ Breadcrumbs::render('videos.index') }}
    @endsection
    <div id="kt_app_content" class="app-content  flex-column-fluid ">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            .video-container {
                display: none;
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background-color: black;
                z-index: 1000;
            }

            video {
                width: 100%;
                height: 100%;
            }

            .close-button {
                position: absolute;
                top: 10px;
                right: 10px;
                color: #fff;
                cursor: pointer;
                font-size: 20px;
            }
        </style>


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
                        <input type="text" id="userSearchInput" class="form-control form-control-solid w-250px ps-13"
                            placeholder="Search Video" />
                    </div>
                    <!--end::Search-->
                </div>


                <!--begin::Separator-->
                <div class="separator border-gray-200"></div>
                <!--end::Separator-->

                <!--begin::Content-->
                <div class="px-7 py-5" data-kt-user-table-filter="form">

                    <!--begin::Add user-->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#kt_modal_add_user">
                        <i class="ki-duotone ki-plus fs-2"></i> Add Video
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
                                <div class="btn btn-icon btn-sm btn-active-icon-primary"
                                    data-kt-users-modal-action="close">
                                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span
                                            class="path2"></span></i>
                                </div>
                                <!--end::Close-->
                            </div>
                            <!--end::Modal header-->

                            <!--begin::Modal body-->
                            {{-- <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <!--begin::Form-->
                {{-- <form id="kt_modal_export_users_form" class="form" action="{{ route('videos.store') }}" method="POST" enctype="multipart/form-data">

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
                </form> --}}
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
                            <h2 class="fw-bold">Add User</h2>
                            <!--end::Modal title-->

                            <!--begin::Close-->
                            <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
                                <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span
                                        class="path2"></span></i>
                            </div>
                            <!--end::Close-->
                        </div>
                        <!--end::Modal header-->

                        <!--begin::Modal body-->
                        <div class="modal-body px-5 my-7">
                            <!--begin::Form-->
                            <div class="container pt-4">
                                <div class="row justify-content-center">
                                    <div class="col-md-8">
                                        <div class="card">
                                            <div class="card-header text-center">
                                                <h5>Upload File</h5>
                                            </div>

                                            <div class="card-body">
                                                <!-- Add your title input field -->
                                                <div class="mb-3">
                                                    <label for="title" class="form-label">Title</label>
                                                    <input type="text" class="form-control" id="title"
                                                        name="title" placeholder="Enter title" required>
                                                </div>

                                                <div id="upload-container" class="text-center">
                                                    <button id="browseFile" class="btn btn-primary">Browse File</button>
                                                </div>

                                                <div style="display: none" class="progress mt-3" style="height: 25px">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated"
                                                        role="progressbar" aria-valuenow="75" aria-valuemin="0"
                                                        aria-valuemax="100" style="width: 75%; height: 100%">75%</div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal footer without submit button -->
                        </div>
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
                                <input class="form-check-input" type="checkbox" data-kt-check="true"
                                    data-kt-check-target="#kt_table_users .form-check-input" value="1" />
                            </div>
                        </th>
                        <th>Title</th>
                        <th>Video</th>
                        {{-- <th>Download</th> --}}
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 fw-semibold">
                    <tr>

                        <div class="card-body py-4">



                            @foreach ($videos as $videos)
                    <tr>
                        <td>
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td>{{ $videos->title }}</td>
                        <td>
                            <a href="#" class="video-link"
                                data-src="{{ asset('storage/' . $videos->file_path) }}">Watch Video</a>

                            <!-- Download link -->
                            {{-- <a href="{{ asset('storage/' . $videos->file_path) }}" download>Download</a> --}}

                        </td>
                        {{-- <td><a href="{{ asset('storage/' . $audio->file_path) }}" download>Download</a></td> --}}
                        <td class="actions">
                            <form action="{{ route('videos.destroy', $videos->id) }}" method="post"
                                style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    style="background-color: #a932ff; color: #ffffff; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;"
                                    onmouseover="this.style.backgroundColor='#7d3aaf'"
                                    onmouseout="this.style.backgroundColor='#a932ff'">Delete</button>
                            </form>
                            <form action="{{ route('videos.edit', $videos->id) }}" method="get"
                                style="display:inline">
                                @csrf

                                <button type="submit"
                                    style="background-color: #a932ff; color: #ffffff; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;"
                                    onmouseover="this.style.backgroundColor='#7d3aaf'"
                                    onmouseout="this.style.backgroundColor='#a932ff'">Edit</button>
                            </form>
                        </td>

                    </tr>
                    @endforeach


        </div>
        </tbody>
        </table>
        <!--end::Table-->
    </div>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/resumable.js/1.1.0/resumable.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            // Function to filter the table based on the search input
            function filterTable() {
                var searchText = $('#userSearchInput').val().toLowerCase();

                $('#kt_table_users tbody tr').each(function() {
                    var titleText = $(this).find('td:eq(1)').text().toLowerCase();

                    if (titleText.includes(searchText)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            }

            // Trigger the filter function when the search input changes
            $('#userSearchInput').on('input', function() {
                filterTable();
            });
        });
    </script>
    <!-- JavaScript to play video in a popup -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var videoLinks = document.querySelectorAll('.video-link');

            videoLinks.forEach(function(link) {
                link.addEventListener('click', function(event) {
                    event.preventDefault();

                    var videoContainer = document.querySelector('.video-container');
                    var video = videoContainer.querySelector('video');
                    var videoSource = video.querySelector('source');
                    var closeButton = document.createElement('span');

                    var videoSrc = link.getAttribute('data-src');

                    if (videoContainer.style.display === 'block') {
                        // Video container is visible, hide it
                        videoContainer.style.display = 'none';
                        video.pause();
                    } else {
                        // Video container is hidden, show it and play the video
                        videoSource.src = videoSrc;
                        video.load();
                        video.play();
                        videoContainer.style.display = 'block';

                        // Create close button
                        closeButton.innerHTML = '&times;';
                        closeButton.className = 'close-button';
                        closeButton.addEventListener('click', function() {
                            videoContainer.style.display = 'none';
                            video.pause();
                        });

                        // Append close button to video container
                        videoContainer.appendChild(closeButton);
                    }
                });
            });

            // Fullscreen functionality
            var videoContainer = document.querySelector('.video-container');
            videoContainer.addEventListener('click', function() {
                if (videoContainer.requestFullscreen) {
                    videoContainer.requestFullscreen();
                } else if (videoContainer.mozRequestFullScreen) {
                    videoContainer.mozRequestFullScreen();
                } else if (videoContainer.webkitRequestFullscreen) {
                    videoContainer.webkitRequestFullscreen();
                } else if (videoContainer.msRequestFullscreen) {
                    videoContainer.msRequestFullscreen();
                }
            });

            // Make the video container moveable
            var isDragging = false;
            var offsetX, offsetY;

            videoContainer.addEventListener('mousedown', function(e) {
                isDragging = true;
                offsetX = e.clientX - videoContainer.getBoundingClientRect().left;
                offsetY = e.clientY - videoContainer.getBoundingClientRect().top;
            });

            document.addEventListener('mousemove', function(e) {
                if (isDragging) {
                    videoContainer.style.left = e.clientX - offsetX + 'px';
                    videoContainer.style.top = e.clientY - offsetY + 'px';
                }
            });

            document.addEventListener('mouseup', function() {
                isDragging = false;
            });
        });
    </script>
    <script type="text/javascript">
        let browseFile = $('#browseFile');
        let resumable = new Resumable({
            target: "{{ route('videos.store') }}",
            query: {
                _token: '{{ csrf_token() }}'
            },
            fileType: ['png', 'jpg', 'jpeg', 'mp4'],
            chunkSize: 2 * 1024 * 1024,
            headers: {
                'Accept': 'application/json'
            },
            testChunks: false,
            throttleProgressCallbacks: 1,
        });

        resumable.assignBrowse(browseFile[0]);

        resumable.on('fileAdded', function(file) {
            // Trigger when file picked
            let title = $('#title').val(); // Get the title from the input field
            showProgress();
            resumable.opts.query.title = title; // Include the title in the request
            resumable.upload();
        });

        resumable.on('fileProgress', function(file) {
            // Trigger when file progress update
            updateProgress(Math.floor(file.progress() * 100));
        });

        resumable.on('fileSuccess', function(file, response) {
            // Trigger when file upload complete
            response = JSON.parse(response)

            if (response.mime_type.includes("image")) {
                $('#imagePreview').attr('src', response.path + '/' + response.name).show();
            }

            if (response.mime_type.includes("video")) {
                $('#videoPreview').attr('src', response.path + '/' + response.name).show();
            }

            $('.card-footer').show();
        });

        resumable.on('fileError', function(file, response) {
            // Trigger when there is any error
            alert('File uploading error.')
        });

        let progress = $('.progress');

        function showProgress() {
            progress.find('.progress-bar').css('width', '0%');
            progress.find('.progress-bar').html('0%');
            progress.find('.progress-bar').removeClass('bg-success');
            progress.show();
        }

        function updateProgress(value) {
            progress.find('.progress-bar').css('width', `${value}%`)
            progress.find('.progress-bar').html(`${value}%`)

            if (value === 100) {
                progress.find('.progress-bar').addClass('bg-success');
            }
        }

        function hideProgress() {
            progress.hide();
        }
    </script>


    <!-- Video container -->
    <div class="video-container">
        <video controls>
            <source src="" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>

</x-default-layout>
