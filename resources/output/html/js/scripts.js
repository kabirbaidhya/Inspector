$(function () {
    prettyPrint();

    $('#filter-issues').click(function () {
        var showingAll = $(this).attr('data-showing-all');
        if (showingAll === 'true') {
            // Show only issues
            $('[data-filename][data-has-issues=false]').hide();
            $(this).text('Show All');
            $(this).attr('data-showing-all', false);

        } else {
            $('[data-filename][data-has-issues=false]').show();
            $(this).attr('data-showing-all', true);
            $(this).text('Show only Issues');
        }
    });
});
