import grapesjsTuiImageEditor from 'grapesjs-tui-image-editor';

export default (editor, opts = {}) => {
  let remoteIcons = 'https://cdnjs.cloudflare.com/ajax/libs/tui-image-editor/3.15.0/svg/'

  const options = {
    ...{
      config: {
        includeUI: {
          initMenu: 'filter',
        }
      },
      upload: true,
      icons: {
        'menu.normalIcon.path': `${remoteIcons}icon-d.svg`,
        'menu.activeIcon.path': `${remoteIcons}icon-b.svg`,
        'menu.disabledIcon.path': `${remoteIcons}icon-a.svg`,
        'menu.hoverIcon.path': `${remoteIcons}icon-c.svg`,
        'submenu.normalIcon.path': `${remoteIcons}icon-d.svg`,
        'submenu.activeIcon.path': `${remoteIcons}icon-c.svg`,
      },
    }, ...opts
  };

  grapesjsTuiImageEditor(editor,options);
};