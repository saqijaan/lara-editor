const grapesjs = require('grapesjs');
import LaravelEditorFilemanager from "./plugins/filemanager";
import EditorPageSaveButton from "./plugins/laravel-editor-save-button/src"
import CodeEditor from "./plugins/laravel-editor-code-editor/src"
import loader from "./plugins/laravel-editor-loader/src"

let remoteIcons = 'https://cdnjs.cloudflare.com/ajax/libs/tui-image-editor/3.15.0/svg/'

const toastr = require('toastr');

let config = window.editorConfig;
delete window.editorConfig;

config.plugins = [
	loader,
	LaravelEditorFilemanager,
	EditorPageSaveButton,
	CodeEditor
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
	}
};

// config.plugins.push(grapesjsTuiImageEditor)
// config.pluginsOpts[grapesjsTuiImageEditor] = {
// 	config: {
// 		includeUI: {
// 			initMenu: 'filter',
// 		}
// 	},
// 	upload: true,
// 	icons: {
// 		'menu.normalIcon.path': `${remoteIcons}icon-d.svg`,
// 		'menu.activeIcon.path': `${remoteIcons}icon-b.svg`,
// 		'menu.disabledIcon.path': `${remoteIcons}icon-a.svg`,
// 		'menu.hoverIcon.path': `${remoteIcons}icon-c.svg`,
// 		'submenu.normalIcon.path': `${remoteIcons}icon-d.svg`,
// 		'submenu.activeIcon.path': `${remoteIcons}icon-c.svg`,
// 	},
// }


window.editor = grapesjs.init(config);

// let loader = document.getElementById('loader');
// let showLoader = function () {
// 	if (loader) {
// 		loader.style.display = 'flex';
// 	}
// }

// let hideLoader = function () {
// 	if (loader) {
// 		loader.style.display = 'none';
// 	}
// }

// editor.on('load', () => {
// 	hideLoader();
// })


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