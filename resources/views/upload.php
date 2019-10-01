<input type="files" id="selector">
<button onclick="upload()">Upload</button>

<div id="status">No uploads</div>

<script type="text/javascript">
  // `upload` iterates through all files selected and invokes a helper function called `retrieveNewURL`.
  function upload() {
    // Get selected files from the input element.
    var files = document.querySelector("#selector").files;
    for (var i = 0; i < files.length; i++) {
      var file = files[i];
      // Retrieve a URL from our server.
      console.log('hello')
      retrieveNewURL(file, (file, url) => {
        // Upload the file to the server.
        console.log(file, url);
        uploadFile(file, url);
      });
    }
  }

// CHANGED THIS TO USE THE URL FROM THE VARIABLE INSTEAD FOR LARAVEL

  // `retrieveNewURL` accepts the name of the current file and invokes the `/presignedUrl` endpoint to
  // generate a pre-signed URL for use in uploading that file:
  function retrieveNewURL(file, cb) {
    cb(file, '{{$url}}')

    // fetch(`/presignedUrl?name=${file.name}`).then((response) => {
    //   response.text().then((url) => {
    //     cb(file, url);
    //   });
    // }).catch((e) => {
    //   console.error(e);
    // });
  }

  // ``uploadFile` accepts the current filename and the pre-signed URL. It then uses `Fetch API`
  // to upload this file to S3 at `play.min.io:9000` using the URL:
  function uploadFile(file, url) {
    console.log(file, url);
    if (document.querySelector('#status').innerText === 'No uploads') {
      document.querySelector('#status').innerHTML = '';
    }
    fetch(url, {
      method: 'PUT',
      body: file,
    }).then(() => {
      // If multiple files are uploaded, append upload status on the next line.
      document.querySelector('#status').innerHTML += `<br>Uploaded ${file.name}.`;
    }).catch((e) => {
      console.error(e);
    });
  }
</script>
