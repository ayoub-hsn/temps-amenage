<template>
    <div v-if="visible" class="error-popup">
      <div class="message-container">
        <p>{{ message }}</p>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        visible: false,
        message: '',
      };
    },
    methods: {
      show(message) {
        this.message = message;
        this.visible = true;
        setTimeout(() => {
          this.visible = false;
        }, 5000); // Hide after 5 seconds
      },
    },
  };
  </script>
  
  <style scoped>
  .error-popup {
    position: fixed;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    background: linear-gradient(135deg, #ff4e50, #d32f2f); /* Modern gradient */
    color: #fff;
    border-radius: 16px;
    padding: 18px 30px;
    z-index: 1000;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 350px;
    font-family: 'Inter', sans-serif;
    font-weight: 500;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    animation: slideIn 0.5s ease-out, fadeOut 0.5s 4.5s ease-out;
  }
  
  .message-container {
    text-align: center;
    width: 100%;
  }
  
  .error-popup p {
    margin: 0;
    font-size: 1.1rem;
    line-height: 1.6;
    font-weight: 500;
    word-wrap: break-word;
  }
  
  @keyframes slideIn {
    0% {
      opacity: 0;
      transform: translateX(-50%) translateY(-30px);
    }
    100% {
      opacity: 1;
      transform: translateX(-50%) translateY(0);
    }
  }
  
  @keyframes fadeOut {
    0% {
      opacity: 1;
    }
    100% {
      opacity: 0;
    }
  }
  
  @media (max-width: 500px) {
    .error-popup {
      width: 90%;
      padding: 15px 20px;
    }
  
    .error-popup p {
      font-size: 1rem;
    }
  }
  </style>
  