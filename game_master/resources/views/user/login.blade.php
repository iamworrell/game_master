<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login — MyApp</title>
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <style>
    :root {
      --primary-color: #8b0000;
      --secondary-color: rgba(255,255,255,0.08);
      --text-color: #fff;
      --input-bg: #222;
      --input-border: #444;
      --btn-bg: #ff3c3c;
      --btn-hover: #e83232;
    }

    body, html {
      height: 100%;
      margin: 0;
      font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
      background: linear-gradient(145deg, #0f0f0f, #1a1a1a);
      color: var(--text-color);
    }

    .login-page {
      display: flex;
      align-items: center; justify-content: center;
      height: calc(100% - 210px);
      padding: 1rem;
    }
    .login-card {
      background: var(--secondary-color);
      border-radius: 16px;
      box-shadow: 0 8px 16px rgba(0,0,0,0.6);
      padding: 2rem;
      max-width: 400px;
      width: 100%;
      backdrop-filter: blur(8px);
    }
    .login-card h2 {
      margin-bottom: 1.5rem;
      text-align: center;
      font-size: 1.8rem;
    }
    .form-group {
      margin-bottom: 1.25rem;
    }
    .form-group label {
      display: block;
      margin-bottom: .5rem;
      font-weight: bold;
    }
    .form-group input {
      width: 100%;
      padding: .75rem;
      background: var(--input-bg);
      border: 1px solid var(--input-border);
      border-radius: 8px;
      color: #eee;
      font-size: 1rem;
    }
    .form-group input::placeholder {
      color: #888;
    }

    .btn-submit {
      display: block;
      width: 100%;
      padding: .75rem;
      background: var(--btn-bg);
      color: #fff;
      font-size: 1rem;
      font-weight: bold;
      text-align: center;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: background .3s, transform .2s;
    }
    .btn-submit:hover {
      background: var(--btn-hover);
      transform: scale(1.02);
    }

    .login-footer {
      margin-top: 1rem;
      text-align: center;
      font-size: .9rem;
    }
    .login-footer a {
      color: var(--btn-bg);
      text-decoration: none;
      font-weight: 600;
    }

    /* Responsive tweaks */
    @media (max-width: 640px) {
      .login-card {
        padding: 1.5rem;
      }
      .login-card h2 {
        font-size: 1.5rem;
      }
    }
  </style>
</head>
<body>
  <div class="login-page">
    <div class="login-card">
      <h2>Welcome Back</h2>

      <form action="{{ route('game.login')}}" method="POST" >
        @csrf

        <div class="form-group">
          <label for="email">Email Address</label>
          <input
            id="email" type="email" name="email"
            required autofocus
            placeholder="you@example.com"
          >
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <input
            id="password" type="password" name="password"
            required placeholder="••••••••"
          >
        </div>

        <div >
          <button class="btn-submit" type="submit">Login</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
