import grapesjs from 'grapesjs';
import LaravelEditorFilemanager from "./plugins/filemanager";
import EditorPageSaveButton from "./plugins/laravel-editor-save-button/src"
import CodeEditor from "./plugins/laravel-editor-code-editor/src"
import Loader from "./plugins/laravel-editor-loader/src"
import ImageEditor from "./plugins/image-editor/src"
import AssetManagerExtention from "./plugins/custom-asset-manager/src"
import Notification from "./plugins/notifications/src";

let config = window.editorConfig;
delete window.editorConfig;

config.plugins = [
	Notification,
	Loader,
	LaravelEditorFilemanager,
	EditorPageSaveButton,
	CodeEditor,
	ImageEditor,
	AssetManagerExtention
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
		remoteIcons: config.editor_icons,
		proxy_url : config.media_proxy_url,
		proxy_url_input : config.media_proxy_url_input,
		use_proxy : true
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
