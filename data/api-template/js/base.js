$(document).ready(function () {
    $(window).scroll(function () {
        if ($(this).scrollTop() > 50) {
            $('#back-to-top').fadeIn();
        } else {
            $('#back-to-top').fadeOut();
        }
    });

    // scroll body to 0px on click
    $('#back-to-top').click(function () {
        $('body,html').animate({
            scrollTop: 0
        }, 400);
        return false;
    });

    function filterTable(targetId, filter) {
        var rows = $(targetId).find('tbody > tr');
        rows.each(function () {
            if (filter && !$(this).hasClass(filter)) {
                $(this).addClass('d-none');
            } else {
                $(this).removeClass('d-none');
            }
        });
    }

    $('[data-toggle="table-filter"]').click(function (e) {
        e.preventDefault();

        var targetId = $(this).attr('href');
        var filter = $(this).data('filter');

        filterTable(targetId, filter);

        $(this).tab('show');
    });

    $('select.visibility-filter').multiselect({
        buttonContainer: '<div class="btn-group dropleft" />',
        selectAllNumber: false,
        buttonClass: 'btn btn-link',
        nonSelectedText: 'Filter visibility',
        onDropdownHide: function (event) {
            // $(this).
        }
    });
});

