<div class="col">

    <div id="formatUploader">
        <div class="d-flex justify-content-between mt-7 mb-3">
            <h3 class="h3 font-weight-normal">Corpus Format Files File Upload</h3>
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
                        <a href="javascript:" id="format_CancelButton" class="btn btn-outline-format-dark text-uppercase font-weight-bold rounded px-5 mr-3 uploadcontrols">
                            Cancel
                        </a>
                        <a href="javascript:" id="format_FinishButton"  class="disabled btn btn-primary text-uppercase font-weight-bold rounded datafinishbutton">
                            Finish Upload
                        </a>
                        <!-- Submit can happen at this place -->
                    </div>
                </div>
            </div>
        </div>
        <!-- CARD END  -->
        <div id="formatUploadPreview"></div>
    </div>

    <div id="formatFileList">
        <div class="col">
            <div class="d-flex justify-content-between mt-7 mb-3">
                <h3 class="h3 font-weight-normal">Corpus Format Files</h3>
                <a href="javascript:" id="format_UploadButton" class="btn btn-primary font-weight-bold text-uppercase rounded uploadcontrols">
                    File Upload
                </a>
            </div>

            <table class="custom-table documents-table table table-bluegrey-dark  table-striped" id="format_table">
                <thead class="bg-bluegrey-mid">
                <tr class="text-14 text-grey">
                    <th scope="col">Uploaded Files</th>
                    <th scope="col">Collaborator</th>
                    <th scope="col">Affiliation</th>
                    <th scope="col">Updated</th>
                    <th scope="col">Delete</th>
                </tr>
                </thead>
                <tbody>
                @foreach($corpus_data['corpusFormatData']['projects'] as $fileData)
                    @if(isset($fileData['headerObject']))
                    <tr>
                        <td>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="formatEditItem§{{$fileData['basename']}}§{{$fileData['headerObject']->id}}">
                                <label class="custom-control-label font-weight-bold" for="formatEditItem§{{$fileData['basename']}}§{{$fileData['headerObject']->id}}">
                                    {{$fileData['basename']}}
                                </label>
                            </div>
                        </td>
                        @if(isset($fileData['uploader_name']))
                            <td class="text-14 text-grey-light">{{$fileData['uploader_name']}}</td>
                        @else
                            <td class="text-14 text-grey-light">&nbsp;</td>
                        @endif

                        @if(isset($fileData['uploader_affiliation']))
                            <td class="text-14 text-grey-light">{{$fileData['uploader_affiliation']}}</td>
                        @else
                            <td class="text-14 text-grey-light">&nbsp;</td>
                        @endif
                        <td class="text-14 text-grey-light">{{  Carbon\Carbon::parse($fileData['lastupdated'])->format('H:i,M d') }}</td>
                        <td>
                            <a href="javascript:" id="formatDeleteItem§{{$fileData['basename']}}§{{$fileData['headerObject']->id}}">
                                <i class="fa fa-trash-o fa-fw fa-lg text-dark headerDeleteTrashcan"></i>
                            </a>
                        </td>
                    </tr>
                    @endif
                @endforeach
                </tbody>
                <tfoot class="bg-bluegrey-mid">
                <tr>
                    <td colspan="3">
                        @if (Auth::user()->can('Can delete Corpus'))
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="selectAll_formatEdit">
                                <label class="custom-control-label text-14" for="selectAll_formatEdit">
                                    Select all
                                </label>
                            </div>
                        @else
                            <div class="custom-control custom-checkbox">&nbsp;</div>
                        @endif
                    </td>
                    <td colspan="2">
                        @if (Auth::user()->can('Can delete Corpus'))
                            <button class="float-right disabled btn btn-outline-corpus-dark font-weight-bold text-uppercase btn-sm" id="deleteSelectedFormatsButton">
                                Delete Selected Files
                            </button>&nbsp;
                        @endif

                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>