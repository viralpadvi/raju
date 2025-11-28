export const toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 2000,
  timerProgressBar: true,
});

export function showSuccess(message) {
  toast.fire({ icon: 'success', title: message });
}

export function showError(message) {
  toast.fire({ icon: 'error', title: message });
}

export function confirm(title = 'Are you sure?', text = '') {
  return Swal.fire({ icon: 'question', title, text, showCancelButton: true, confirmButtonText: 'Yes' });
}


