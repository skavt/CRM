<template>
  <div class="file-uploader">
    <div class="file-preview-ctr">
      <div :class="{'complete-drag':computedSrc ,'file-drag-ctr':fileDragClass}" ref="fileDrag"
           @dragover="onFileDrag" @dragleave="onFileDragLeave" @drop="onFileDrop">
      </div>
      <b-img class="image-preview" :src="computedSrc" ref="img"/>
      <avatar-cropper v-if="showCropper" ref="cropper" trigger=".pick-avatar" :labels="cropperLabels"
                      :uploadHandler="uploadHandler" :cropper-options="cropperOptions">
      </avatar-cropper>
    </div>
    <button type="button" class="pick-avatar btn-choose mr-3">
      <input type="file" @change="onFileChoose" ref="fileInput">
      <span>Upload</span>
    </button>
    <button type="button" v-if="hasImage" @click="onRemoveClick" class="btn-remove" v-b-tooltip.hover
            :title="'Remove Image'">
      &times;
    </button>
  </div>
</template>

<script>
import AvatarCropper from "vue-avatar-cropper"

export default {
  name: "ProfilePictureUpload",
  components: {AvatarCropper},
  props: {
    src: String,
    isDefaultImg: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      showCropper: true,
      imageRemoved: false,
      imageSrc: null,
      fileDragClass: true,
      hasImage: false,
      cropperLabels: {
        submit: "Submit", cancel: "Cancel"
      },
      cropperOptions: {
        aspectRatio: 1,
        autoCropArea: 0.5,
        viewMode: 1,
        movable: true,
        zoomable: true,
      }
    }
  },
  computed: {
    computedSrc() {
      if (this.imageRemoved) {
        return '/assets/avatar.svg'
      }
      return this.imageSrc || this.src
    }
  },
  methods: {
    uploadHandler(cropper) {
      this.$refs.fileInput.value = ''
      this.imageSrc = ''
      this.imageRemoved = false
      this.hasImage = true
      this.imageSrc = cropper.getCroppedCanvas().toDataURL()
      cropper.getCroppedCanvas().toBlob(blob => {
        this.$emit('input', new File([blob], "avatar.png"))
      })
    },
    onFileChoose(ev) {
      this.imageSrc = ''
      this.hasImage = true
      this.imageRemoved = false
      const reader = new FileReader()
      reader.onload = () => {
        this.imageSrc = reader.result
      }
      if (!this.$refs.fileDrag.classList.contains('complete-drag')) {
        this.$refs.fileDrag.classList.add('complete-drag');
      }
      reader.readAsDataURL(ev.target.files[0])
      this.$emit('input', ev.target.files[0])
    },
    onRemoveClick() {
      this.imageSrc = ''
      this.hasImage = false
      this.imageRemoved = true
      if (this.$refs.fileDrag.classList.contains('complete-drag')) {
        this.$refs.fileDrag.classList.remove('complete-drag')
      }
      this.$refs.fileInput.value = ''
      this.$emit('input', '')
    },
    onFileDrag(ev) {
      this.$refs.fileDrag.classList.add('active-drag')
      if (this.$refs.fileDrag.classList.contains('complete-drag')) {
        this.$refs.fileDrag.classList.remove('complete-drag');
      }
      ev.preventDefault()
    },
    onFileDrop(ev) {
      this.imageSrc = ''
      this.imageRemoved = false
      this.hasImage = true
      const reader = new FileReader()

      if (this.showCropper) {
        const cropperVue = this.$refs.cropper
        reader.onload = () => {
          cropperVue.dataUrl = reader.result
        };
        reader.readAsDataURL(ev.dataTransfer.files[0])
        cropperVue.filename = ev.dataTransfer.files[0].name || 'unknown'
        cropperVue.mimeType = this.mimeType || ev.dataTransfer.files[0].type
        cropperVue.$emit('changed', ev.dataTransfer.files[0], reader)
      } else {
        reader.onload = () => {
          this.imageSrc = reader.result
        };
        reader.readAsDataURL(ev.dataTransfer.files[0])
        this.$emit('input', ev.dataTransfer.files[0])
      }

      if (this.$refs.fileDrag.classList.contains('active-drag')) {
        this.$refs.fileDrag.classList.remove('active-drag')
      }
      this.$refs.fileDrag.classList.add('complete-drag')
      ev.preventDefault();
    },
    onFileDragLeave() {
      if (this.$refs.fileDrag.classList.contains('active-drag')) {
        this.$refs.fileDrag.classList.remove('active-drag')
      }
    }
  },
  mounted() {
    this.hasImage = !this.isDefaultImg
  }
}
</script>

<style lang="scss" scoped>
.file-uploader {
  position: relative;
  display: inline-flex;
  flex-direction: column;
  align-items: center;
  background-color: #efefef;
  border: 1px dashed #737373;
  border-radius: 50%;

  .file-preview-ctr {
    padding: 5px;
  }

  .btn-choose {
    overflow: hidden;
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    width: 100%;
    border: none;
    background-color: rgba(0, 0, 0, 0.7);
    color: #FFF;
    padding: 10px 15px;
    cursor: pointer;
    opacity: 0;
    z-index: 1000;

    input {
      position: absolute;
      left: 0;
      right: 0;
      top: 0;
      bottom: 0;
      width: 100%;
      height: 100%;
      z-index: 2;
      opacity: 0;
    }
  }

  .btn-remove {
    position: absolute;
    right: 10px;
    top: 10px;
    width: 24px;
    height: 24px;
    line-height: 20px;
    text-align: center;
    border-radius: 50%;
    border: none;
    font-size: 24px;
    font-weight: bold;
    background-color: transparent;
    z-index: 1001;
    padding: 2px;
    opacity: 0;

    &:hover {
      background-color: rgba(0, 0, 0, 0.7);
      color: #FFF;
    }
  }

  &:hover {
    .btn-choose,
    .btn-remove {
      opacity: 1;
    }
  }
}

.file-preview-ctr {
  width: 160px;
  height: 160px;
  display: inline-flex;
  align-items: center;
  position: relative;

  .file-drag-ctr {
    z-index: 3;
    width: 100%;
    height: 100%;
    position: absolute;

    &:before {
      content: attr(placeholder);
      position: relative;
      display: flex;
      width: 100%;
      height: 100%;
      cursor: default;
      justify-content: center;
      text-align: center;
      color: #737373;
      align-items: center;
    }

    &.active-drag {
      border-color: #008BCA;
      background-color: #fff;

      &:before {
        color: #008BCA;
      }
    }

    &.complete-drag {
      &:before {
        display: none;
      }
    }
  }

  .image-preview {
    width: 150px;
    border-radius: 50%;
    z-index: 2;
  }
}
</style>

<style>
.avatar-cropper .avatar-cropper-container {
  width: 70vw;
  height: 70vh;
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-direction: column;
  position: relative;
  background: transparent;
}

.avatar-cropper .avatar-cropper-container .avatar-cropper-footer {
  width: 100%;
  background-color: #fff;
}

.cropper-container {
  width: 100%;
  height: 100%;
}

.avatar-cropper .avatar-cropper-container .avatar-cropper-image-container {
  width: 100%;
  max-width: 100%;
  height: 100%;
}

.avatar-cropper .avatar-cropper-mark {
  background: rgba(0, 0, 0, 0.5);
}
</style>