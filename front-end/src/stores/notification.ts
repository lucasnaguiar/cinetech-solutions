import { defineStore } from 'pinia';
import Swal from 'sweetalert2';

export const useValidationStore = defineStore('validation', {
  state: () => ({
    errors: {} as Record<string, string[]>,
  }),
  actions: {
    setErrors(errors: Record<string, string[]>) {
      this.errors = errors;
      this.showErrors();
    },
    clearErrors() {
      this.errors = {};
    },
    showErrors() {
      if (Object.keys(this.errors).length > 0) {
        const errorList = Object.values(this.errors)
          .flat()
          .map((msg) => `<li>${msg}</li>`)
          .join('');

        Swal.fire({
          icon: 'error',
          title: 'Erro de Validação',
          html: `<ul style="text-align:left;">${errorList}</ul>`,
          confirmButtonText: 'OK',
        });
      }
    },
  },
});
