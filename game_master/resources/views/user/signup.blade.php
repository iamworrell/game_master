<!DOCTYPE html>
<html>
<head>
    <title>Signup for Game Master</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @vite('resources/css/app.css')
</head>
<body class="signup-page">
      <p>Signup for Game Master. To sign up, fill out the following form</p>

    {{-- action="/users" - this calls the signup controller --}}
    <form method="POST" action="/users" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username">
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password">
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email">
        </div>

        <div class="form-group">
          <label for="master_icon_path">Master Icon:</label>
          <select id="master_icon_path" name="master_icon_path">
              <option value="">Select Icon</option>
              <option value="dragon">Dragon</option>
              <option value="mermaid">Mermaid</option>
              <option value="fairy">Fairy</option>
              <option value="elf">Elf</option>
          </select>
      </div>

        <div class="form-group">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name">
        </div>

        <div class="form-group">
            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name">
        </div>

        <div class="form-group">
            <label for="country">Country:</label>
            <input type="text" id="country" name="country">
        </div>

        <div class="form-group">
            <label for="city">City:</label>
            <input type="text" id="city" name="city">
        </div>

        <div class="form-group">
            <label for="birthday">Birthday:</label>
            <input type="date" id="birthday" name="birthday">
        </div>

        <div class="form-group">
            <label for="gender">Gender:</label>
            <select id="gender" name="gender">
                <option value="">Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="prefer_not_say">Prefer not to say</option>
            </select>
        </div>

        <div class="form-group">
            <button type="submit">Sign Up</button>
            <a href="/" class="cancel-button">
              Cancel
            </a>
        </div>

    </form>
    

</body>
</html>