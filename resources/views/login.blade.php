<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>University Login</title>
  <link rel="stylesheet" href="{{asset('css/style-login.css')}}">
  <style>

      .alert {
          display: flex;
          align-items: center;
          padding: 15px 20px;
          margin-bottom: 20px;
          border-radius: 8px;
          font-family: 'Roboto', Arial, sans-serif;
          font-size: 16px;
          box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
          position: relative;
          overflow: hidden;
          transition: transform 0.3s ease, box-shadow 0.3s ease;
      }

      .alert-danger {
          color: #842029;
          background: linear-gradient(135deg, #f8d7da, #f5c2c7);
          border: 1px solid #f5c2c7;
      }

      .alert .close {
          position: absolute;
          top: 0px;
          right: 0px;
          font-size: 20px;
          color: #842029;
          background: none;
          border: none;
          cursor: pointer;
          transition: color 0.3s ease;
      }

      .alert .close:hover {
          color: #5a1016;
      }

      .alert .alert-icon {
          font-size: 24px;
          margin-right: 15px;
          flex-shrink: 0;
          position: absolute;
          top: 6%;
      }

      .alert .alert-content {
          flex-grow: 1;
      }

      .alert strong {
          font-weight: bold;
          text-transform: uppercase;
      }

      .alert-danger:hover {
          transform: scale(1.02);
          box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
      }

      /* Responsive adjustments */
      @media (max-width: 768px) {
          .alert {
              font-size: 14px;
              padding: 10px 15px;
          }
          .alert .alert-icon {
              font-size: 20px;
              position: absolute;
              top: 1px;
              left: -1%;
          }
      }

  </style>
  <style>
    /* Glassmorphism Modal Style */
    .glass-modal {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100vh;
      background: rgba(15, 23, 42, 0.4);
      backdrop-filter: blur(8px);
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 9999;
      animation: fadeIn 0.6s ease;
    }

    .glass-box {
      position: relative;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 20px;
      padding: 30px 25px;
      width: 90%;
      max-width: 480px;
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
      backdrop-filter: blur(18px);
      border: 1px solid rgba(255, 255, 255, 0.2);
      color: #ffffff;
      text-align: center;
      font-family: 'Segoe UI', sans-serif;
      animation: slideUp 0.5s ease;
    }

    .glass-icon {
      font-size: 42px;
      margin-bottom: 10px;
    }

    .glass-message h2 {
      margin-bottom: 10px;
      font-size: 24px;
      font-weight: 600;
      color: #ffffff;
    }

    .glass-message p {
      margin-bottom: 10px;
      font-size: 16px;
      color: #e0f7ff;
    }

    .glass-message ul {
      list-style: none;
      padding: 0;
      margin: 10px 0 0;
      text-align: left;
    }

    .glass-message li {
      margin: 8px 0;
      font-size: 15px;
    }

    .glass-message code {
      background-color: rgba(255, 255, 255, 0.2);
      padding: 3px 6px;
      border-radius: 6px;
      font-family: monospace;
      color: #fff;
    }

    .glass-message small {
      color: #cceeff;
      display: block;
      margin-top: 5px;
    }

    .glass-close {
      position: absolute;
      top: 12px;
      right: 15px;
      background: none;
      border: none;
      font-size: 22px;
      color: #ffffff;
      cursor: pointer;
      transition: color 0.3s;
    }

    .glass-close:hover {
      color: #ff4d4d;
    }

    /* Animations */
    @keyframes fadeIn {
      from { opacity: 0 }
      to { opacity: 1 }
    }

    @keyframes slideUp {
      from { transform: translateY(40px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }
    .glass-content-bilingual {
      display: flex;
      flex-direction: row;
      justify-content: space-between;
      gap: 20px;
      text-align: left;
      margin-top: 10px;
      flex-wrap: wrap;
    }

    .lang-block {
      flex: 1 1 45%;
      background-color: rgba(255, 255, 255, 0.08);
      padding: 10px 15px;
      border-radius: 10px;
      box-shadow: inset 0 0 10px rgba(255,255,255,0.05);
    }

    .lang-block p, .lang-block li, .lang-block small {
      color: #e6f6ff;
      font-size: 15px;
    }

    .lang-block code {
      background-color: rgba(255, 255, 255, 0.2);
      padding: 2px 6px;
      border-radius: 5px;
      font-family: monospace;
    }

    @media (max-width: 768px) {
      .glass-content-bilingual {
        flex-direction: column;
      }
    }


  </style>
</head>
<body>
  
  <div class="theme-toggle">
    <button id="toggleTheme">🌙</button>
  </div>
  <div class="login-container">
    <div class="logo">
      <img src="{{asset('images/logos/uh1.png')}}" alt="University Logo">
    </div>
    <div class="welcome-text">
      <p>Connectez-vous pour accéder à votre espace.</p>
    </div>
    @if (@Session::has('login_error'))
        <div class="alert alert-danger">
            <button type="button" class="close" aria-label="Close" onclick="this.parentElement.style.display='none';">
                &times;
            </button>
            <div class="alert-icon">⚠️</div>
            <div class="alert-content">
                <strong>Erreur :</strong> {{ Session::get('login_error') }}
            </div>
        </div>
    @endif

    <form method="POST" action="{{route('auth.login')}}" class="login-form">
      @csrf
      <div class="input-group">
        <input type="email" name="email" placeholder="Adresse Email" required>
        <span class="icon">📧</span>
      </div>
      <div class="input-group password-group">
        <input type="password" id="password" name="password" placeholder="Mot de passe" required oninput="checkPasswordStrength()">
        <span class="icon toggle-password" onclick="togglePassword()">👁️</span>
        {{-- <div class="password-strength">
          <div id="strength-bar"></div>
        </div> --}}
      </div>
      <button type="submit">Se connecter</button>
      {{-- <div class="extra-links">
        <a href="#">Mot de passe oublié ?</a>
        <a href="#">Besoin d'aide ?</a>
      </div> --}}
    </form>
  </div>


  <div id="loginNotificationModal" class="glass-modal">
    <div class="glass-box">
      <button class="glass-close" onclick="closeLoginNotification()">×</button>
      <div class="glass-icon">🔐</div>
      <div class="glass-message">
        <h2>Bienvenue 👋 / مرحباً</h2>
        <div class="glass-content-bilingual">
          <div class="lang-block">
            <p><strong>Note importante pour la première connexion (Candidats) :</strong></p>
            <ul>
              <li><strong>Email :</strong> celui utilisé lors de la préinscription</li>
              <li><strong>Mot de passe :</strong> <code>VotreCIN@2025</code><br>
                <small>(ex. : <code>BK123456@2025</code>)</small>
              </li>
            </ul>
          </div>
          <div class="lang-block" dir="rtl">
            <p><strong>ملاحظة مهمة للمترشحين عند تسجيل الدخول لأول مرة:</strong></p>
            <ul>
              <li><strong>البريد الإلكتروني :</strong> المستعمل أثناء التسجيل الأولي</li>
              <li><strong>كلمة المرور :</strong> <code>رقم CIN@2025</code><br>
                <small>(مثال : <code>BK123456@2025</code>)</small>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>




</body>
  <script>
    function togglePassword() {
      const passwordInput = document.getElementById('password');
      const toggleIcon = document.querySelector('.toggle-password');
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.textContent = '🙈'; // Closed-eye icon
      } else {
        passwordInput.type = 'password';
        toggleIcon.textContent = '👁️'; // Open-eye icon
      }
    }

    function checkPasswordStrength() {
      const password = document.getElementById('password').value;
      const strengthBar = document.getElementById('strength-bar');
      let strength = 0;

      if (password.length > 5) strength += 20;
      if (password.match(/[A-Z]/)) strength += 20;
      if (password.match(/[a-z]/)) strength += 20;
      if (password.match(/[0-9]/)) strength += 20;
      if (password.match(/[^a-zA-Z0-9]/)) strength += 20;

      strengthBar.style.width = `${strength}%`;
      strengthBar.style.background = strength < 60 ? 'red' : 'green';
    }

    const themeToggleBtn = document.getElementById('toggleTheme');
    themeToggleBtn.addEventListener('click', () => {
      document.body.classList.toggle('dark-theme');
      themeToggleBtn.textContent = document.body.classList.contains('dark-theme') ? '☀️' : '🌙';
    });
  </script>
  <script>
      function closeLoginNotification() {
        const modal = document.getElementById('loginNotificationModal');
        modal.style.display = 'none';
      }

      window.addEventListener('DOMContentLoaded', () => {
        setTimeout(() => {
          closeLoginNotification();
        }, 10000);
      });
  </script>


</html>
