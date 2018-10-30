<div class="col">



    <div id="logoUploader">
        <div class="d-flex justify-content-between mt-7 mb-3">
            <h3 class="h3 font-weight-normal">File Upload Corpus Logo</h3>
        </div>
        <!-- CARD START  -->
        <div class="card border-0 mt-3">
            <div class="card-body bg-bluegrey-mid py-4 px-3">
                <!-- DEFAULT TEMPLATE ROW -->
                <div class="row logoUpload-start">

                    <!-- LEFT SIDE -->
                    <div class="col-3 px-5 d-flex">
                        <div class="w-100 dashed rounded uploadArea">
                            <div class="w-100 fullheight bg-white d-flex flex-column justify-content-around align-items-center">
                                <i class="fa fa-upload fa-2x fa-fw text-dark mt-5"></i>
                                <p class="text-center px-4">
                                    Drag and drop or
                                    <span class="text-primary">browse logo</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT SIDE -->
                    <div class="col d-flex flex-column justify-content-between align-items-start">
                        <p class="text-14 text-grey w-50 mb-5">
                            There is no individual corpus logo uploaded yet.
                            <br />
                            <br /> The logo should be provided in
                            <b>.jpg</b> or
                            <b>.png</b> format in a squared shape of at least 160x160px.
                        </p>
                    </div>
                    <!-- DEFAULT TEMPLATE END -->
                </div>
                <div class="uploadActions d-flex justify-content-between mt-3">
                    <p class="text-14 text-grey">
                        <span class="uploadLength hidden"></span>
                    </p>
                    <div>
                        <a href="javascript:" id="logo_CancelButton" class="btn btn-outline-corpus-dark text-uppercase font-weight-bold rounded px-5 mr-3 uploadcontrols">
                            Cancel
                        </a>
                        <a href="{{ route('corpus.edit',['corpus' =>$corpus->id ])}}" id="logo_FinishButton" class="disabled btn btn-primary text-uppercase font-weight-bold rounded uploadcontrols">
                            Finish Upload
                        </a>
                        <!-- Submit can happen at this place -->
                    </div>
                </div>
            </div>
        </div>
        <!-- CARD END  -->
        <div id="logoUploadPreview"></div>
    </div>

    <div id="logoFileList">
        <div class="d-flex justify-content-between mt-7 mb-3">
            <h3 class="h3 font-weight-normal">Corpus Logo</h3>
        </div>

        <div class="card border-0 mt-3">
            <div class="card-body bg-bluegrey-mid p-5">


                <!-- DEFAULT TEMPLATE ROW -->
                <div class="row logoUpload-start">

                    <!-- LEFT SIDE -->
                    <div class="col-3 px-5 d-flex">
                        <div class="w-100 dashed rounded uploadPlaceholder">
                            @if (isset($corpus->corpus_logo))
                                <img class="w-100" src="/images/corpuslogos/{{$corpus_data['project_path']}}_{{$corpus->corpus_logo}}" alt="corpus-logo">
                            @else
                                <img class="w-100" src="/images/placeholder_circle.svg" alt="circle-image">
                            @endif

                        </div>
                    </div>

                    <!-- RIGHT SIDE -->
                    <div class="col d-flex flex-column justify-content-between align-items-start">
                        <p class="text-14 text-grey w-50 mb-5">
                            <br /> The logo should be provided in
                            <b>.jpg</b> or
                            <b>.png</b> format in a squared shape of at least 160x160px.
                        </p>
                        <a href="javascript:" id="logo_UploadButton" class="btn btn-primary font-weight-bold text-uppercase rounded uploadcontrols enterLogoUpload">
                            Upload Logo
                        </a>
                    </div>

                    <!-- DEFAULT TEMPLATE END -->
                </div>

            </div>
        </div>
    </div>
</div>