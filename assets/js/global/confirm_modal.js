$(function () {
    console.log('here');
    $('#confirm_modal').on('show.bs.modal', function (event) {
        // Button that triggered the modal
        let button = $(event.relatedTarget);
console.log('modal event');
        // Extract info from data-* attributes
        let url = button.data('url');
        let action = button.data('action');

        let modal = $(this);

        modal.find('.modal-body span').text(action);
        modal.find('a.confirm').attr('href', url);
    })
});