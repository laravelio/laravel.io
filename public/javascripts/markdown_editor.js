var editor;

function bindMarkdownEditor()
{
  editor = new EpicEditor({
    container: 'markdown_editor',
    basePath: '/javascripts/vendor/EpicEditor-v0.2.2/',
    textarea: '_markdown_textarea',
    clientSideStorage: true,
    localStorageName: 'laravelio',
    autogrow: true,
    file: {
      name: 'laravelioeditor',
    },
    theme: {
      base: 'themes/base/epiceditor.css',
      preview: 'themes/preview/preview-dark.css',
      editor: 'themes/editor/epic-dark.css'
    }
  }).load();
  
  $('#_markdown_textarea').closest('form').submit(function() {
    editor.remove('laravelioeditor');
  });
}

$(function() {
  bindMarkdownEditor();
});