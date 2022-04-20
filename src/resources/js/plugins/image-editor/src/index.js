import grapesjsTuiImageEditor from 'grapesjs-tui-image-editor';

export default (editor, opts = {}) => {

  const options = {
    ...{
      config: {
        includeUI: {
          initMenu: 'filter',
        }
      },
      upload: true,
      icons: {
        'menu.normalIcon.path': `${opts.remoteIcons}/icon-d.svg`,
        'menu.activeIcon.path': `${opts.remoteIcons}/icon-b.svg`,
        'menu.disabledIcon.path': `${opts.remoteIcons}/icon-a.svg`,
        'menu.hoverIcon.path': `${opts.remoteIcons}/icon-c.svg`,
        'submenu.normalIcon.path': `${opts.remoteIcons}/icon-d.svg`,
        'submenu.activeIcon.path': `${opts.remoteIcons}/icon-c.svg`,
      },
    }, ...opts
  };

  grapesjsTuiImageEditor(editor,options);
};