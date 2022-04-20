const grapesjs = require('grapesjs');
import LaravelEditorFilemanager from "./plugins/filemanager";
import EditorPageSaveButton from "./plugins/laravel-editor-save-button/src"
import CodeEditor from "./plugins/laravel-editor-code-editor/src"
import Loader from "./plugins/laravel-editor-loader/src"
import ImageEditor from "./plugins/image-editor/src"

const toastr = require('toastr');

let config = window.editorConfig;
delete window.editorConfig;

config.plugins = [
	Loader,
	LaravelEditorFilemanager,
	EditorPageSaveButton,
	CodeEditor,
	ImageEditor
];

config.pluginsOpts = {
	[LaravelEditorFilemanager] : {
		settings: {
			headers: {
				'X-Requested-With': 'XMLHttpRequest',
				'X-CSRF-TOKEN' : config._token
			},
			baseUrl: config.filemanager_url,
		}
	},
	[ImageEditor] : {
		remoteIcons: config.editor_icons
	}
};

window.editor = grapesjs.init(config);

let blockManager = editor.BlockManager;

if (config.templatesUrl) {
	fetch(config.templatesUrl)
		.then(resp => resp.json())
		.then(data => {
			data.forEach(block => {
				blockManager.add('block-' + block.id, block);
			});
		})
		.catch(error => {
			console.log(error);
		})
}