<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Card Battle Arena</title>
  <style>
    /* Variables */
    :root {
      --primary: #8b0000;
      --secondary: rgba(255,255,255,0.1);
      --light: #fff;
      --dark: #111;
      --radius: 8px;
      --transition: 0.3s;
    }
    *, *::before, *::after { box-sizing: border-box; margin:0; padding:0; }
    body { 
      font-family:system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif; 
      color: var(--light); 
      background: var(--dark); }

    /* Hero Section */
    .hero {
      position: relative;
      height: 100vh;
      background: url('https://via.placeholder.com/1600x900') center/cover no-repeat;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      padding: 0 1rem;
    }
    .hero-content {
      position: relative;
      max-width: 800px;
      animation: fadeIn 1s ease;
    }
    .hero h1 {
      font-size: 3rem;
      margin-bottom: 1rem;
      text-shadow: 0 4px 12px rgba(0,0,0,0.7);
    }
    .hero p {
      font-size: 1.25rem;
      margin-bottom: 2rem;
      line-height:1.5;
    }
    .hero .btn {
      display: inline-block;
      margin: 0.5rem;
      padding: 0.75rem 2rem;
      background: var(--primary);
      color: var(--light);
      border: none;
      border-radius: var(--radius);
      font-size: 1rem;
      cursor: pointer;
      transition: background var(--transition), transform var(--transition);
      text-decoration: none;
    }
    .hero .btn:hover {
      background: #a30000;
      transform: scale(1.05);
    }

    /* Change sizes based on screen width - Responsive */
    @media(max-width:768px) {
      .hero h1 { font-size:2.25rem; }
      .hero p { font-size:1rem; }
    }
    @media(max-width:480px) {
      .hero h1 { font-size:1.75rem; }
      .hero p { display:none; }
      .hero .btn { width: 100%; max-width: 300px; }
    }

    /* Keyframes */
    @keyframes fadeIn {
      from { opacity:0; transform: translateY(20px);} 
      to { opacity:1; transform: translateY(0);}    
    }
  </style>
</head>
<body>
  <section class="hero">
    <div class="hero-content">
      <h1>Welcome to Card Battle Arena</h1>
      <p>Join the ultimate card duels. Build your deck, challenge opponents, and become the champion.</p>
      <a href="/game-master/login" class="btn">Login</a>
      <a href="/game-master/user/sign-up" class="btn">Sign Up</a>
    </div>
  </section>
</body>
</html>
