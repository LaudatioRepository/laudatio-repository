<template>
    <div class="card">
        <div class="card-header btn bg-corpus-mid font-weight-bold text-uppercase d-flex justify-content-between align-items-center"
             data-toggle="collapse" data-target="#formPanelDocuments" aria-expanded="true" aria-controls="formPanelDocuments">
            <span>Documents</span>
            <i class="collapse-indicator fa fa-chevron-circle-down fa-fw fa-lg text-16"></i>
        </div>
        <div class="collapse show" id="formPanelDocuments">
            <div class="card-body px-2">
                <form action="">
                    <div class="form-group mb-3">
                        <label class="mb-0 text-14 " for="formDocumentsTitle">Title</label>
                        <input type="text" class="form-control" id="formDocumentsTitle" aria-describedby="inputTitle" placeholder='"Ridges herbology"'>
                    </div>

                    <div class="form-group mb-3">
                        <label class="mb-0 text-14 " for="formDocumentsAuthor">Author</label>
                        <input type="text" class="form-control" id="formDocumentsAuthor" aria-describedby="inputAuthor" placeholder='"Frank Mann"'>
                    </div>



                    <div class="d-flex flex-column">
                        <a class="align-self-end text-uppercase text-dark text-14 filter-expander" data-toggle="collapse" href="#"
                           data-target=".formPanelDocuments-all" role="button" aria-expanded="false" aria-controls="#formPanelDocuments-all1 #formPanelDocuments-all2">
                            + Show all Documentsfilter
                        </a>
                    </div>

                    <div id="formPanelDocuments-all1" class="collapse formPanelDocuments-all">

                        <div class="form-group mb-3">
                            <label class="mb-0 text-14 " for="formDocumentsLanguage">Language</label>
                            <input type="text" class="form-control" id="formDocumentsLanguage" aria-describedby="inputLanguage" placeholder='"German"'>
                        </div>

                        <div class="form-group mb-3">
                            <label class="mb-0 text-14 " for="formDocumentsPlace">Place</label>
                            <input type="text" class="form-control" id="formDocumentsPlace" aria-describedby="inputPlace" placeholder='"Mannheim"'>
                        </div>

                    </div>
                </form>

                <div id="formPanelDocuments-all2" class="collapse formPanelDocuments-all">


                    <form action="">
                        <div class="form-group mb-3">
                            <label class="mb-2 text-14 " for="dd">Documents size (Tokens, Words)</label>
                            <div class="d-flex justify-content-between">
                                <div class="w-75">
                                    <div id="documentSize"></div>
                                    <div class="d-flex justify-content-between w-100 text-dark font-weight-bold text-14">
                <span id="documentSize-minVal">
                </span>
                                        <span id="documentSize-maxVal">
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
                            <label class="mb-0 text-14 " for="formDocumentsYear">Year of Publication</label>
                            <div class="d-flex justify-content-between">
                                <div class="d-flex flex-column w-35">
                                    <small id="yearFromHelp" class="form-text text-muted">from</small>
                                    <input class="toBeValidated form-control" placeholder="J J J J" type="number" min="1" max="9999" step="1"
                                           name="yearFrom" id="formDocumentsYearFrom" />
                                </div>
                                <div class="d-flex flex-column w-35">
                                    <small id="yearToHelp" class="form-text text-muted">to</small>
                                    <input class="toBeValidated form-control" placeholder="J J J J" type="number" min="1" max="9999" step="1"
                                           name="yearTo" id="formDocumentsYearTo" />
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