export default (editor, opts = {}) => {
  const options = {
    ...{

      // default options
    }, ...opts
  };

  const assetManager = editor.AssetManager;

  editor.on('asset:upload:start', ()=>{
    editor.runCommand('show-loader',{
      container: '.gjs-am-file-uploader'
    });
  })

  editor.on('asset:upload:end', (t)=>{
    editor.runCommand('hide-loader',{
      container: '.gjs-am-file-uploader'
    });

    // console.log(t)
  })
  
  editor.on('asset:upload:response', ()=>{
    editor.runCommand('notify',{
      type: 'success',
      title: 'Success',
      message: 'File Uploaded Successfully'
    })
  })

  editor.on('asset:upload:error', (error)=>{
    editor.runCommand('hide-loader',{
      container: '.gjs-am-file-uploader'
    });

    // console.log(error.code)

    editor.runCommand('notify',{
      type: 'error',
      title: 'Error',
      message: 'File Uploaded Error: '+ (error.message ?? error)
    })

  })


};