var cells = document.querySelectorAll('.file-preview');

cells.forEach(function (cell) {
  var previewWindow = cell.querySelector('.preview-window');

  cell.addEventListener('mouseover', function () {
    var filePath = this.getAttribute('data-filepath');
    var img = new Image();
    img.src = 'thumbnail.php?file=' + filePath;
    img.onload = function () {
      previewWindow.appendChild(img);
      previewWindow.style.display = 'block';
    };
  });

  cell.addEventListener('mouseout', function () {
    previewWindow.style.display = 'none';
    while (previewWindow.firstChild) {
      previewWindow.removeChild(previewWindow.firstChild);
    }
  });
});
