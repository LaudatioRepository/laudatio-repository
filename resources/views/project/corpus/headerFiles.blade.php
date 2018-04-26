
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
                <div class="container-fluid tab-content content">


                    <div role="tabpanel"  class="tab-pane active" id="corpusHeaderFiles">
                        @include('project.corpus.corpusHeaderFiles')
                    </div>

                    <div role="tabpanel"  class="tab-pane fade in" id="documentHeaderFiles">
                        @include('project.corpus.documentHeaderFiles')
                    </div>

                    <div role="tabpanel"  class="tab-pane fade in" id="annotationHeaderFiles">
                        @include('project.corpus.annotationHeaderFiles')
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