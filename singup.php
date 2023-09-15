<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
      crossorigin="anonymous"
    />
  </head>
  <style>
    button {
      width: 100%;
    }
  </style>

  <body>
    <div
      class="container min-vh-100 d-flex justify-content-center align-items-center"
    >
      <form class="signup-form">
        <div class="form-group mb-2">
          <div class="row">
            <div class="col-md-6">
              <input
                type="text"
                class="form-control"
                placeholder="First Name"
              />
            </div>
            <div class="col-md-6">
              <input type="text" class="form-control" placeholder="Last Name" />
            </div>
          </div>
        </div>
        <div class="form-group mb-2">
          <input
            type="email"
            class="form-control"
            id="email"
            placeholder="Email"
          />
        </div>
        <div class="form-group mb-2">
          <input
            type="text"
            class="form-control"
            id="residence-address"
            placeholder="Residence Address"
          />
        </div>
        <div class="form-group mb-2">
          <input
            type="text"
            class="form-control"
            id="official-address"
            placeholder="Official Address"
          />
        </div>
        <div class="form-group mb-2">
          <input
            type="tel"
            class="form-control"
            id="mobile-no"
            placeholder="Mobile Number"
          />
        </div>
        <div class="form-group mb-2">
          <input
            type="tel"
            class="form-control"
            id="landline-no"
            placeholder="Landline Number"
          />
        </div>
        <div class="form-group mb-2">
          <div class="d-flex justify-content-center column-gap-5">
            <div class="form-check">
              <label class="form-check-label">
                <input
                  type="radio"
                  class="form-check-input"
                  name="gender"
                  value="male"
                />
                Male
              </label>
            </div>
            <div class="form-check">
              <label class="form-check-label">
                <input
                  type="radio"
                  class="form-check-input"
                  name="gender"
                  value="female"
                />
                Female
              </label>
            </div>
          </div>
        </div>
        <div class="form-group mb-2">
          <input
            type="text"
            class="form-control"
            id="student-id"
            placeholder="Student ID"
          />
        </div>
        <div class="form-group mb-2">
          <input
            type="password"
            class="form-control"
            id="password"
            placeholder="Password"
          />
        </div>
        <div class="form-group mb-2">
          <input
            type="password"
            class="form-control"
            id="confirm-password"
            placeholder="Confirm Password"
          />
        </div>
        <button type="submit" class="btn btn-primary">Sign Up</button>
      </form>
    </div>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
