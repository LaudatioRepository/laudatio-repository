@extends('layouts.fileUploadAdmin', ['isLoggedIn' => $isLoggedIn])

@section('content')
     <div class="container-fluid archives">
            <div id="adminapp">
                <full_upload></full_upload>
            </div>
        </div>
        <style>
            .modal-backdrop.fade {
                visibility: hidden;
            }
            .modal-backdrop.fade.show {
                visibility: visible;
            }

            .fade.show {
                display: block;
                z-index: 1072;
            }
        </style>
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
            'directorypath' => $dirname,
            'corpusid' => $corpusid
        ]); ?>
    </script>
@stop