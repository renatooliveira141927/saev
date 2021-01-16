function readURL(input, preview_id) {

    if (input.files && input.files[0]) {
      var reader = new FileReader();
  
      reader.onload = function(e) {
        $('#'+preview_id).attr('src', e.target.result);
        $('#'+preview_id).show();
      }
  
      reader.readAsDataURL(input.files[0]);
    }
  }