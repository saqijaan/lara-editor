export default (editor, opts = {}) => {
  var pfx = editor.getConfig().stylePrefix;
  var modal = editor.Modal;
  var commands = editor.Commands;
  var panels = editor.Panels;
  var container = document.createElement('div');
  let txtarea = document.createElement('textarea');
  container.appendChild(txtarea);

  var btnEdit = document.createElement('button');
  btnEdit.innerHTML = 'Save';
  btnEdit.style.float = 'right';
  btnEdit.style.backgroundColor = '#090';
  btnEdit.className = pfx + 'btn-prim ' + pfx + 'btn-import';
  btnEdit.onclick = function () {
    var code = codeViewer.editor.getValue();
    editor.DomComponents.getWrapper().set('content', '');
    editor.setComponents(code.trim());
    modal.close();
    editor.runCommand('notify',{
      type: 'success',
      title: 'Success',
      message: 'Html Saved'
    })
  };
  container.appendChild(btnEdit);

  let codeViewer = editor.CodeManager
    .getViewer('CodeMirror')
    .clone();

  codeViewer.set({
    codeName: 'htmlmixed',
    readOnly: 0,
    theme: 'hopscotch',
    autoBeautify: true,
    autoCloseTags: true,
    autoCloseBrackets: true,
    lineWrapping: true,
    styleActiveLine: true,
    smartIndent: true,
    indentWithTabs: true
  });

  commands.add('html-edit', {
    run: function (editor, sender) {
      sender && sender.set('active', 0);

      modal.setTitle('Edit code');
      modal.setContent(container);

      var codeEditor = codeViewer.editor;
      if (!codeEditor) {
        codeViewer.init(txtarea);
        codeEditor = codeViewer.editor;
      }

      codeViewer.setContent(editor.getHtml());
      modal.open();
      codeEditor.refresh();
    }
  });

  panels.addButton('options', {
    id: 'edit',
    className: 'fa fa-edit',
    command: 'html-edit',
    attributes: {
      title: 'Edit'
    }
  });
};