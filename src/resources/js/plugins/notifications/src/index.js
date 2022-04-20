import toastr from 'toastr';

export default (editor, opts) => {

    const commands = editor.Commands;
    commands.add('notify',(editor, sender, opts) =>{
        if ( opts.type =='info' ){
            toastr.info(opts.message, opts.title)
        }

        if ( opts.type =='success' ){
            toastr.success(opts.message, opts.title)
        }

        if ( opts.type =='error' ){
            toastr.error(opts.message, opts.title)
        }

        if ( opts.type =='warning' ){
            toastr.warning(opts.message, opts.title)
        }
    });

}