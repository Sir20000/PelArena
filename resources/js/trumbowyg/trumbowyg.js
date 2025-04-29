import jQuery from 'jquery';
window.$ = window.jQuery = jQuery;

const editorSelector = 'editor';
const editorElements = document.querySelectorAll(editorSelector);

if (editorElements.length > 0) {
    import('trumbowyg/dist/ui/trumbowyg.min.css');

    const trumbowygPlugins = [
        import('trumbowyg/dist/trumbowyg.min.js'),
        import('trumbowyg/dist/plugins/emoji/trumbowyg.emoji.min.js'),
        import('trumbowyg/dist/plugins/colors/trumbowyg.colors.min.js'),
        import('trumbowyg/dist/plugins/fontsize/trumbowyg.fontsize.min.js'),
        import('trumbowyg/dist/plugins/fontfamily/trumbowyg.fontfamily.min.js'),
        import('trumbowyg/dist/plugins/table/trumbowyg.table.min.js'),
        import('trumbowyg/dist/plugins/allowtagsfrompaste/trumbowyg.allowtagsfrompaste.min.js'),
        import('trumbowyg/dist/plugins/base64/trumbowyg.base64.min.js'),
    ];

    const trumbowygConfig = {
        btns: [
            ['viewHTML'],
            ['undo', 'redo'],
            ['formatting'],
            ['strong', 'em', 'del'],
            ['superscript', 'subscript'],
            ['link'],
            ['insertImage', 'base64'],
            ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
            ['horizontalRule'],
            ['removeformat'],
            ['foreColor', 'backColor'],
            ["fontsize", "fontfamily"],
            ["emoji"],
            ["table"],
            ['fullscreen'],
        ],
        autogrow: true,
        svgPath: '/svg/icons.svg',
    };

    const loadAndInitTrumbowyg = async () => {
        try {
            await Promise.all(trumbowygPlugins);
            if ($.fn.trumbowyg) {
                editorElements.forEach(editor => {
                    $(editor).trumbowyg(trumbowygConfig);
                });
            } else {
                console.error('Trumbowyg is not available on jQuery after dynamic import.');
            }
        } catch (error) {
            console.error('Error loading Trumbowyg or its plugins:', error);
        }
    };

    document.addEventListener('DOMContentLoaded', loadAndInitTrumbowyg);
}