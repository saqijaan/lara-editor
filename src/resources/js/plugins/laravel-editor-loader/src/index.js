export default (editor, opts = {}) => {
  const options = {
    ...{
      loaderStyles: {
        "left": "0",
        "top": "0",
        "background-color": "white",
        "opacity": "0.7",
        "position": "absolute",
        "align-items": "center",
        "justify-content": "center",
        "width": "100%",
        "height": "100%",
        "font-size": "36pt",
        "display": "flex",
        "z-index": "100",
      },
      // default options
    }, ...opts
  };

  let loader = document.getElementById('loader');
  if (!loader) {
    loader = document.createElement('div');
    loader.id = 'loader';
    for( var style in options.loaderStyles ){
      loader.style[style] = options.loaderStyles[style];
    }
    loader.innerHTML = ' <i class="fa fa-spinner fa-spin"></i>';
  }

  let commands = editor.Commands;
  commands.add('show-loader',(editor, sender, opts)=>{
    const options = {
      ...{
        container : 'body'
      },
      ...opts
    };

    let container = document.querySelector(options.container);
    if ( container ){
      container.append(loader);
      container.style.position = 'relative';
    }
  })

  commands.add('hide-loader',(editor, sender, opts)=>{
    const options = {
      ...{
        container : 'body'
      },
      ...opts
    };

    let container = document.querySelector(options.container);
    if ( container ){
      container.style.position = '';
      let loaderElement = document.querySelector(`${options.container} #loader`);
      loaderElement && loaderElement.remove();
    }
    
  })


  editor.on('storage:start', () => {
    editor.runCommand('show-loader')
  })

  editor.on('storage:end', () => {
    editor.runCommand('hide-loader')
  })

};