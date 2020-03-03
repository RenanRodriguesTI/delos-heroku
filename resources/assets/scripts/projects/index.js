/**
 * Created by allan on 20/02/17.
 */
if ($('#projects-table').length)
{
    $(document).ready(function () {
        var headerHeight = $('#projects-table thead').height();
        $('#projects-table-actions thead tr th').css({'height': headerHeight});

        var heights = [];

        $('#projects-table > tbody > tr').each(function () {
            heights.push($(this).height());
        });

        $('#projects-table-actions tbody tr').each(function (index) {
            $(this).css({'height': heights[index]});
        });
    });
}
