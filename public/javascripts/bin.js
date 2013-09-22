// drag and drop file api stuff
function handleFileSelect(evt) {
  evt.stopPropagation();
  evt.preventDefault();

  var files = evt.dataTransfer.files;

  $.each(files, function() {
    var file = this;

    var reader = new FileReader();

    reader.onload = (function() {
      return function(e) {
        addFile(file.name, e.target.result);
      };
    })(file);

    reader.readAsText(file);
  });
}

function handleDragOver(evt) {
  evt.stopPropagation();
  evt.preventDefault();
  evt.dataTransfer.dropEffect = 'copy'; // Explicitly show this is a copy.
}

function bindDragAndDrop() {
  var dropZone = document.getElementById('drop_zone');
  dropZone.addEventListener('dragover', handleDragOver, false);
  dropZone.addEventListener('drop', handleFileSelect, false);    
}

//
function addFile(name, contents) {
  var template = $('._file_template').html();

  template = template.replace(/\|filename\|/g, name);
  template = template.replace(/\|contents\|/g, contents);

  $('._files').append(template);
}

// go
$(function() {
  bindDragAndDrop();
});