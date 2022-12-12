<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <title>Document</title>
    <!-- Bootstrap CSS -->
    <style>
        *, *::after{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body{
            background-color: #5499c7;
        }
        .login-form {
            margin-left: 20px;
            margin-right: 20px;
            max-width: 670px;
            margin-bottom: 40px;
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }
        .login-form-inner {
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
            background: #f4f7fa;
            border-radius: 10px;
            padding: 30px;
            box-sizing: border-box;

        }
        .login-title {
            margin: 0;
        }
        .login-description {
            margin: 10px 0 34px 0;
        }
        .input-wrapper {
            margin-bottom: 15px;
        }
        .login-form .input-wrapper {
            margin-bottom: 15px;
        }
        .input-label {
            font-size: 14px;
            letter-spacing: 0.1px;
            line-height: 18px;
            display: block;
            margin-bottom: 10px;
            transition: color 0.3s ease-in-out;
            width: 100%;
            padding-right: 5px;
        }
        .input-input:not(:placeholder-shown):not(.error), .form-textarea-field:not(:placeholder-shown):not(.error) {
            border-color: #939fbc;
        }
        .login-form .input-input {
            max-width: 320px;
        }
        .input-input {
                border: 1px solid #c0d9e9;
                    border-top-color: rgb(192, 217, 233);
                    border-right-color: rgb(192, 217, 233);
                    border-bottom-color: rgb(192, 217, 233);
                    border-left-color: rgb(192, 217, 233);
                border-radius: 3px;
                background-color: #f4f7fa;
                box-shadow: inset 2px 2px 7px 0 #ffffff;
                height: 45px;
                width: 100%;
                font-size: 13px;
                padding-left: 12px;
                box-sizing: border-box;
                outline-width: 2px;
                display: flex;
            }

            .row {
                margin-top: 5px;
            }
            .login-submit-button {
                font-size: 13px;
                font-weight: bold;
                text-transform: none;
            }
            .modal-submit-login-button {
                margin: 0;
            }
            .button-special-offers-offer {
                padding: 17px 23px;
                margin: 15px auto;
                text-transform: uppercase;
                border-radius: 4px;
            }
            .button-secondary-color, .bookingPriceConfirmation .confirm-btn {
                background: linear-gradient(143.27deg, #007dc4 0%, #007dc4 100%);
                color: #fffffe;
                cursor: pointer;
                border: none;
            }
            .login-link-forgotten-password {
                margin-left: 100px;
                font-size: 13px;
                font-weight: bold;
                text-decoration: none;
            }
            .link {
                color: #007dc4;
                text-decoration: none;
            }
            .pointer {
                cursor: pointer;
            }
        @media only screen and (max-width: 670px) {
            .login-form {
                margin: 0 auto;
                margin-bottom: 0px;
                margin-bottom: 40px;
                width: 100%;
            }
            .login-form-inner {
                padding: 50px;
                margin: 25px;
            }
            .login-form .input-wrapper {
                display: flex;
                margin-left: 0px;
            }
            .login-form .input-wrapper .input-label {
                width: 28%;
                position: relative;
                top: 14px;
            }
            .login-submit-row{
                display: flex;
                flex-direction: column;
                justify-content: center;
            }
            .button-special-offers-offer{
                margin: 0 auto;
            }
            .login-link-forgotten-password{
                margin: 0 auto;
                margin-top: 15px;
            }

        }
        @media only screen and (min-width: 1010px){
            .login-form{
                width: 70%;
            }
            .input-wrapper {
                display: flex;
                margin-left: 0px;
            }
            .input-label {
                width: inherit;
            }
            .input-wrapper .input-label {
                width: 28%;
                position: relative;
                top: 14px;
            }
            .input-input {
                width: inherit;
                flex-grow: 1;
                max-width: 400px;
            }

        } 
    </style>

    </head>
<body>
    <div class="main-container">
        <div class="login-form">
            <div class="login-form-inner">
                <h1 class="login-title">Hi traveller,</h1>
                <p class="login-description">Type your Email and password to log in.</p>

                @if(session('active'))
                <div class="alert alert-success">
                  {{ session('active') }}
                </div> 
                @endif
                <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                    @csrf
                    <div class="input-wrapper ">
                        <span class="input-label" style="width:160px">Email</span>
                            <input type="email" id="input-login" autofocus="" name="email" id="email" class="input-input" required="" />
                            
                        </div>
                        @error('email')
                            <span class="" role="alert">
                                <strong class="text-dark">{{ $message }}</strong>
                            </span>
                            @enderror
                    <div class="input-wrapper ">
                        <span class="input-label" style="width:160px">Password</span>
                        <input type="password" id="input-password" name="password" id="password" class="input-input" required="" />
                       
                    </div>
                    @error('password')
                    <span class="" role="alert">
                        <strong class="text-dark">{{ $message }}</strong>
                    </span>
                    @enderror
                    <div class="input-wrapper input-wrapper-required">
                        <div class="input-label"></div>
                        <div class="login-submit-row">
                            <button type="submit" id="login-button"
                                class="button-special-offers-offer button-secondary-color modal-submit-button modal-submit-login-button login-submit-button">Log
                                in</button>
                                <a class="link pointer login-link-forgotten-password"
                                role="button" href="{{url('password/reset')}}">Forgotten password</a></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>