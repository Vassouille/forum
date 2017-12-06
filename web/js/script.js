$( document ).ready(function () {
    $('#close').click(function () {
       $(this).closest('.row').hide();
    });

    $('[data-target="#supprimerModal"]').click(function () {
        selector = $(this);
        $('#supprimerModal a.btn-danger').click(function () {
            $.ajax({
                type: "POST",
                url: $(selector).attr('data-path'),
                data: {id: $(selector).attr('data-id')}
            }).done(function (data) {
                console.log(data);
                $(selector).closest('tr').remove();
                $('#supprimerModal').modal('hide');
            })
        });

    });

    $('[data-target="#editModal"]').click(function () {
        selector = $(this);
        $('textarea#textarea').val($(this).closest('td').prev().find('.discussion-content').html());
        $('#editModal a.btn-primary').click(function () {
            $.ajax({
                type: "POST",
                url: $(selector).attr('data-path'),
                data: {id: $(selector).attr('data-id'), content: $('#editModal textarea').val()}
            }).done(function (data) {
                console.log(data);
                $(selector).closest('td').prev().find('.discussion-content').html($('#editModal textarea').val());
                $('#editModal').modal('hide');
            })
        });

    });
});