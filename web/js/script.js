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
                if (data.validation) {
                    $(selector).closest('tr').remove();
                    $('#supprimerModal').modal('hide');
                } else {
                    $('.news').html('<div class="alert alert-danger" role="alert">Une erreur est survenue</div>');
                }
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
                if (data.validation) {
                    $(selector).closest('td').prev().find('.discussion-content').html($('#editModal textarea').val());
                    $('#editModal').modal('hide');
                } else {
                    $('.news').html('<div class="alert alert-danger" role="alert">Une erreur est survenue</div>');
                }
            })
        });
    });

    var erreur = 0;
    $('#_submit').click(function(e) {
        e.preventDefault();
        $('.news').hide();
        $('.form').hide();
        $('.progress').show();
        $.ajax({
            type: $('form#login').attr('method'),
            url: $('form#login').attr('action'),
            data: $('form#login').serialize()
        }).done(function(data, status, object) {
            if (data.success) {
                window.location.reload();
            } else {
                erreur++;
                if (erreur === 3) {
                    setTimeout(function () {
                        $('.news').show();
                        $('.form').show();
                        $('.progress').hide();
                        $('#login .news').html('<div class="alert alert-danger" role="alert">Mauvais identifiants</div>')
                    }, 5000);
                } else {
                    $('.news').show();
                    $('.form').show();
                    $('.progress').hide();
                    $('#login .news').html('<div class="alert alert-danger" role="alert">Mauvais identifiants</div>')
                }
            }
        });
    });

    imConnected();
});

function imConnected() {
    setTimeout(function () {
        $.ajax({
            type: 'POST',
            url: '/imconnected'
        }).done(function (data) {
            if (data.users > 1) {
                $('#connecteduser').html(data.users + ' utilisateurs connectés');
            } else {
                $('#connecteduser').html(data.users + ' utilisateur connecté');
            }
            imConnected();
        });
    }, 25000)
}