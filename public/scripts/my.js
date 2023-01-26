document.addEventListener("DOMContentLoaded", function () {
    deferInit();
});

function deferInit()
{
    var clipboard = new ClipboardJS('.btn-clipboard');

    clipboard.on('success', function(e) {
        function clear() {
            e.clearSelection();
        }

        setTimeout(clear, 100);

    });
}

