import Swal from 'sweetalert2';

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 4500,
    timerProgressBar: true,
    customClass: { popup: 'sofis-toast' },
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer);
        toast.addEventListener('mouseleave', Swal.resumeTimer);
    },
});

const Dialog = Swal.mixin({
    customClass: {
        popup: 'sofis-dialog',
        title: 'sofis-dialog__title',
        htmlContainer: 'sofis-dialog__text',
        confirmButton: 'sofis-dialog__btn-confirm',
        cancelButton: 'sofis-dialog__btn-cancel',
        actions: 'sofis-dialog__actions',
    },
    buttonsStyling: false,
    reverseButtons: true,
});

const SofisAlert = {
    success(message) {
        return Toast.fire({ icon: 'success', title: message });
    },

    error(message) {
        return Toast.fire({ icon: 'error', title: message });
    },

    warning(message) {
        return Toast.fire({ icon: 'warning', title: message });
    },

    info(message) {
        return Toast.fire({ icon: 'info', title: message });
    },

    html(icon, htmlContent) {
        return Toast.fire({ icon, html: htmlContent });
    },

    confirm(message, opts = {}) {
        const { title = '¿Eliminar?', confirmText = 'Sí, eliminar', isDanger = true } = opts;

        return Dialog.fire({
            title,
            html: `<span>${message}</span>`,
            icon: isDanger ? 'warning' : 'question',
            showCancelButton: true,
            confirmButtonText: confirmText,
            cancelButtonText: 'Cancelar',
            focusCancel: true,
        });
    },
};

// Intercept all forms that have a data-confirm attribute.
// Add data-confirm-danger to use the "delete" variant (warning icon + "Sí, eliminar").
document.addEventListener('submit', function (e) {
    const form = e.target;
    const message = form.dataset.confirm;

    if (!message) {
        return;
    }

    e.preventDefault();

    const isDanger = 'confirmDanger' in form.dataset;
    const opts = isDanger
        ? { title: '¿Eliminar?', confirmText: 'Sí, eliminar', isDanger: true }
        : { title: '¿Confirmar acción?', confirmText: 'Confirmar', isDanger: false };

    SofisAlert.confirm(message, opts).then(({ isConfirmed }) => {
        if (isConfirmed) {
            delete form.dataset.confirm;
            form.submit();
        }
    });
}, true);

window.SofisAlert = SofisAlert;
export default SofisAlert;
