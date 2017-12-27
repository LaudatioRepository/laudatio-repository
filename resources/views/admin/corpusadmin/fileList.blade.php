
<div class="container-fluid archives">
    FILEZ
    <div id="adminapp">

        <file-upload
                ref="upload"
                v-model="files"
                post-action="/post.method"
                put-action="/put.method"
                @input-file="inputFile"
                @input-filter="inputFilter"
        >
            Upload file
        </file-upload>
        <button v-show="!$refs.upload || !$refs.upload.active" @click.prevent="$refs.upload.active = true" type="button">Start upload</button>
        <button v-show="$refs.upload && $refs.upload.active" @click.prevent="$refs.upload.active = false" type="button">Stop upload</button>
    </div>
</div>