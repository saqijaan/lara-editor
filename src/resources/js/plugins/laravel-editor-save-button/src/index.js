export default (editor, opts = {}) => {

  let pnm = editor.Panels;

  pnm.addButton('options', {
    id: 'save',
    className: 'fa fa-save',
    command(editor) {
      editor.store();
    },
    attributes: {
      title: 'Save'
    }
  });

};