<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js"></script>
<script>
    tinymce.init({
      selector: '.content-editor',
      plugins: 'image code',
      toolbar: 'undo redo | link image | code',
      /* enable title field in the Image dialog */
      image_title: true,
      /* enable automatic uploads of images represented by blob or data URIs */
      automatic_uploads: true,
      /* URL of your upload handler */
      images_upload_url: 'upload.php',
      /* here we add custom filepicker only to Image dialog */
      file_picker_types: 'image',
      /* and here's our custom image picker */
      file_picker_callback: function (cb, value, meta) {
        var input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/*');
    
        input.onchange = function () {
          var file = this.files[0];
          var reader = new FileReader();
    
          reader.onload = function () {
            var id = 'blobid' + (new Date()).getTime();
            var blobCache = tinymce.activeEditor.editorUpload.blobCache;
            var base64 = reader.result.split(',')[1];
            var blobInfo = blobCache.create(id, file, base64);
            blobCache.add(blobInfo);
    
            /* call the callback and populate the Title field with the file name */
            cb(blobInfo.blobUri(), { title: file.name });
          };
          reader.readAsDataURL(file);
        };
    
        input.click();
      }
    });
</script>
