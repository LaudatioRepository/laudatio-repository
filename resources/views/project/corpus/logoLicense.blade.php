<div class="col">
    <div class="d-flex justify-content-between mt-7 mb-3">
        <h3 class="h3 font-weight-normal">Corpus Logo</h3>
    </div>

    <div class="card border-0 mt-3">
        <div class="card-body bg-bluegrey-mid p-5">


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
                    <a href="adminEdit_logoLicense.html" class="btn btn-outline-corpus-dark text-uppercase rounded font-weight-bold px-5 leaveLogoUpload logoUpload-cancel ">
                        Cancel
                    </a>
                </div>

                <!-- DEFAULT TEMPLATE END -->
            </div>

            <!-- UPLOAD TEMPLATE -->
            <div id="previews">
                <div class="row logoUpload-end hidden" id="template">

                    <!-- LEFT SIDE -->
                    <div class="col-3 px-5 d-flex">

                        <div class="w-100 dashed rounded uploadProgress">
                            <div class="w-100 fullheight bg-white d-flex flex-column justify-content-around align-items-center p-5">
                                <div class="progress progress-striped active w-100" role="progressbar" aria-valuemin="0" aria-valuemax="100"
                                     aria-valuenow="0">
                                    <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                                </div>
                            </div>
                        </div>

                        <div class="w-100 dashed rounded hidden uploadThumbnail ">
                            <div class="w-100 fullheight d-flex flex-column justify-content-around align-items-center">
                                <img class="w-100" data-dz-thumbnail />
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT SIDE -->
                    <div class="col d-flex flex-column justify-content-between align-items-start">
                        <p class="size hidden" data-dz-size></p>
                        <p class="name font-weight-bold" data-dz-name></p>
                        <strong class="error text-danger" data-dz-errormessage></strong>
                        <div class="d-flex justify-content-start align-items-center">
                            <button class="btn btn-outline-corpus-dark text-uppercase rounded font-weight-bold px-5 leaveLogoUpload logoUpload-delete">
                                Delete
                            </button>
                            <button class="btn btn-outline-corpus-dark text-uppercase rounded font-weight-bold px-5 uploadButton ml-5">
                                Update Logo
                            </button>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <div class="d-flex justify-content-between mt-7 mb-3">
        <h3 class="h3 font-weight-normal">Corpus License</h3>
    </div>

    <div class="w-75">
        <p class="mt-3">
            Introduction about License. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy
            eirmod tempor invidunt ut labore et dolore. If you miss a License format please contact
            the laudatio admimistrator Max Superuser@laudatio.de
        </p>
    </div>

</div>