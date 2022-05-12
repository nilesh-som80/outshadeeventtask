<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PASSWORD RESET PAGE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <div class="container-md w-50 mt-5">
        <form class="mt-5" method="post" action="{{route("password.update")}}">
            @csrf
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
            </div>
            <div class="form-group">
                <label for="password_confirmation">Reenter above password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                    placeholder="Enter your password again">
            </div>
            <div>
                <input type="text" name="token" value="{{ $token }}">
                <input type="text" name="email" value="{{ $email }}">

            </div>

            <button type="submit" class="btn btn-primary mt-1">Submit</button>
        </form>
    </div>


</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


</html>
