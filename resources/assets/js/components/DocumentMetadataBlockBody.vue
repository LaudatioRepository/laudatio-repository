<template lang="html">
    <div class="container tab-content">
        <div class="tab-pane fade in active" id="documentMetadata">
            <div class="row">
              <div class="col-sm-3">
                <div class="sidebar-nav">
                    <div class="navbar-collapse collapse sidebar-navbar-collapse">
                      <ul class="nav nav-stacked">
                          <li role="tab" class="nav-link active"><a href="#description" data-toggle="pill">DESCRIPTION</a></li>
                          <li role="tab" class="nav-link"><a href="#authorship" data-toggle="pill">SOURCE DESCRIPTION</a></li>
                          <li role="tab" class="nav-link"><a href="#license" data-toggle="pill">LICENSE / REVISION</a></li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-sm-9">
                <div class="tab-content" v-if="header == 'document'">
                    DOCU
                </div>
              </div>
            </div>

        </div>
        <div class="tab-pane fade" id="annotationMetadata">
        <div class="row">
              <div class="col-sm-3">

                <div class="sidebar-nav">
                    <div class="navbar-collapse collapse sidebar-navbar-collapse">
                      <ul class="nav nav-stacked">
                        <li v-for="(annotationGroup, index) in headerdata.annotationGroups" :class="{ 'active': index === 0 }" class="nav-link" role="tab">
                            <a v-bind:href="('#').concat(annotationGroup.key)" data-toggle="pill">{{annotationGroup.key}}</a>
                        </li>

                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-sm-9">
               <div class="tab-content">
                <div class="tab-pane fade" v-for="(annotationGroup, index) in headerdata.annotationGroups" :id="annotationGroup.key" v-if="header == 'document'" :class="{ 'in active': index === 0 }">
                    {{annotationGroup.key}}
                </div>
                </div>
              </div>
            </div>
         </div>
    </div>
</template>

<script>
    export default {
        props: ['headerdata','header'],
        data: function(){
            return {
                annotators: [],
                revisions: [],
                documentsByAnnotation: []
            }

        },
        computed: {

        },
        mounted() {
            console.log('DocumentMetadataBlockBody mounted.')
        }
    }
</script>