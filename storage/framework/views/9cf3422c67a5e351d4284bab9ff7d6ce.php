<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SafeCity — Connexion</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        :root {
            --grad-start:#b6e0ff;
            --grad-end:#f3b8d8;
            --card-bg:#ffffff;
            --accent:#ff7fbf;
            --muted:#94a3b8;
            --input:#e8f2fb;
        }

        body {
            background: linear-gradient(120deg, var(--grad-start), var(--grad-end));
            font-family: 'Inter', sans-serif;
        }

        /* MAIN CARD */
        .login-card {
            max-width: 980px;
            margin: 7vh auto;
            background: var(--card-bg);
            border-radius: 22px;
            overflow: hidden;
            display: grid;
            grid-template-columns: 1fr 420px;
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.14);
        }

        .left-side {
            padding: 55px;
        }

        .title {
            font-size: 38px;
            font-weight: 700;
            color: #0f172a;
        }

        /* INPUTS */
        input[type="email"], input[type="password"] {
            background: var(--input);
            border: none;
            outline: none;
            width: 100%;
            padding: 12px 16px;
            border-radius: 10px;
            color: #0f172a;
        }

        /* LOGIN BUTTON */
        .btn-login {
            background: linear-gradient(90deg, var(--accent), #ff9ac9);
            border-radius: 999px;
            color: #fff;
            font-weight: 600;
            padding: 11px 20px;
            width: 100%;
            box-shadow: 0px 6px 15px rgba(255, 127, 191, 0.25);
        }

        /* SOCIAL BUTTONS */
        .social-btn {
            border: 1px solid #e0e6ef;
            background: #fff;
            padding: 9px 14px;
            border-radius: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* RIGHT SIDE */
        .right-side {
            background: linear-gradient(180deg, rgba(255,255,255,0.45), rgba(255,255,255,0.75));
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* CHARACTER IMAGE */
        .character-img {
            width: 490px;
            height: 450px;
            background-image: url('/images/illustration.png');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            transform: scaleX(-1);
        }

        /* RESPONSIVE */
        @media(max-width: 900px) {
            .login-card {
                grid-template-columns: 1fr;
            }
            .right-side {
                display: none;
            }
        }
    </style>
</head>

<body>

<div class="login-card">

    <!-- LEFT SIDE (FORM) -->
    <div class="left-side">
        <!-- Enhanced Header -->
        <div class="flex items-center mb-2">
            <div class="w-8 h-8 bg-pink-500 rounded-full flex items-center justify-center mr-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                </svg>
            </div>
            <span class="text-2xl font-bold bg-gradient-to-r from-pink-500 to-purple-600 bg-clip-text text-transparent">SafeCity</span>
        </div>
        
        <div class="relative mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-1">Content de vous revoir !</h1>
            <p class="text-gray-500">Connectez-vous pour accéder à votre compte SafeCity</p>
            <div class="absolute -bottom-4 left-0 w-16 h-1 bg-gradient-to-r from-pink-500 to-purple-600 rounded-full"></div>
        </div>

        <!-- Success Message -->
        <?php if(session('status')): ?>
            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                <?php echo e(session('status')); ?>

            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-5">
            <?php echo csrf_field(); ?>

            <!-- EMAIL -->
            <div>
                <label class="text-sm text-gray-500">E-mail</label>
                <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus>
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-600 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- PASSWORD -->
            <div>
                <div class="flex justify-between mb-1">
                    <label class="text-sm text-gray-500">Mot de passe</label>
                    <a href="<?php echo e(route('password.request')); ?>" class="text-sm text-gray-400 hover:text-gray-600">
                        Mot de passe oublié ?
                    </a>
                </div>

                <input id="password" type="password" name="password" required>
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-600 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- LOGIN BUTTON -->
            <button type="submit" class="btn-login">SE CONNECTER →</button>

            <!-- OR CONTINUE -->
            <div class="text-center text-xs text-gray-400">ou continuez avec</div>

            <!-- Display any authentication errors -->
            <?php if($errors->any()): ?>
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">
                                <?php echo e($errors->first()); ?>

                            </p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- SOCIAL ICONS -->
            <div class="flex gap-4 justify-center pt-2">
                <!-- Google Login -->
                <a href="/auth/google" class="social-btn hover:bg-red-50 transition-colors duration-200" title="Login with Google" aria-label="Login with Google">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" width="22" alt="Google">
                </a>
            </div>

            <!-- SIGNUP LINK -->
            <div class="text-xs text-center mt-3 text-gray-500">
                Vous n'avez pas encore de compte ?
                <a href="<?php echo e(route('register')); ?>" class="text-pink-500 font-medium hover:underline">Inscrivez-vous gratuitement</a>
            </div>
        </form>
    </div>

    <!-- RIGHT SIDE (ILLUSTRATION) -->
    <div class="right-side">
        <div class="character-img"></div>
    </div>

</div>

</body>
</html>
<?php /**PATH C:\Users\zerni\CascadeProjects\windsurf-project-8\SafeCity\resources\views/auth/login.blade.php ENDPATH**/ ?>