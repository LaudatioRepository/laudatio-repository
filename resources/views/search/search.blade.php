@extends('layouts.search_ux')

@section('content')
    <div class="container-fluid bg-corpus-light">
        <div class="serviceBar withSearch container d-flex justify-content-between align-items-center py-3">

            <div class="container">
                <div class="row">
                    <div class="col-6 d-flex justify-content-center align-items-center ml-auto mr-auto">

                        <form class="form-group serviceBarSearch w-100">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search metadata (German or English)" aria-label="search metadata"
                                       aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button type="button" class="clear-search close" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <button class="btn btn-outline-corpus-dark pl-4 pr-4" type="button">
                                        <i class="text-primary fa fa-fw fa-search fa-lg "></i>
                                    </button>
                                </div>
                            </div>
                        </form>

                        <i class="btn p-0 fa fa-info-circle fa-fw fa-lg ml-3" data-toggle="tooltip" role="button" data-placement="bottom"
                           title="Get help how to search"></i>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="container-fluid">
        <div class="container">
            <div class="row mt-5">
                <div class="col-3 ">
                    <div class="d-flex justify-content-between mt-7 mb-3">
                        <h3 class="h3 font-weight-normal">Filter</h3>
                    </div>
                    <div class="mb-4">
                        <div class="card">
                            <div class="card-header btn bg-corpus-mid font-weight-bold text-uppercase d-flex justify-content-between align-items-center"
                                 data-toggle="collapse" data-target="#formPanelActives" aria-expanded="true" aria-controls="formPanelActives">
                                <span>Active Filter (1)</span>
                                <i class="collapse-indicator fa fa-chevron-circle-down fa-fw fa-lg text-16"></i>
                            </div>
                            <div class="collapse show" id="formPanelActives">
                                <div class="card-body p-1">
                                    <form action="">
                                        <div class="d-flex flex-wrap py-2">
                                            <div class="m-1">
                                                <a href="#" class="badge badge-corpus-mid p-1 text-14 font-weight-normal rounded">
                                                    <i class="fa fa-close fa-fw"></i>
                                                    FilterValue
                                                </a>
                                            </div>
                                            <div class="m-1">
                                                <a href="#" class="badge badge-corpus-mid p-1 text-14 font-weight-normal rounded">
                                                    <i class="fa fa-close fa-fw"></i>
                                                    FilValue
                                                </a>
                                            </div>
                                            <div class="m-1">
                                                <a href="#" class="badge badge-corpus-mid p-1 text-14 font-weight-normal rounded">
                                                    <i class="fa fa-close fa-fw"></i>
                                                    FilterValue 323
                                                </a>
                                            </div>
                                            <div class="m-1">
                                                <a href="#" class="badge badge-corpus-mid p-1 text-14 font-weight-normal rounded">
                                                    <i class="fa fa-close fa-fw"></i>
                                                    14511551
                                                </a>
                                            </div>
                                            <div class="m-1">
                                                <a href="#" class="badge badge-corpus-mid p-1 text-14 font-weight-normal rounded">
                                                    <i class="fa fa-close fa-fw"></i>
                                                    FilterValue
                                                </a>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <a class="align-self-end text-uppercase text-dark text-12 p-2" href="#" role="button">
                                                Clear all Filter
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
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
                    </div>
                    <div class="mb-4">
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
                    </div>
                    <div class="mb-4">
                        <div class="card">
                            <div class="card-header btn bg-corpus-mid font-weight-bold text-uppercase d-flex justify-content-between align-items-center"
                                 data-toggle="collapse" data-target="#formPanelAnnotations" aria-expanded="true" aria-controls="formPanelAnnotations">
                                <span>Annotations</span>
                                <i class="collapse-indicator fa fa-chevron-circle-down fa-fw fa-lg text-16"></i>
                            </div>
                            <div class="collapse show" id="formPanelAnnotations">
                                <div class="card-body px-2">
                                    <form action="">
                                        <div class="form-group mb-3">
                                            <label class="mb-0 text-14 " for="formAnnotationsTitle">Name</label>
                                            <input type="text" class="form-control" id="formAnnotationsTitle" aria-describedby="inputName" placeholder='"Ridges herbology"'>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="mb-0 text-14 " for="formAnnotationsLanguage">Category</label>
                                            <input type="text" class="form-control" id="formAnnotationsLanguage" aria-describedby="inputCategory"
                                                   placeholder='"German"'>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="mb-0 text-14 " for="formAnnotationsFormats">Formats</label>
                                            <input type="text" name="formatslist" multiple="multiple" list="formatsList-Annotations" class="flexdatalist form-control"
                                                   data-min-length="0" id="formAnnotationsFormats">
                                            <datalist id="formatsList-Annotations">
                                                <!--[if IE 9]><select disabled style="display:none" class="ie9_fix"><![endif]-->
                                                <option value="ANNIS">ANNIS</option>
                                                <option value="EXEL">EXEL</option>
                                                <option value="PAULA">PAULA</option>
                                                <option value="Negra">Negra</option>
                                                <option value="TEI-Header">TEI-Header</option>
                                                <!--[if IE 9]></select><![endif]-->
                                            </datalist>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <h3 class="h3 font-weight-normal mb-4">
                        Results</h3>

                    <div class="d-flex justify-content-between my-1">
                        <ul class="nav nav-tabs" id="searchtabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="tab-corpora" data-toggle="tab" href="#searchtab-corpora" role="tab" aria-controls="searchtab-corpora"
                                   aria-selected="true">Corpora (123)</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-documents" data-toggle="tab" href="#searchtab-documents" role="tab" aria-controls="searchtab-documents"
                                   aria-selected="false">Documents (3423)</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-annotations" data-toggle="tab" href="#searchtab-annotations" role="tab" aria-controls="searchtab-annotations"
                                   aria-selected="false">Annotations (3253)</a>
                            </li>
                        </ul>
                        <div class="form-row ">
                            <div class="col-auto">
                                <div class="dropdown">
                                    <button class="btn btn-outline-corpus-dark rounded dropdown-toggle font-weight-bold text-uppercase "
                                            type="button" id="searchSorting" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Title - Alphabetical
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="searchSort">
                                        <a class="dropdown-item text-14" href="#">Title - alphabetical</a>
                                        <a class="dropdown-item text-14" href="#">Tokens - ascending</a>
                                        <a class="dropdown-item text-14" href="#">Tokens - descending</a>
                                        <a class="dropdown-item text-14" href="#">Corpus release - oldest</a>
                                        <a class="dropdown-item text-14" href="#">Corpus release - newest</a>
                                        <a class="dropdown-item text-14" href="#">Date Document - oldest</a>
                                        <a class="dropdown-item text-14" href="#">Date Document - newest</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="w-100 py-3 px-6 mb-1 bg-corpus-light d-flex flex-column">
                        <div class="btn btn-sm font-weight-bold text-uppercase btn-outline-corpus-dark align-self-end disabled">
                            Apply Filter
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane active" id="searchtab-corpora" role="tabpanel" aria-labelledby="searchtab-corpora">
                            <div class="container bg-corpus-superlight mt-1 mb-1 p-5">
                                <div class="row">
                                    <div class="col-2 px-2">
                                        <img class="w-100" src="/images/placeholder_circle.svg" alt="circle-image">
                                    </div>
                                    <div class="col">
                                        <h4 class="h4 font-weight-bold">
                                            <a class="text-dark" href="single_Corpus--fromSearch.html">
                                                RIDGES Herbology, Version 6.0
                                            </a>
                                        </h4>
                                        <span class="text-grey text-14">
        Lüdeling, Anke; Mendel, Frank
      </span>
                                        <div class="row mt-1 ">
                                            <div class="col col-auto mr-1">
                                                <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                                    <i class="fa fa-fw fa-clock-o mr-1"></i>
                                                    <span>
    D. from 1945 - 1950
  </span>
                                                </div> <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                                    <i class="fa fa-fw fa-th-list  mr-1"></i>
                                                    <span>
    Herbology
  </span>
                                                </div>
                                                <div class="mt-2">
                                                    <a class="text-dark text-uppercase search-description-expander" data-toggle="collapse" href="#corpusSearchItem0001"
                                                       role="button" aria-expanded="false" aria-controls="corpusSearchItem0001">
                                                        <i class="fa fa-angle-down fa-fw text-primary font-weight-bold"></i>
                                                        Description
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col col-auto mr-1">
                                                <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                                    <i class="fa fa-fw fa-globe mr-1"></i>
                                                    <span>
    Early New High German
  </span>
                                                </div> <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                                    <i class="fa fa-fw fa-cubes mr-1"></i>
                                                    <span>
    225.000 Tokens
  </span>
                                                </div>
                                                <div class="mt-2"> <a href="#" class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1 ">
                                                        <i class="fa fa-text-height fa-fw fa-file-text-o align-baseline fa-lg text-wine"></i>
                                                        <span class="text-primary text-14 font-weight-bold">500</span>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col col-auto mr-1">
                                                <div class="d-flex justify-content-start align-items-center">
                                                    <img class="py-1" src="/images/license-cc.svg" alt="license cc" /> <img class="py-1" src="/images/license-by.svg" alt="license by" />
                                                </div>
                                                <div class="corpusProp smaller text-14 d-flex align-items-center align-self-start my-1 flex-nowrap">
                                                    <i class="fa fa-fw fa-arrow-up mr-1 border-top border-dark"></i>
                                                    <span>
    2017
  </span>
                                                </div>
                                                <div class="mt-2"> <a href="# " class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1 ">
                                                        <i class="fa fa-text-height fa-fw fa-edit align-text-middle fa-lg text-wine"></i>
                                                        <span class="text-14 font-weight-bold">500</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2 mr-3">
                                        <div class="dropdown">
                                            <button class="btn btn-outline-corpus-dark dropdown-toggle font-weight-bold text-uppercase rounded mb-4"
                                                    type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Download
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item text-14" href="#">TEI-Header</a>
                                                <a class="dropdown-item text-14" href="#">EXCEL</a>
                                                <a class="dropdown-item text-14" href="#">PAULA</a>
                                                <a class="dropdown-item text-14" href="#">ANNIS</a>
                                            </div>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="filtercheck-corpusSearchItem0001">
                                            <label class="custom-control-label text-14" for="filtercheck-corpusSearchItem0001">
                                                Set as Filter
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-2"></div>
                                    <div class="col">
                                        <div id="corpusSearchItem0001" class="collapse row pl-0 pr-3 pb-0">
                                            <hr />
                                            <p>
                                                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Quisquam odit minima necessitatibus atque soluta
                                                voluptatem blanditiis libero ut velit dolorem delectus sed illo, modi debitis unde facilis
                                                nihil inventore architecto! Lorem, ipsum dolor sit amet consectetur adipisicing elit. Deleniti,
                                                obcaecati! Aspernatur vitae amet commodi rem recusandae nisi veniam temporibus. Recusandae,
                                                repudiandae reprehenderit. Distinctio velit consequuntur ea ut tempore. Dolorem, illo. Lorem
                                                ipsum dolor sit amet, consectetur adipisicing elit. Quaerat, molestias esse quo reiciendis
                                                sint quas illum optio nihil, quis nisi atque aliquid nam eius fugit modi quos ex ducimus maxime!
                                                &nbsp;
                                                <a href="#">MORE</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                            </div> <div class="container bg-corpus-superlight mt-1 mb-1 p-5">
                                <div class="row">
                                    <div class="col-2 px-2">
                                        <img class="w-100" src="/images/placeholder_circle.svg" alt="circle-image">
                                    </div>
                                    <div class="col">
                                        <h4 class="h4 font-weight-bold">
                                            <a class="text-dark" href="single_Corpus--fromSearch.html">
                                                RIDGES Herbology, Version 6.0
                                            </a>
                                        </h4>
                                        <span class="text-grey text-14">
        Lüdeling, Anke; Mendel, Frank
      </span>
                                        <div class="row mt-1 ">
                                            <div class="col col-auto mr-1">
                                                <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                                    <i class="fa fa-fw fa-clock-o mr-1"></i>
                                                    <span>
    D. from 1945 - 1950
  </span>
                                                </div> <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                                    <i class="fa fa-fw fa-th-list  mr-1"></i>
                                                    <span>
    Herbology
  </span>
                                                </div>
                                                <div class="mt-2">
                                                    <a class="text-dark text-uppercase search-description-expander" data-toggle="collapse" href="#corpusSearchItem0001"
                                                       role="button" aria-expanded="false" aria-controls="corpusSearchItem0001">
                                                        <i class="fa fa-angle-down fa-fw text-primary font-weight-bold"></i>
                                                        Description
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col col-auto mr-1">
                                                <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                                    <i class="fa fa-fw fa-globe mr-1"></i>
                                                    <span>
    Early New High German
  </span>
                                                </div> <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                                    <i class="fa fa-fw fa-cubes mr-1"></i>
                                                    <span>
    225.000 Tokens
  </span>
                                                </div>
                                                <div class="mt-2"> <a href="#" class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1 ">
                                                        <i class="fa fa-text-height fa-fw fa-file-text-o align-baseline fa-lg text-wine"></i>
                                                        <span class="text-primary text-14 font-weight-bold">500</span>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col col-auto mr-1">
                                                <div class="d-flex justify-content-start align-items-center">
                                                    <img class="py-1" src="/images/license-cc.svg" alt="license cc" /> <img class="py-1" src="/images/license-by.svg" alt="license by" />
                                                </div>
                                                <div class="corpusProp smaller text-14 d-flex align-items-center align-self-start my-1 flex-nowrap">
                                                    <i class="fa fa-fw fa-arrow-up mr-1 border-top border-dark"></i>
                                                    <span>
    2017
  </span>
                                                </div>
                                                <div class="mt-2"> <a href="# " class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1 ">
                                                        <i class="fa fa-text-height fa-fw fa-edit align-text-middle fa-lg text-wine"></i>
                                                        <span class="text-14 font-weight-bold">500</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2 mr-3">
                                        <div class="dropdown">
                                            <button class="btn btn-outline-corpus-dark dropdown-toggle font-weight-bold text-uppercase rounded mb-4"
                                                    type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Download
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item text-14" href="#">TEI-Header</a>
                                                <a class="dropdown-item text-14" href="#">EXCEL</a>
                                                <a class="dropdown-item text-14" href="#">PAULA</a>
                                                <a class="dropdown-item text-14" href="#">ANNIS</a>
                                            </div>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="filtercheck-corpusSearchItem0001">
                                            <label class="custom-control-label text-14" for="filtercheck-corpusSearchItem0001">
                                                Set as Filter
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-2"></div>
                                    <div class="col">
                                        <div id="corpusSearchItem0001" class="collapse row pl-0 pr-3 pb-0">
                                            <hr />
                                            <p>
                                                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Quisquam odit minima necessitatibus atque soluta
                                                voluptatem blanditiis libero ut velit dolorem delectus sed illo, modi debitis unde facilis
                                                nihil inventore architecto! Lorem, ipsum dolor sit amet consectetur adipisicing elit. Deleniti,
                                                obcaecati! Aspernatur vitae amet commodi rem recusandae nisi veniam temporibus. Recusandae,
                                                repudiandae reprehenderit. Distinctio velit consequuntur ea ut tempore. Dolorem, illo. Lorem
                                                ipsum dolor sit amet, consectetur adipisicing elit. Quaerat, molestias esse quo reiciendis
                                                sint quas illum optio nihil, quis nisi atque aliquid nam eius fugit modi quos ex ducimus maxime!
                                                &nbsp;
                                                <a href="#">MORE</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                            </div> <div class="container bg-corpus-superlight mt-1 mb-1 p-5">
                                <div class="row">
                                    <div class="col-2 px-2">
                                        <img class="w-100" src="/images/placeholder_circle.svg" alt="circle-image">
                                    </div>
                                    <div class="col">
                                        <h4 class="h4 font-weight-bold">
                                            <a class="text-dark" href="single_Corpus--fromSearch.html">
                                                RIDGES Herbology, Version 6.0
                                            </a>
                                        </h4>
                                        <span class="text-grey text-14">
        Lüdeling, Anke; Mendel, Frank
      </span>
                                        <div class="row mt-1 ">
                                            <div class="col col-auto mr-1">
                                                <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                                    <i class="fa fa-fw fa-clock-o mr-1"></i>
                                                    <span>
    D. from 1945 - 1950
  </span>
                                                </div> <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                                    <i class="fa fa-fw fa-th-list  mr-1"></i>
                                                    <span>
    Herbology
  </span>
                                                </div>
                                                <div class="mt-2">
                                                    <a class="text-dark text-uppercase search-description-expander" data-toggle="collapse" href="#corpusSearchItem0001"
                                                       role="button" aria-expanded="false" aria-controls="corpusSearchItem0001">
                                                        <i class="fa fa-angle-down fa-fw text-primary font-weight-bold"></i>
                                                        Description
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col col-auto mr-1">
                                                <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                                    <i class="fa fa-fw fa-globe mr-1"></i>
                                                    <span>
    Early New High German
  </span>
                                                </div> <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                                    <i class="fa fa-fw fa-cubes mr-1"></i>
                                                    <span>
    225.000 Tokens
  </span>
                                                </div>
                                                <div class="mt-2"> <a href="#" class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1 ">
                                                        <i class="fa fa-text-height fa-fw fa-file-text-o align-baseline fa-lg text-wine"></i>
                                                        <span class="text-primary text-14 font-weight-bold">500</span>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col col-auto mr-1">
                                                <div class="d-flex justify-content-start align-items-center">
                                                    <img class="py-1" src="/images/license-cc.svg" alt="license cc" /> <img class="py-1" src="/images/license-by.svg" alt="license by" />
                                                </div>
                                                <div class="corpusProp smaller text-14 d-flex align-items-center align-self-start my-1 flex-nowrap">
                                                    <i class="fa fa-fw fa-arrow-up mr-1 border-top border-dark"></i>
                                                    <span>
    2017
  </span>
                                                </div>
                                                <div class="mt-2"> <a href="# " class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1 ">
                                                        <i class="fa fa-text-height fa-fw fa-edit align-text-middle fa-lg text-wine"></i>
                                                        <span class="text-14 font-weight-bold">500</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2 mr-3">
                                        <div class="dropdown">
                                            <button class="btn btn-outline-corpus-dark dropdown-toggle font-weight-bold text-uppercase rounded mb-4"
                                                    type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Download
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item text-14" href="#">TEI-Header</a>
                                                <a class="dropdown-item text-14" href="#">EXCEL</a>
                                                <a class="dropdown-item text-14" href="#">PAULA</a>
                                                <a class="dropdown-item text-14" href="#">ANNIS</a>
                                            </div>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="filtercheck-corpusSearchItem0001">
                                            <label class="custom-control-label text-14" for="filtercheck-corpusSearchItem0001">
                                                Set as Filter
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-2"></div>
                                    <div class="col">
                                        <div id="corpusSearchItem0001" class="collapse row pl-0 pr-3 pb-0">
                                            <hr />
                                            <p>
                                                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Quisquam odit minima necessitatibus atque soluta
                                                voluptatem blanditiis libero ut velit dolorem delectus sed illo, modi debitis unde facilis
                                                nihil inventore architecto! Lorem, ipsum dolor sit amet consectetur adipisicing elit. Deleniti,
                                                obcaecati! Aspernatur vitae amet commodi rem recusandae nisi veniam temporibus. Recusandae,
                                                repudiandae reprehenderit. Distinctio velit consequuntur ea ut tempore. Dolorem, illo. Lorem
                                                ipsum dolor sit amet, consectetur adipisicing elit. Quaerat, molestias esse quo reiciendis
                                                sint quas illum optio nihil, quis nisi atque aliquid nam eius fugit modi quos ex ducimus maxime!
                                                &nbsp;
                                                <a href="#">MORE</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                            </div> <div class="container bg-corpus-superlight mt-1 mb-1 p-5">
                                <div class="row">
                                    <div class="col-2 px-2">
                                        <img class="w-100" src="/images/placeholder_circle.svg" alt="circle-image">
                                    </div>
                                    <div class="col">
                                        <h4 class="h4 font-weight-bold">
                                            <a class="text-dark" href="single_Corpus--fromSearch.html">
                                                RIDGES Herbology, Version 6.0
                                            </a>
                                        </h4>
                                        <span class="text-grey text-14">
        Lüdeling, Anke; Mendel, Frank
      </span>
                                        <div class="row mt-1 ">
                                            <div class="col col-auto mr-1">
                                                <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                                    <i class="fa fa-fw fa-clock-o mr-1"></i>
                                                    <span>
    D. from 1945 - 1950
  </span>
                                                </div> <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                                    <i class="fa fa-fw fa-th-list  mr-1"></i>
                                                    <span>
    Herbology
  </span>
                                                </div>
                                                <div class="mt-2">
                                                    <a class="text-dark text-uppercase search-description-expander" data-toggle="collapse" href="#corpusSearchItem0001"
                                                       role="button" aria-expanded="false" aria-controls="corpusSearchItem0001">
                                                        <i class="fa fa-angle-down fa-fw text-primary font-weight-bold"></i>
                                                        Description
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col col-auto mr-1">
                                                <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                                    <i class="fa fa-fw fa-globe mr-1"></i>
                                                    <span>
    Early New High German
  </span>
                                                </div> <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                                    <i class="fa fa-fw fa-cubes mr-1"></i>
                                                    <span>
    225.000 Tokens
  </span>
                                                </div>
                                                <div class="mt-2"> <a href="#" class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1 ">
                                                        <i class="fa fa-text-height fa-fw fa-file-text-o align-baseline fa-lg text-wine"></i>
                                                        <span class="text-primary text-14 font-weight-bold">500</span>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col col-auto mr-1">
                                                <div class="d-flex justify-content-start align-items-center">
                                                    <img class="py-1" src="/images/license-cc.svg" alt="license cc" /> <img class="py-1" src="/images/license-by.svg" alt="license by" />
                                                </div>
                                                <div class="corpusProp smaller text-14 d-flex align-items-center align-self-start my-1 flex-nowrap">
                                                    <i class="fa fa-fw fa-arrow-up mr-1 border-top border-dark"></i>
                                                    <span>
    2017
  </span>
                                                </div>
                                                <div class="mt-2"> <a href="# " class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1 ">
                                                        <i class="fa fa-text-height fa-fw fa-edit align-text-middle fa-lg text-wine"></i>
                                                        <span class="text-14 font-weight-bold">500</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2 mr-3">
                                        <div class="dropdown">
                                            <button class="btn btn-outline-corpus-dark dropdown-toggle font-weight-bold text-uppercase rounded mb-4"
                                                    type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Download
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item text-14" href="#">TEI-Header</a>
                                                <a class="dropdown-item text-14" href="#">EXCEL</a>
                                                <a class="dropdown-item text-14" href="#">PAULA</a>
                                                <a class="dropdown-item text-14" href="#">ANNIS</a>
                                            </div>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="filtercheck-corpusSearchItem0001">
                                            <label class="custom-control-label text-14" for="filtercheck-corpusSearchItem0001">
                                                Set as Filter
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-2"></div>
                                    <div class="col">
                                        <div id="corpusSearchItem0001" class="collapse row pl-0 pr-3 pb-0">
                                            <hr />
                                            <p>
                                                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Quisquam odit minima necessitatibus atque soluta
                                                voluptatem blanditiis libero ut velit dolorem delectus sed illo, modi debitis unde facilis
                                                nihil inventore architecto! Lorem, ipsum dolor sit amet consectetur adipisicing elit. Deleniti,
                                                obcaecati! Aspernatur vitae amet commodi rem recusandae nisi veniam temporibus. Recusandae,
                                                repudiandae reprehenderit. Distinctio velit consequuntur ea ut tempore. Dolorem, illo. Lorem
                                                ipsum dolor sit amet, consectetur adipisicing elit. Quaerat, molestias esse quo reiciendis
                                                sint quas illum optio nihil, quis nisi atque aliquid nam eius fugit modi quos ex ducimus maxime!
                                                &nbsp;
                                                <a href="#">MORE</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                            </div> <div class="container bg-corpus-superlight mt-1 mb-1 p-5">
                                <div class="row">
                                    <div class="col-2 px-2">
                                        <img class="w-100" src="/images/placeholder_circle.svg" alt="circle-image">
                                    </div>
                                    <div class="col">
                                        <h4 class="h4 font-weight-bold">
                                            <a class="text-dark" href="single_Corpus--fromSearch.html">
                                                RIDGES Herbology, Version 6.0
                                            </a>
                                        </h4>
                                        <span class="text-grey text-14">
        Lüdeling, Anke; Mendel, Frank
      </span>
                                        <div class="row mt-1 ">
                                            <div class="col col-auto mr-1">
                                                <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                                    <i class="fa fa-fw fa-clock-o mr-1"></i>
                                                    <span>
    D. from 1945 - 1950
  </span>
                                                </div> <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                                    <i class="fa fa-fw fa-th-list  mr-1"></i>
                                                    <span>
    Herbology
  </span>
                                                </div>
                                                <div class="mt-2">
                                                    <a class="text-dark text-uppercase search-description-expander" data-toggle="collapse" href="#corpusSearchItem0001"
                                                       role="button" aria-expanded="false" aria-controls="corpusSearchItem0001">
                                                        <i class="fa fa-angle-down fa-fw text-primary font-weight-bold"></i>
                                                        Description
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col col-auto mr-1">
                                                <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                                    <i class="fa fa-fw fa-globe mr-1"></i>
                                                    <span>
    Early New High German
  </span>
                                                </div> <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                                    <i class="fa fa-fw fa-cubes mr-1"></i>
                                                    <span>
    225.000 Tokens
  </span>
                                                </div>
                                                <div class="mt-2"> <a href="#" class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1 ">
                                                        <i class="fa fa-text-height fa-fw fa-file-text-o align-baseline fa-lg text-wine"></i>
                                                        <span class="text-primary text-14 font-weight-bold">500</span>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col col-auto mr-1">
                                                <div class="d-flex justify-content-start align-items-center">
                                                    <img class="py-1" src="/images/license-cc.svg" alt="license cc" /> <img class="py-1" src="/images/license-by.svg" alt="license by" />
                                                </div>
                                                <div class="corpusProp smaller text-14 d-flex align-items-center align-self-start my-1 flex-nowrap">
                                                    <i class="fa fa-fw fa-arrow-up mr-1 border-top border-dark"></i>
                                                    <span>
    2017
  </span>
                                                </div>
                                                <div class="mt-2"> <a href="# " class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1 ">
                                                        <i class="fa fa-text-height fa-fw fa-edit align-text-middle fa-lg text-wine"></i>
                                                        <span class="text-14 font-weight-bold">500</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2 mr-3">
                                        <div class="dropdown">
                                            <button class="btn btn-outline-corpus-dark dropdown-toggle font-weight-bold text-uppercase rounded mb-4"
                                                    type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Download
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item text-14" href="#">TEI-Header</a>
                                                <a class="dropdown-item text-14" href="#">EXCEL</a>
                                                <a class="dropdown-item text-14" href="#">PAULA</a>
                                                <a class="dropdown-item text-14" href="#">ANNIS</a>
                                            </div>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="filtercheck-corpusSearchItem0001">
                                            <label class="custom-control-label text-14" for="filtercheck-corpusSearchItem0001">
                                                Set as Filter
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-2"></div>
                                    <div class="col">
                                        <div id="corpusSearchItem0001" class="collapse row pl-0 pr-3 pb-0">
                                            <hr />
                                            <p>
                                                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Quisquam odit minima necessitatibus atque soluta
                                                voluptatem blanditiis libero ut velit dolorem delectus sed illo, modi debitis unde facilis
                                                nihil inventore architecto! Lorem, ipsum dolor sit amet consectetur adipisicing elit. Deleniti,
                                                obcaecati! Aspernatur vitae amet commodi rem recusandae nisi veniam temporibus. Recusandae,
                                                repudiandae reprehenderit. Distinctio velit consequuntur ea ut tempore. Dolorem, illo. Lorem
                                                ipsum dolor sit amet, consectetur adipisicing elit. Quaerat, molestias esse quo reiciendis
                                                sint quas illum optio nihil, quis nisi atque aliquid nam eius fugit modi quos ex ducimus maxime!
                                                &nbsp;
                                                <a href="#">MORE</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                            </div> <div class="container bg-corpus-superlight mt-1 mb-1 p-5">
                                <div class="row">
                                    <div class="col-2 px-2">
                                        <img class="w-100" src="/images/placeholder_circle.svg" alt="circle-image">
                                    </div>
                                    <div class="col">
                                        <h4 class="h4 font-weight-bold">
                                            <a class="text-dark" href="single_Corpus--fromSearch.html">
                                                RIDGES Herbology, Version 6.0
                                            </a>
                                        </h4>
                                        <span class="text-grey text-14">
        Lüdeling, Anke; Mendel, Frank
      </span>
                                        <div class="row mt-1 ">
                                            <div class="col col-auto mr-1">
                                                <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                                    <i class="fa fa-fw fa-clock-o mr-1"></i>
                                                    <span>
    D. from 1945 - 1950
  </span>
                                                </div> <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                                    <i class="fa fa-fw fa-th-list  mr-1"></i>
                                                    <span>
    Herbology
  </span>
                                                </div>
                                                <div class="mt-2">
                                                    <a class="text-dark text-uppercase search-description-expander" data-toggle="collapse" href="#corpusSearchItem0001"
                                                       role="button" aria-expanded="false" aria-controls="corpusSearchItem0001">
                                                        <i class="fa fa-angle-down fa-fw text-primary font-weight-bold"></i>
                                                        Description
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col col-auto mr-1">
                                                <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                                    <i class="fa fa-fw fa-globe mr-1"></i>
                                                    <span>
    Early New High German
  </span>
                                                </div> <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                                    <i class="fa fa-fw fa-cubes mr-1"></i>
                                                    <span>
    225.000 Tokens
  </span>
                                                </div>
                                                <div class="mt-2"> <a href="#" class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1 ">
                                                        <i class="fa fa-text-height fa-fw fa-file-text-o align-baseline fa-lg text-wine"></i>
                                                        <span class="text-primary text-14 font-weight-bold">500</span>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col col-auto mr-1">
                                                <div class="d-flex justify-content-start align-items-center">
                                                    <img class="py-1" src="/images/license-cc.svg" alt="license cc" /> <img class="py-1" src="/images/license-by.svg" alt="license by" />
                                                </div>
                                                <div class="corpusProp smaller text-14 d-flex align-items-center align-self-start my-1 flex-nowrap">
                                                    <i class="fa fa-fw fa-arrow-up mr-1 border-top border-dark"></i>
                                                    <span>
    2017
  </span>
                                                </div>
                                                <div class="mt-2"> <a href="# " class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1 ">
                                                        <i class="fa fa-text-height fa-fw fa-edit align-text-middle fa-lg text-wine"></i>
                                                        <span class="text-14 font-weight-bold">500</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2 mr-3">
                                        <div class="dropdown">
                                            <button class="btn btn-outline-corpus-dark dropdown-toggle font-weight-bold text-uppercase rounded mb-4"
                                                    type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Download
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item text-14" href="#">TEI-Header</a>
                                                <a class="dropdown-item text-14" href="#">EXCEL</a>
                                                <a class="dropdown-item text-14" href="#">PAULA</a>
                                                <a class="dropdown-item text-14" href="#">ANNIS</a>
                                            </div>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="filtercheck-corpusSearchItem0001">
                                            <label class="custom-control-label text-14" for="filtercheck-corpusSearchItem0001">
                                                Set as Filter
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-2"></div>
                                    <div class="col">
                                        <div id="corpusSearchItem0001" class="collapse row pl-0 pr-3 pb-0">
                                            <hr />
                                            <p>
                                                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Quisquam odit minima necessitatibus atque soluta
                                                voluptatem blanditiis libero ut velit dolorem delectus sed illo, modi debitis unde facilis
                                                nihil inventore architecto! Lorem, ipsum dolor sit amet consectetur adipisicing elit. Deleniti,
                                                obcaecati! Aspernatur vitae amet commodi rem recusandae nisi veniam temporibus. Recusandae,
                                                repudiandae reprehenderit. Distinctio velit consequuntur ea ut tempore. Dolorem, illo. Lorem
                                                ipsum dolor sit amet, consectetur adipisicing elit. Quaerat, molestias esse quo reiciendis
                                                sint quas illum optio nihil, quis nisi atque aliquid nam eius fugit modi quos ex ducimus maxime!
                                                &nbsp;
                                                <a href="#">MORE</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                            </div> <div class="container d-flex flex-column align-items-center justify-content-center mb-5 mt-5">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination">
                                        <li class="page-item">
                                            <a class="page-link" href="#" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                        </li>
                                        <li class="page-item font-weight-bold active">
                                            <a class="page-link" href="#">1</a>
                                        </li>
                                        <li class="page-item font-weight-bold">
                                            <a class="page-link" href="#">2</a>
                                        </li>
                                        <li class="page-item font-weight-bold">
                                            <a class="page-link" href="#">3</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="#" aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                                <div class="form-row">
                                    <div class="col-auto">

                                        <select class="custom-select custom-select-sm font-weight-bold text-uppercase">
                                            <option selected>6 results / page</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="searchtab-documents" role="tabpanel" aria-labelledby="searchtab-documents">
                            <div class="container bg-corpus-superlight mt-1 mb-1 p-5">
                                <div class="row">
                                    <div class="col">
                                        <h4 class="h4 font-weight-bold">
                                            <a class="text-dark" href="document_Metadata--fromSearch.html">
                                                Alchimistische Praktik (Vorrede)
                                            </a>
                                        </h4>
                                        <span class="text-grey text-14">
        Corpus: RIDGES-Herbology
        <br> Lüdeling, Anke; Mendel, Frank

      </span>
                                        <div class="row mt-2">
                                            <div class="col d-flex flex-wrap justify-content-start">
                                                <div class="mr-7">
                                                    <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                                        <i class="fa fa-fw fa-clock-o mr-1"></i>
                                                        <span>
    D. from 1945 - 1950
  </span>
                                                    </div>
                                                </div> <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                                    <i class="fa fa-fw fa-cubes mr-1"></i>
                                                    <span>
    225.000 Tokens
  </span>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4 mr-3 d-flex justify-content-between align-items-start">
                                        <a href="# " class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1 ">
                                            <i class="fa fa-text-height fa-fw fa-edit align-text-middle fa-lg text-wine"></i>
                                            <span class="text-14 font-weight-bold">500</span>
                                        </a>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="filtercheck-documentSearchItem0001">
                                            <label class="custom-control-label text-14" for="filtercheck-documentSearchItem0001">
                                                Set as Filter
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            </div> <div class="container bg-corpus-superlight mt-1 mb-1 p-5">
                                <div class="row">
                                    <div class="col">
                                        <h4 class="h4 font-weight-bold">
                                            <a class="text-dark" href="document_Metadata--fromSearch.html">
                                                Alchimistische Praktik (Vorrede)
                                            </a>
                                        </h4>
                                        <span class="text-grey text-14">
        Corpus: RIDGES-Herbology
        <br> Lüdeling, Anke; Mendel, Frank

      </span>
                                        <div class="row mt-2">
                                            <div class="col d-flex flex-wrap justify-content-start">
                                                <div class="mr-7">
                                                    <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                                        <i class="fa fa-fw fa-clock-o mr-1"></i>
                                                        <span>
    D. from 1945 - 1950
  </span>
                                                    </div>
                                                </div> <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                                    <i class="fa fa-fw fa-cubes mr-1"></i>
                                                    <span>
    225.000 Tokens
  </span>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4 mr-3 d-flex justify-content-between align-items-start">
                                        <a href="# " class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1 ">
                                            <i class="fa fa-text-height fa-fw fa-edit align-text-middle fa-lg text-wine"></i>
                                            <span class="text-14 font-weight-bold">500</span>
                                        </a>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="filtercheck-documentSearchItem0001">
                                            <label class="custom-control-label text-14" for="filtercheck-documentSearchItem0001">
                                                Set as Filter
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            </div> <div class="container bg-corpus-superlight mt-1 mb-1 p-5">
                                <div class="row">
                                    <div class="col">
                                        <h4 class="h4 font-weight-bold">
                                            <a class="text-dark" href="document_Metadata--fromSearch.html">
                                                Alchimistische Praktik (Vorrede)
                                            </a>
                                        </h4>
                                        <span class="text-grey text-14">
        Corpus: RIDGES-Herbology
        <br> Lüdeling, Anke; Mendel, Frank

      </span>
                                        <div class="row mt-2">
                                            <div class="col d-flex flex-wrap justify-content-start">
                                                <div class="mr-7">
                                                    <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                                        <i class="fa fa-fw fa-clock-o mr-1"></i>
                                                        <span>
    D. from 1945 - 1950
  </span>
                                                    </div>
                                                </div> <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                                    <i class="fa fa-fw fa-cubes mr-1"></i>
                                                    <span>
    225.000 Tokens
  </span>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4 mr-3 d-flex justify-content-between align-items-start">
                                        <a href="# " class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1 ">
                                            <i class="fa fa-text-height fa-fw fa-edit align-text-middle fa-lg text-wine"></i>
                                            <span class="text-14 font-weight-bold">500</span>
                                        </a>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="filtercheck-documentSearchItem0001">
                                            <label class="custom-control-label text-14" for="filtercheck-documentSearchItem0001">
                                                Set as Filter
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            </div> <div class="container bg-corpus-superlight mt-1 mb-1 p-5">
                                <div class="row">
                                    <div class="col">
                                        <h4 class="h4 font-weight-bold">
                                            <a class="text-dark" href="document_Metadata--fromSearch.html">
                                                Alchimistische Praktik (Vorrede)
                                            </a>
                                        </h4>
                                        <span class="text-grey text-14">
        Corpus: RIDGES-Herbology
        <br> Lüdeling, Anke; Mendel, Frank

      </span>
                                        <div class="row mt-2">
                                            <div class="col d-flex flex-wrap justify-content-start">
                                                <div class="mr-7">
                                                    <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                                        <i class="fa fa-fw fa-clock-o mr-1"></i>
                                                        <span>
    D. from 1945 - 1950
  </span>
                                                    </div>
                                                </div> <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                                    <i class="fa fa-fw fa-cubes mr-1"></i>
                                                    <span>
    225.000 Tokens
  </span>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4 mr-3 d-flex justify-content-between align-items-start">
                                        <a href="# " class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1 ">
                                            <i class="fa fa-text-height fa-fw fa-edit align-text-middle fa-lg text-wine"></i>
                                            <span class="text-14 font-weight-bold">500</span>
                                        </a>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="filtercheck-documentSearchItem0001">
                                            <label class="custom-control-label text-14" for="filtercheck-documentSearchItem0001">
                                                Set as Filter
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            </div> <div class="container bg-corpus-superlight mt-1 mb-1 p-5">
                                <div class="row">
                                    <div class="col">
                                        <h4 class="h4 font-weight-bold">
                                            <a class="text-dark" href="document_Metadata--fromSearch.html">
                                                Alchimistische Praktik (Vorrede)
                                            </a>
                                        </h4>
                                        <span class="text-grey text-14">
        Corpus: RIDGES-Herbology
        <br> Lüdeling, Anke; Mendel, Frank

      </span>
                                        <div class="row mt-2">
                                            <div class="col d-flex flex-wrap justify-content-start">
                                                <div class="mr-7">
                                                    <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                                        <i class="fa fa-fw fa-clock-o mr-1"></i>
                                                        <span>
    D. from 1945 - 1950
  </span>
                                                    </div>
                                                </div> <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                                    <i class="fa fa-fw fa-cubes mr-1"></i>
                                                    <span>
    225.000 Tokens
  </span>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4 mr-3 d-flex justify-content-between align-items-start">
                                        <a href="# " class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1 ">
                                            <i class="fa fa-text-height fa-fw fa-edit align-text-middle fa-lg text-wine"></i>
                                            <span class="text-14 font-weight-bold">500</span>
                                        </a>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="filtercheck-documentSearchItem0001">
                                            <label class="custom-control-label text-14" for="filtercheck-documentSearchItem0001">
                                                Set as Filter
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            </div> <div class="container bg-corpus-superlight mt-1 mb-1 p-5">
                                <div class="row">
                                    <div class="col">
                                        <h4 class="h4 font-weight-bold">
                                            <a class="text-dark" href="document_Metadata--fromSearch.html">
                                                Alchimistische Praktik (Vorrede)
                                            </a>
                                        </h4>
                                        <span class="text-grey text-14">
        Corpus: RIDGES-Herbology
        <br> Lüdeling, Anke; Mendel, Frank

      </span>
                                        <div class="row mt-2">
                                            <div class="col d-flex flex-wrap justify-content-start">
                                                <div class="mr-7">
                                                    <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                                        <i class="fa fa-fw fa-clock-o mr-1"></i>
                                                        <span>
    D. from 1945 - 1950
  </span>
                                                    </div>
                                                </div> <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                                    <i class="fa fa-fw fa-cubes mr-1"></i>
                                                    <span>
    225.000 Tokens
  </span>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4 mr-3 d-flex justify-content-between align-items-start">
                                        <a href="# " class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1 ">
                                            <i class="fa fa-text-height fa-fw fa-edit align-text-middle fa-lg text-wine"></i>
                                            <span class="text-14 font-weight-bold">500</span>
                                        </a>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="filtercheck-documentSearchItem0001">
                                            <label class="custom-control-label text-14" for="filtercheck-documentSearchItem0001">
                                                Set as Filter
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            </div> <div class="container bg-corpus-superlight mt-1 mb-1 p-5">
                                <div class="row">
                                    <div class="col">
                                        <h4 class="h4 font-weight-bold">
                                            <a class="text-dark" href="document_Metadata--fromSearch.html">
                                                Alchimistische Praktik (Vorrede)
                                            </a>
                                        </h4>
                                        <span class="text-grey text-14">
        Corpus: RIDGES-Herbology
        <br> Lüdeling, Anke; Mendel, Frank

      </span>
                                        <div class="row mt-2">
                                            <div class="col d-flex flex-wrap justify-content-start">
                                                <div class="mr-7">
                                                    <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                                        <i class="fa fa-fw fa-clock-o mr-1"></i>
                                                        <span>
    D. from 1945 - 1950
  </span>
                                                    </div>
                                                </div> <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                                    <i class="fa fa-fw fa-cubes mr-1"></i>
                                                    <span>
    225.000 Tokens
  </span>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4 mr-3 d-flex justify-content-between align-items-start">
                                        <a href="# " class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1 ">
                                            <i class="fa fa-text-height fa-fw fa-edit align-text-middle fa-lg text-wine"></i>
                                            <span class="text-14 font-weight-bold">500</span>
                                        </a>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="filtercheck-documentSearchItem0001">
                                            <label class="custom-control-label text-14" for="filtercheck-documentSearchItem0001">
                                                Set as Filter
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            </div> <div class="container bg-corpus-superlight mt-1 mb-1 p-5">
                                <div class="row">
                                    <div class="col">
                                        <h4 class="h4 font-weight-bold">
                                            <a class="text-dark" href="document_Metadata--fromSearch.html">
                                                Alchimistische Praktik (Vorrede)
                                            </a>
                                        </h4>
                                        <span class="text-grey text-14">
        Corpus: RIDGES-Herbology
        <br> Lüdeling, Anke; Mendel, Frank

      </span>
                                        <div class="row mt-2">
                                            <div class="col d-flex flex-wrap justify-content-start">
                                                <div class="mr-7">
                                                    <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                                        <i class="fa fa-fw fa-clock-o mr-1"></i>
                                                        <span>
    D. from 1945 - 1950
  </span>
                                                    </div>
                                                </div> <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                                    <i class="fa fa-fw fa-cubes mr-1"></i>
                                                    <span>
    225.000 Tokens
  </span>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4 mr-3 d-flex justify-content-between align-items-start">
                                        <a href="# " class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1 ">
                                            <i class="fa fa-text-height fa-fw fa-edit align-text-middle fa-lg text-wine"></i>
                                            <span class="text-14 font-weight-bold">500</span>
                                        </a>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="filtercheck-documentSearchItem0001">
                                            <label class="custom-control-label text-14" for="filtercheck-documentSearchItem0001">
                                                Set as Filter
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            </div> <div class="container d-flex flex-column align-items-center justify-content-center mb-5 mt-5">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination">
                                        <li class="page-item">
                                            <a class="page-link" href="#" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                        </li>
                                        <li class="page-item font-weight-bold active">
                                            <a class="page-link" href="#">1</a>
                                        </li>
                                        <li class="page-item font-weight-bold">
                                            <a class="page-link" href="#">2</a>
                                        </li>
                                        <li class="page-item font-weight-bold">
                                            <a class="page-link" href="#">3</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="#" aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                                <div class="form-row">
                                    <div class="col-auto">

                                        <select class="custom-select custom-select-sm font-weight-bold text-uppercase">
                                            <option selected>6 results / page</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="searchtab-annotations" role="tabpanel" aria-labelledby="searchtab-annotations">
                            <div class="container bg-corpus-superlight mt-1 mb-1 p-5">
                                <div class="row">
                                    <div class="col">
                                        <h4 class="h4 font-weight-bold">
                                            <a class="text-dark" href="annotation_Guidelines--fromSearch.html">
                                                pos
                                            </a>
                                        </h4>
                                        <span class="text-grey text-14">
        Corpus: RIDGES-Herbology
      </span>
                                    </div>
                                    <div class="col-2">
                                        <span class="text-grey text-14">Lexical</span>
                                    </div>
                                    <div class="col-4 d-flex justify-content-between align-items-start">
                                        <a href="#" class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1 ">
                                            <i class="fa fa-text-height fa-fw fa-file-text-o align-baseline fa-lg text-wine"></i>
                                            <span class="text-primary text-14 font-weight-bold">500</span>
                                        </a>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="filtercheck-annotationSearchItem0001">
                                            <label class="custom-control-label text-14" for="filtercheck-annotationSearchItem0001">
                                                Set as Filter
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            </div> <div class="container bg-corpus-superlight mt-1 mb-1 p-5">
                                <div class="row">
                                    <div class="col">
                                        <h4 class="h4 font-weight-bold">
                                            <a class="text-dark" href="annotation_Guidelines--fromSearch.html">
                                                pos
                                            </a>
                                        </h4>
                                        <span class="text-grey text-14">
        Corpus: RIDGES-Herbology
      </span>
                                    </div>
                                    <div class="col-2">
                                        <span class="text-grey text-14">Lexical</span>
                                    </div>
                                    <div class="col-4 d-flex justify-content-between align-items-start">
                                        <a href="#" class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1 ">
                                            <i class="fa fa-text-height fa-fw fa-file-text-o align-baseline fa-lg text-wine"></i>
                                            <span class="text-primary text-14 font-weight-bold">500</span>
                                        </a>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="filtercheck-annotationSearchItem0001">
                                            <label class="custom-control-label text-14" for="filtercheck-annotationSearchItem0001">
                                                Set as Filter
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            </div> <div class="container bg-corpus-superlight mt-1 mb-1 p-5">
                                <div class="row">
                                    <div class="col">
                                        <h4 class="h4 font-weight-bold">
                                            <a class="text-dark" href="annotation_Guidelines--fromSearch.html">
                                                pos
                                            </a>
                                        </h4>
                                        <span class="text-grey text-14">
        Corpus: RIDGES-Herbology
      </span>
                                    </div>
                                    <div class="col-2">
                                        <span class="text-grey text-14">Lexical</span>
                                    </div>
                                    <div class="col-4 d-flex justify-content-between align-items-start">
                                        <a href="#" class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1 ">
                                            <i class="fa fa-text-height fa-fw fa-file-text-o align-baseline fa-lg text-wine"></i>
                                            <span class="text-primary text-14 font-weight-bold">500</span>
                                        </a>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="filtercheck-annotationSearchItem0001">
                                            <label class="custom-control-label text-14" for="filtercheck-annotationSearchItem0001">
                                                Set as Filter
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            </div> <div class="container bg-corpus-superlight mt-1 mb-1 p-5">
                                <div class="row">
                                    <div class="col">
                                        <h4 class="h4 font-weight-bold">
                                            <a class="text-dark" href="annotation_Guidelines--fromSearch.html">
                                                pos
                                            </a>
                                        </h4>
                                        <span class="text-grey text-14">
        Corpus: RIDGES-Herbology
      </span>
                                    </div>
                                    <div class="col-2">
                                        <span class="text-grey text-14">Lexical</span>
                                    </div>
                                    <div class="col-4 d-flex justify-content-between align-items-start">
                                        <a href="#" class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1 ">
                                            <i class="fa fa-text-height fa-fw fa-file-text-o align-baseline fa-lg text-wine"></i>
                                            <span class="text-primary text-14 font-weight-bold">500</span>
                                        </a>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="filtercheck-annotationSearchItem0001">
                                            <label class="custom-control-label text-14" for="filtercheck-annotationSearchItem0001">
                                                Set as Filter
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            </div> <div class="container bg-corpus-superlight mt-1 mb-1 p-5">
                                <div class="row">
                                    <div class="col">
                                        <h4 class="h4 font-weight-bold">
                                            <a class="text-dark" href="annotation_Guidelines--fromSearch.html">
                                                pos
                                            </a>
                                        </h4>
                                        <span class="text-grey text-14">
        Corpus: RIDGES-Herbology
      </span>
                                    </div>
                                    <div class="col-2">
                                        <span class="text-grey text-14">Lexical</span>
                                    </div>
                                    <div class="col-4 d-flex justify-content-between align-items-start">
                                        <a href="#" class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1 ">
                                            <i class="fa fa-text-height fa-fw fa-file-text-o align-baseline fa-lg text-wine"></i>
                                            <span class="text-primary text-14 font-weight-bold">500</span>
                                        </a>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="filtercheck-annotationSearchItem0001">
                                            <label class="custom-control-label text-14" for="filtercheck-annotationSearchItem0001">
                                                Set as Filter
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            </div> <div class="container bg-corpus-superlight mt-1 mb-1 p-5">
                                <div class="row">
                                    <div class="col">
                                        <h4 class="h4 font-weight-bold">
                                            <a class="text-dark" href="annotation_Guidelines--fromSearch.html">
                                                pos
                                            </a>
                                        </h4>
                                        <span class="text-grey text-14">
        Corpus: RIDGES-Herbology
      </span>
                                    </div>
                                    <div class="col-2">
                                        <span class="text-grey text-14">Lexical</span>
                                    </div>
                                    <div class="col-4 d-flex justify-content-between align-items-start">
                                        <a href="#" class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1 ">
                                            <i class="fa fa-text-height fa-fw fa-file-text-o align-baseline fa-lg text-wine"></i>
                                            <span class="text-primary text-14 font-weight-bold">500</span>
                                        </a>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="filtercheck-annotationSearchItem0001">
                                            <label class="custom-control-label text-14" for="filtercheck-annotationSearchItem0001">
                                                Set as Filter
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            </div> <div class="container bg-corpus-superlight mt-1 mb-1 p-5">
                                <div class="row">
                                    <div class="col">
                                        <h4 class="h4 font-weight-bold">
                                            <a class="text-dark" href="annotation_Guidelines--fromSearch.html">
                                                pos
                                            </a>
                                        </h4>
                                        <span class="text-grey text-14">
        Corpus: RIDGES-Herbology
      </span>
                                    </div>
                                    <div class="col-2">
                                        <span class="text-grey text-14">Lexical</span>
                                    </div>
                                    <div class="col-4 d-flex justify-content-between align-items-start">
                                        <a href="#" class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1 ">
                                            <i class="fa fa-text-height fa-fw fa-file-text-o align-baseline fa-lg text-wine"></i>
                                            <span class="text-primary text-14 font-weight-bold">500</span>
                                        </a>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="filtercheck-annotationSearchItem0001">
                                            <label class="custom-control-label text-14" for="filtercheck-annotationSearchItem0001">
                                                Set as Filter
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            </div> <div class="container d-flex flex-column align-items-center justify-content-center mb-5 mt-5">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination">
                                        <li class="page-item">
                                            <a class="page-link" href="#" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                        </li>
                                        <li class="page-item font-weight-bold active">
                                            <a class="page-link" href="#">1</a>
                                        </li>
                                        <li class="page-item font-weight-bold">
                                            <a class="page-link" href="#">2</a>
                                        </li>
                                        <li class="page-item font-weight-bold">
                                            <a class="page-link" href="#">3</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="#" aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                                <div class="form-row">
                                    <div class="col-auto">

                                        <select class="custom-select custom-select-sm font-weight-bold text-uppercase">
                                            <option selected>6 results / page</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>
@endsection
