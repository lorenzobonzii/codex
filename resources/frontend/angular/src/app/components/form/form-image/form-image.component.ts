import { Component, Input } from '@angular/core';
import { FormField } from '../../../models/form';
import { FormGroup, ReactiveFormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';
import { ImageCropperComponent, ImageCroppedEvent, LoadedImage } from 'ngx-image-cropper';
import { DomSanitizer, SafeUrl } from '@angular/platform-browser';

@Component({
  selector: 'app-form-image',
  standalone: true,
  imports: [ReactiveFormsModule, CommonModule, ImageCropperComponent],
  templateUrl: './form-image.component.html',
  styleUrl: './form-image.component.scss'
})
export class FormImageComponent {
  @Input()
  field!: FormField;

  @Input()
  group!: FormGroup;

  imageChangedEvent: Event | null = null;
  croppedImage: SafeUrl = '';
  file!: File;
  view: boolean = false;

  constructor(
    private sanitizer: DomSanitizer
  ) {
  }
  ngOnInit() {/*
    if (this.field.image?.url) {
      const segments = this.field.image.url.split('.');
      const extension = segments[segments.length - 1];
      fetch(this.field.image.url)
        .then(res => res.blob())
        .then(blob => {
          this.file = new File([blob], "name." + extension, { type: "image/" + extension });
          this.view = true;
        });

    }*/
  }

  fileChangeEvent(event: Event): void {
    this.imageChangedEvent = event;
    this.view = true;
  }
  imageCropped(event: ImageCroppedEvent) {
    this.updateImageValue(event.base64 ?? undefined);
    //this.croppedImage = this.sanitizer.bypassSecurityTrustUrl(event.objectUrl ?? '');
    // event.blob can be used to upload the cropped image
  }
  imageLoaded(image: LoadedImage) {
    // show cropper
  }
  cropperReady() {
    // cropper ready
  }
  loadImageFailed() {
    // show message
  }

  updateImageValue(base64?: string) {
    const formControl = this.group.get(this.field.name);
    if (formControl && base64)
      formControl.setValue(base64);
  }


}
