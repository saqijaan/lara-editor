export default (editor, opts = {}) => {

  let pnm = editor.Panels;

  pnm.addButton('options', {
    id: 'save',
    className: 'fa fa-save',
    command(editor) {
      editor.store();
      editor.runCommand('notify',{
        type: 'success',
        title: 'Success',
        message: "Page Saved Successfully"
      })
    },
    attributes: {
      title: 'Save'
    }
  });

};