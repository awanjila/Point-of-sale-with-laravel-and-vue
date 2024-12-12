<template>
  <div v-if="show" class="modal-overlay">
    <div class="modal-container">
      <button class="close-button" @click="$emit('close')">X</button>
      <div class="modal-content">
        <slot></slot> <!-- This will render the content passed to the ModalWrapper -->
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    show: Boolean,
  },
};
</script>

<style scoped>
/* Modal Overlay: Full-screen background dimming effect */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.6); /* Dark background for modal */
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

/* Modal Container: Flexible width for different content */
.modal-container {
  background-color: white;
  border-radius: 8px;
  max-width: 90%;
  width: auto;
  padding: 20px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  position: relative;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
}

/* Close Button: Positioned top-right */
.close-button {
  position: absolute;
  top: 10px;
  right: 10px;
  background: none;
  border: none;
  font-size: 18px;
  cursor: pointer;
}

/* Modal Content: This will adapt to the slot content */
.modal-content {
  width: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
}

/* Responsive handling: Ensure the modal content resizes well */
@media(min-width: 768px) {
  .modal-container {
    max-width: 70%;
  }
}
</style>
