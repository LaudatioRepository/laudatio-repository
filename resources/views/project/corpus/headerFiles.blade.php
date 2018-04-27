
<div class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-2">
                <nav class="headernav sidebar text-14 nav flex-column border-top border-light mt-7" role="tablist">
                    <a class="font-weight-normal text-uppercase py-3 px-0 border-bottom border-light nav-link tablink active" data-toggle="tab" role="tab" data-headertype="corpus" href="#corpusHeaderFiles">Corpus ({{$corpus_data['headerdata']['corpusheader']}})</a>
                    <a class="font-weight-normal text-uppercase py-3 px-0 border-bottom border-light nav-link tablink" data-toggle="tab" role="tab" data-headertype="document" href="#documentHeaderFiles">Documents ({{count($corpus_data['headerdata']['found_documents'])}})</a>
                    <a class="font-weight-normal text-uppercase py-3 px-0 border-bottom border-light nav-link tablink" data-toggle="tab" role="tab" data-headertype="annotation" href="#annotationHeaderFiles">Annotations ({{count($corpus_data['headerdata']['found_annotations_in_corpus'])}})</a>
                    <a class="font-weight-normal text-uppercase py-3 px-0 border-bottom border-light nav-link tablink" data-toggle="tab" role="tab" data-headertype="formatdata" href="#formatDataFiles">Format data (4)</a>
                    <a class="font-weight-normal text-uppercase py-3 px-0 border-bottom border-light nav-link tablink" data-toggle="tab" role="tab" data-headertype="license" href="#logoLicense">Logo/License (8)</a>
                </nav>
            </div>
            <div class="col">
                <div id="tabcontainer" class="container-fluid tab-content content">


                    <div role="tabpanel"  class="tab-pane active" id="corpusHeaderFiles">
                        @include('project.corpus.corpusHeaderFiles')
                    </div>

                    <div role="tabpanel"  class="tab-pane fade in" id="documentHeaderFiles">
                        @include('project.corpus.documentHeaderFiles')
                    </div>

                    <div role="tabpanel"  class="tab-pane fade in" id="annotationHeaderFiles">
                        @include('project.corpus.annotationHeaderFiles')
                    </div>
                    <div id="previews">
                        <div id="corpusUploadTemplate" class="uploadItem p-3 mt-3 bg-bluegrey-light">
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
                    <div role="tabpanel"  class="tab-pane fade in" id="formatDataFiles">
                        @include('project.corpus.formatDataFiles')
                    </div>

                    <div role="tabpanel"  class="tab-pane fade in" id="logoLicense">
                        @include('project.corpus.logoLicense')
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>