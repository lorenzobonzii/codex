import { AbstractControl, ValidationErrors, ValidatorFn } from "@angular/forms";




export class ConfirmPasswordValidator {
  /**
   * Check matching password with confirm password
   * @param control AbstractControl
   */
  static MatchPassword(control: AbstractControl) {
    const password = control.get('password')?.value;

    const confirmPassword = control.get('password2')?.value;

    if (password !== confirmPassword) {
      control.get('password2')?.setErrors({ ...(control.get('password2')?.errors || {}), 'ConfirmPassword': 'true' })
      return;
    } else {
      return null;
    }
  }
}
export function passwordConfirmation(password_originale: string): ValidatorFn {
  return (control: AbstractControl): ValidationErrors | null => {
    const forbidden = password_originale == control.value;
    return forbidden ? { confirmPassword: { value: control.value } } : null;
  };
}



export function confirmPasswordValidator(otherControl: AbstractControl): ValidatorFn {

  return (control: AbstractControl): ValidationErrors | null => {

    let password1: string | null = control.value;
    let password2: string | null = otherControl.value;
    if (password1 != password2) {
      return { 'confirmPasswordValidator': true, 'requiredValue': password2 }
    }

    return null;

  }

}
