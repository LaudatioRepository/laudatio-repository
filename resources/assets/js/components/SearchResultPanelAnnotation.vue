<template lang="html">



    <div id="searchresultpanelannotation">
        <div class="panel-group" id="accordion">
            <div class="panel panel-default" v-for="annotationresultdata in annotationresult.results" v-bind:key="annotationresultdata._id">
                <div class="panel-heading">
                    <div class="panel-title"  data-toggle="collapse" data-parent="#accordion" v-bind:data-target="annotationresultdata._id | addHash">
                        {{ annotationtitle = annotationresultdata._source.preparation_title | arrayToString  }}
                        <span class="badge">{{ inDocuments = annotationresult.documentsByAnnotation[annotationtitle] }}</span> <i class="fa fa-external-link pull-left" aria-hidden="true"></i>
                    <i class="fa fa-expand pull-right" aria-hidden="true"></i>
                    </div>
                 </div>
                 <div :id="annotationresultdata._id" class="panel-collapse collapse">
                    <div   class="panel-body">
                        <div class="iconwrapper"  v-if="typeof annotationresult.corpusByAnnotation[annotationresultdata._id]  != 'undefined'">
                        In corpora:
                        <ul>
                            <li v-for="(fromCorpus, cIndex) in annotationresult.corpusByAnnotation[annotationresultdata._id]" v-bind:key="cIndex" class="list-unstyled">
                                <i class="fa fa-book" aria-hidden="true"></i> {{ fromCorpus.corpus_title | arrayToString }}
                            </li>
                        </ul>

                        </div>
                        <div class="iconwrapper"  v-if="typeof annotationresult.documentsByAnnotation[annotationresultdata._id]  != 'undefined'">
                        In documents:
                            <ul>
                            <li v-for="(fromDocument,dIndex) in annotationresult.documentsByAnnotation[annotationresultdata._id]" v-bind:key="dIndex" class="list-unstyled">
                                <i class="fa fa-book" aria-hidden="true"></i> {{ fromDocument.document_title | arrayToString }}
                            </li>
                            </ul>
                        </div>
                        <br /> <a v-bind:href="browseUri(annotationresultdata._id)" ><i class="fa fa-external-link pull-right" aria-hidden="true"></i></a>
                    </div>
                 </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        props: ['annotationresult'],
        methods: {
            browseUri: function(id) {
                return '/browse/annotation/'.concat(id);
            }
        },
        mounted() {
            console.log('AnnotationResultComponent mounted.')
        }
    }
</script>
