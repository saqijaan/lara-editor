import "./scss/main.scss"
import { createApp } from 'vue';
import { createStore } from 'vuex';
import Main from './Main.vue'
import FileManager from 'laravel-file-manager'

export default (editor, opts = {}) => {

  const store = createStore();
  let panelId = 'options';
  let panelManager = editor.Panels;
  let commands = editor.Commands;
  let modal = editor.Modal;

  const modalOptions = {
    attributes: { class: 'file-manager', id: 'file-manager-modal' }
  }

  let appContainer = document.createElement('div');
  appContainer.id = 'file-manager';
  document.body.append(appContainer);

  let fileManagerApp = createApp(Main, opts)
    .use(store)
    .use(FileManager, { store })
    .mount('#file-manager');

  commands.add('show-file-manager', (editor, sender, options) => {
    modal.setTitle('File Manager')
    modal.setContent(fileManagerApp.$el);
    modal.open(modalOptions);
  })

  panelManager.addButton(panelId, {
    id: 'upload-file',
    className: 'fa fa-folder-open',
    command: 'show-file-manager',
    attributes: {
      title: 'Edit'
    }
  });

};