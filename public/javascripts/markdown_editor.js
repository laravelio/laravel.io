function bindMarkdownEditor()
{
  var editor = new EpicEditor({
    container: 'markdown_editor',
    basePath: '/javascripts/vendor/EpicEditor-v0.2.2/',
    textarea: '_markdown_textarea',
    theme: {
      base: 'themes/base/epiceditor.css',
      preview: 'themes/preview/preview-dark.css',
      editor: 'themes/editor/epic-dark.css'
    }
  }).load();
}

$(function() {
  bindMarkdownEditor();
});