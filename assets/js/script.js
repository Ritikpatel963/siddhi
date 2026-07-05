$(function () {
    $('.data-table').DataTable({
        pageLength: 10,
        order: [],
    });

    $('.js-delete').on('click', function (event) {
        event.preventDefault();
        const form = $(this).closest('form');
        Swal.fire({
            title: 'Delete this record?',
            text: 'This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'Delete'
        }).then((result) => {
            if (result.isConfirmed) {
                form.trigger('submit');
            }
        });
    });

    const sidebar = $('#sidebar');
    const backdrop = $('#sidebarBackdrop');
    $('#sidebarToggle').on('click', function () {
        sidebar.toggleClass('show');
        backdrop.toggleClass('show');
    });
    backdrop.on('click', function () {
        sidebar.removeClass('show');
        backdrop.removeClass('show');
    });
});

