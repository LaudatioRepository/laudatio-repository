<template>
    <div class="card">
        <div class="card-header btn bg-corpus-mid font-weight-bold text-uppercase d-flex justify-content-between align-items-center"
             data-toggle="collapse" data-target="#formPanelCorpus" aria-expanded="true" aria-controls="formPanelCorpus">
            <span>Corpus</span>
            <i class="collapse-indicator fa fa-chevron-circle-down fa-fw fa-lg text-16"></i>
        </div>
        <div class="collapse show" id="formPanelCorpus">
            <div class="card-body px-2">
                <form action="">
                    <div class="form-group mb-3">
                        <label class="mb-0 text-14 " for="formCorpusTitle">Title</label>
                        <input type="text" class="form-control" id="formCorpusTitle" aria-describedby="inputTitle" placeholder='"Ridges herbology"'>
                    </div>

                    <div class="form-group mb-3">
                        <label class="mb-0 text-14 " for="formCorpusLanguage">Language</label>
                        <input type="text" class="form-control" id="formCorpusLanguage" aria-describedby="inputLanguage" placeholder='"German"'>
                    </div>

                    <div class="d-flex flex-column">
                        <a class="align-self-end text-uppercase text-dark text-14 filter-expander" data-toggle="collapse" href="#"
                           data-target=".formPanelCorpus-all" role="button" aria-expanded="false" aria-controls="#formPanelCorpus-all1 #formPanelCorpus-all2">
                            + Show all Corpusfilter
                        </a>
                    </div>

                    <div id="formPanelCorpus-all1" class="collapse formPanelCorpus-all">

                        <div class="form-group mb-3">
                            <label class="mb-0 text-14 " for="formCorpusPublisher">Language</label>
                            <input type="text" class="form-control" id="formCorpusPublisher" aria-describedby="inputPublisher" placeholder='"Humboldt Universität"'>
                        </div>

                        <div class="form-group mb-3">
                            <label class="mb-0 text-14 " for="formCorpusFormats">Formats</label>
                            <input type="text" name="formatslist" multiple="multiple" list="formatsList-Corpus" class="flexdatalist form-control"
                                   data-min-length="0" id="formCorpusFormats">
                            <datalist id="formatsList-Corpus">
                                <!--[if IE 9]><select disabled style="display:none" class="ie9_fix"><![endif]-->
                                <option value="ANNIS">ANNIS</option>
                                <option value="EXEL">EXEL</option>
                                <option value="PAULA">PAULA</option>
                                <option value="Negra">Negra</option>
                                <option value="TEI-Header">TEI-Header</option>
                                <option value="txt">txt</option>
                                <!--[if IE 9]></select><![endif]-->
                            </datalist>
                        </div>

                        <div class="form-group mb-3">
                            <label class="mb-0 text-14 " for="formCorpusLicenses">License</label>
                            <input type="text" class="form-control" id="formCorpusLicenses" aria-describedby="inputLicenses" placeholder='"cc-by"'>
                        </div>
                    </div>
                </form>

                <div id="formPanelCorpus-all2" class="collapse formPanelCorpus-all">


                    <form action="">
                        <div class="form-group mb-3">
                            <label class="mb-2 text-14 " for="dd">Corpus size (Tokens, Words)</label>
                            <div class="d-flex justify-content-between">
                                <div class="w-75">
                                    <div id="corpusSize"></div>
                                    <div class="d-flex justify-content-between w-100 text-dark font-weight-bold text-14">
                <span id="corpusSize-minVal">
                </span>
                                        <span id="corpusSize-maxVal">
                </span>
                                    </div>
                                </div>
                                <button type="submit" class="disabled btn btn-sm btn-corpus-dark p-0">
                                    <i class="fa fa-angle-right fa-fw fa-2x py-1"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <form action="">
                        <div class="form-group mb-3">
                            <label class="mb-0 text-14 " for="formCorpusYear">Year of Publication</label>
                            <div class="d-flex justify-content-between">
                                <div class="d-flex flex-column w-35">
                                    <small id="yearFromHelp" class="form-text text-muted">from</small>
                                    <input class="toBeValidated form-control" placeholder="J J J J" type="number" min="1" max="9999" step="1"
                                           name="yearFrom" id="formCorpusYearFrom" />
                                </div>
                                <div class="d-flex flex-column w-35">
                                    <small id="yearToHelp" class="form-text text-muted">to</small>
                                    <input class="toBeValidated form-control" placeholder="J J J J" type="number" min="1" max="9999" step="1"
                                           name="yearTo" id="formCorpusYearTo" />
                                </div>
                                <button type="submit" class="toCheckValidation disabled btn btn-sm btn-corpus-dark ml-3 p-0 align-self-end">
                                    <i class="fa fa-angle-right fa-fw fa-2x py-1"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</template>