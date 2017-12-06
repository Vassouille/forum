$( document ).ready(function () {
    $('#close').click(function () {
       $(this).closest('.row').hide();
    });
});