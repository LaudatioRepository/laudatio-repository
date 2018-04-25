<div class="col">

    <div id="documentUploader">
        <div class="d-flex justify-content-between mt-7 mb-3">
            <h3 class="h3 font-weight-normal">File Upload Document Header XML</h3>
        </div>
        <!-- CARD START  -->
        <div class="card border-0 mt-3">
            <div class="card-body bg-bluegrey-mid py-4 px-3">
                <div class="w-100 dashed rounded uploadArea">
                    <div class="w-100 p-5 bg-white d-flex justify-content-center align-items-center">
                        <i class="fa fa-upload fa-2x fa-fw text-dark mr-3"></i>
                        <div>
                            <p class="m-0">
                                Drag and drop or
                                <span class="text-primary">browse files</span>
                                <br />
                                <span class="text-14 text-grey">
                                                        Accepted file format: .xml
                                                      </span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="uploadActions d-flex justify-content-between mt-3">
                    <p class="text-14 text-grey">
                        <span class="uploadLength hidden"></span>
                    </p>
                    <div>
                        <a href="javascript:" id="document_CancelButton" class="btn btn-outline-corpus-dark text-uppercase font-weight-bold rounded px-5 mr-3 uploadcontrols">
                            Cancel
                        </a>
                        <a href="{{ route('corpus.edit',['corpus' =>$corpus->id ])}}" class="disabled btn btn-primary text-uppercase font-weight-bold rounded">
                            Finish Upload
                        </a>
                        <!-- Submit can happen at this place -->
                    </div>
                </div>
            </div>
        </div>
        <!-- CARD END  -->
        <div id="previews">

            <div id="documentUploadTemplate" class="uploadItem p-3 mt-3 bg-bluegrey-light">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="font-weight-bold" data-dz-name></span>
                    <div class="uploadStatusIcons">
                        <i class="uploadSuccessIcon hidden fa fa-check-circle text-success fa-fw fa-lg pr-5"></i>
                        <i class="uploadErrorIcon hidden fa fa-exclamation-triangle text-danger fa-fw fa-lg pr-5"></i>
                        <button class="uploadCancel hidden btn btn-text bg-transparent p-2">
                            <i class="uploadCancelIcon fa fa-close text-dark fa-fw fa-lg"></i>
                        </button>
                    </div>
                </div>
                <div class="mb-2">
                    <p class="size hidden" data-dz-size></p>
                    <span class="uploadStatusText text-14 text-grey"></span>
                    <span class="error text-14 text-danger" data-dz-errormessage></span>
                </div>

                <div class="progress progress-striped active w-90 mb-3" role="progressbar" aria-valuemin="0" aria-valuemax="100"
                     aria-valuenow="0">
                    <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                </div>

            </div>
        </div>
        <p class="mt-5">
            It seems that you just added a new document. The name of the new document will be defined through the according
            .xml file.
        </p>
        <p>Within our
            <a href="#"></a>Help section you will find detailed instructions how to structure .xml data and upload
            files. Following data needs to be provided to be able to publish a document to laudatio:
        </p>
        <div class="mt-5">


            <ul class="list-group list-group-flush mb-3 mt-3">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <b>1 Document Header uploaded</b>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <b>According number of Document Header</b>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div class="d-flex flex-column">
                        <b>According number of Annotation Header</b>
                    </div>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div class="d-flex flex-column">
                        <b>at least 1 Document Data Format</b>
                    </div>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <b>Defined License</b>
                </li>
            </ul>

        </div>
    </div>

    <div id="documentFileList">
        <div class="col">
            <div class="d-flex justify-content-between mt-7 mb-3">
                <h3 class="h3 font-weight-normal">Document Header XML</h3>
                <a href="javascript:" id="document_UploadButton" class="btn btn-primary font-weight-bold text-uppercase rounded uploadcontrols">
                    File Upload
                </a>
            </div>

            <table class="custom-table documents-table table table-bluegrey-dark  table-striped">
                <thead class="bg-bluegrey-mid">
                <tr class="text-14 text-grey">
                    <th scope="col">Uploaded Files</th>
                    <th scope="col">Collaborator</th>
                    <th scope="col">updated</th>
                    <th scope="col">Delete</th>
                </tr>
                </thead>
                <tbody>
                @foreach($corpus_data['filedata']['documentFileData']['headerData']['elements'] as $fileData)
                    <tr>
                        <td>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="corpusEditItem_0001">
                                <label class="custom-control-label font-weight-bold" for="corpusEditItem_0001">
                                    {{$fileData['basename']}}
                                </label>
                            </div>
                        </td>
                        <td class="text-14 text-grey-light">uploader</td>
                        <td class="text-14 text-grey-light">{{  Carbon\Carbon::parse($fileData['lastupdated'])->format('H:i,M d') }}</td>
                        <td>
                            <a href="#">
                                <i class="fa fa-trash-o fa-fw fa-lg text-dark"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>