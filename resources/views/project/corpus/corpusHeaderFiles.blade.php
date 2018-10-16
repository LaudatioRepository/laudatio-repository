<div class="col">

        <div id="corpusUploader">
            <div class="d-flex justify-content-between mt-7 mb-3">
                <h3 class="h3 font-weight-normal">File Upload Corpus Header XML</h3>
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
                            <a href="javascript:" id="corpus_CancelButton" class="btn btn-outline-corpus-dark text-uppercase font-weight-bold rounded px-5 mr-3 uploadcontrols">
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
            <div id="corpusUploadPreview"></div>
        </div>

        <div id="corpusFileList">
            <div class="col">
                <div class="d-flex justify-content-between mt-7 mb-3">
                    <h3 class="h3 font-weight-normal">Corpus Header XML</h3>
                    <a href="javascript:" id="corpus_UploadButton" class="btn btn-primary font-weight-bold text-uppercase rounded uploadcontrols">
                        File Upload
                    </a>
                </div>

                <table class="custom-table condensed documents-table table table-bluegrey-dark  table-striped">
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
                    @foreach($corpus_data['filedata']['corpusFileData']['headerData']['elements'] as $fileData)
                        @if (isset($fileData['headerObject']))
                        <tr>
                            <td>
                                <div class="custom-control custom-checkbox">
                                    @if (isset($fileData['headerObject']))
                                        <input type="checkbox" class="custom-control-input" id="corpusEditItem§{{$fileData['basename']}}§{{$fileData['headerObject']->id}}">
                                        <label class="custom-control-label font-weight-bold" for="corpusEditItem§{{$fileData['basename']}}§{{$fileData['headerObject']->id}}">
                                            {{$fileData['basename']}}
                                        </label>
                                    @endif
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
                                <a href="javascript:" id="documentDeleteItem§{{$fileData['basename']}}§{{$fileData['headerObject']->id}}">
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
                                    <input type="checkbox" class="custom-control-input" id="selectAll_corpusEdit">
                                    <label class="custom-control-label text-14" for="selectAll_corpusEdit">
                                        Select all
                                    </label>
                                </div>
                            @else
                                <div class="custom-control custom-checkbox">&nbsp;</div>
                            @endif
                        </td>
                        <td colspan="2">
                            @if (Auth::user()->can('Can delete Corpus'))
                                <button class="float-right disabled btn btn-outline-corpus-dark font-weight-bold text-uppercase btn-sm" id="deleteSelectedCorpusButton">
                                    Delete Selected Files
                                </button>&nbsp;
                            @endif

                        </td>
                    </tr>
                    </tfoot>
                </table>

                <p class="mt-5">
                    Info: You can only upload a single Corpus Header file for each corpus. Uploaded files with the same name will
                    be replaced.
                </p>
            </div>
        </div>
</div>